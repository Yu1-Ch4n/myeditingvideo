<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Mengambil atau membuat objek keranjang (Cart) berdasarkan user_id atau session_id.
     */
    protected function getOrCreateCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $sessionId = Session::getId();
            $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();
            if ($guestCart && $guestCart->id !== $cart->id) {
                foreach ($guestCart->items as $guestItem) {
                    $existingItem = $cart->items()->where('product_id', $guestItem->product_id)->first();
                    if ($existingItem) {
                        $existingItem->quantity += $guestItem->quantity;
                        $existingItem->save();
                    } else {
                        $guestItem->cart_id = $cart->id;
                        $guestItem->save();
                    }
                }
                $guestCart->delete();
            }
            $cart->session_id = null;
            $cart->save();
            return $cart;
        } else {
            $sessionId = Session::getId();
            return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
        }
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function addToCart(Product $product, Request $request)
    {
        // Tambahkan validasi role di sini juga jika Anda ingin mencegah admin/author menambahkan ke keranjang sama sekali
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAuthor())) {
            return redirect()->back()->with('error', 'Hanya user yang dapat menambahkan produk ke keranjang.');
        }

        $cart = $this->getOrCreateCart();
        $quantityToAdd = (int) $request->input('quantity', 1);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        $currentQuantityInCart = $cartItem ? $cartItem->quantity : 0;
        $newTotalQuantity = $currentQuantityInCart + $quantityToAdd;

        if ($newTotalQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Stok ' . $product->title . ' tidak cukup. Tersedia: ' . $product->stock . '. Anda sudah memiliki ' . $currentQuantityInCart . ' item di keranjang.');
        }

        try {
            DB::beginTransaction();
            if ($cartItem) {
                $cartItem->quantity = $newTotalQuantity;
                $cartItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantityToAdd,
                    'price_at_add' => $product->price,
                    'discount_at_add' => $product->discount,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', $product->title . ' berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add to cart failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan isi keranjang belanja.
     */
    public function showCart()

    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();

        $subtotal = 0;
        $totalDiscount = 0;
        $total = 0;

        foreach ($cartItems as $item) {
            if (!$item->product) {
                $item->delete();
                continue;
            }

            $itemPrice = $item->price_at_add;
            $itemQuantity = $item->quantity;
            $itemDiscountPercent = $item->discount_at_add; // Asumsi ini persentase, e.g., 20 atau 10

            // Hitung total harga item sebelum diskon
            $subtotalItem = $itemPrice * $itemQuantity;

            // Hitung jumlah diskon untuk item ini
            $discountAmount = ($subtotalItem * $itemDiscountPercent) / 100;

            // Hitung total harga setelah diskon
            $finalItemPrice = $subtotalItem - $discountAmount;

            // Tambahkan ke total keseluruhan
            $subtotal += $subtotalItem;
            $totalDiscount += $discountAmount;
            $total += $finalItemPrice;
        }

        return view('home.cart.show', compact('cartItems', 'subtotal', 'totalDiscount', 'total'));
    }

    /**
     * Memperbarui kuantitas produk di keranjang.
     */
    public function updateCart(Request $request, $slug)
    {
        // Tambahkan validasi role di sini juga jika Anda ingin mencegah admin/author memodifikasi keranjang
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAuthor())) {
            return redirect()->back()->with('error', 'Hanya user yang dapat memperbarui keranjang.');
        }

        $cart = $this->getOrCreateCart();
        $quantity = (int) $request->input('quantity');
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('cart.show')->with('error', 'Produk tidak ditemukan atau sudah tidak tersedia.');
        }
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        if (!$cartItem) {
            return redirect()->route('cart.show')->with('error', 'Produk tidak ada di keranjang Anda.');
        }
        if ($quantity <= 0) {
            try {
                $cartItem->delete();
                return redirect()->route('cart.show')->with('success', 'Produk berhasil dihapus dari keranjang.');
            } catch (\Exception $e) {
                Log::error('Remove cart item failed: ' . $e->getMessage());
                return redirect()->route('cart.show')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
            }
        }
        if ($quantity > $product->stock) {
            $cartItem->quantity = $product->stock;
            $cartItem->save();
            return redirect()->route('cart.show')->with('error', 'Stok ' . $product->title . ' tidak cukup. Tersedia: ' . $product->stock . '. Kuantitas telah disesuaikan.');
        }
        try {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return redirect()->route('cart.show')->with('success', 'Kuantitas produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Update cart quantity failed: ' . $e->getMessage());
            return redirect()->route('cart.show')->with('error', 'Gagal memperbarui kuantitas: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function removeCart($slug)
    {
        // Tambahkan validasi role di sini juga jika Anda ingin mencegah admin/author menghapus dari keranjang
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAuthor())) {
            return redirect()->back()->with('error', 'Hanya user yang dapat menghapus produk dari keranjang.');
        }

        $cart = $this->getOrCreateCart();
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('cart.show')->with('error', 'Produk tidak ditemukan atau sudah tidak tersedia.');
        }
        try {
            $cartItem = $cart->items()->where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->delete();
                return redirect()->route('cart.show')->with('success', 'Produk berhasil dihapus dari keranjang.');
            }
            return redirect()->route('cart.show')->with('error', 'Produk tidak ada di keranjang Anda.');
        } catch (\Exception $e) {
            Log::error('Remove cart item failed: ' . $e->getMessage());
            return redirect()->route('cart.show')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman checkout.
     * Mengisi form secara otomatis jika user login.
     */
    public function checkout()
    {
        // Tambahkan validasi role di sini
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAuthor())) {
            return redirect()->route('home.products.index')->with('error', 'Hanya user yang dapat melakukan checkout.');
        }

        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('info', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $subtotal = 0;
        $totalDiscount = 0;
        $total = 0;

        foreach ($cartItems as $item) {
            if (!$item->product) {
                $item->delete();
                continue;
            }
            $itemPrice = $item->price_at_add;
            $itemQuantity = $item->quantity;
            $itemDiscountPercent = $item->discount_at_add; // Asumsi ini persentase, e.g., 20 atau 10

            // Hitung total harga item sebelum diskon
            $subtotalItem = $itemPrice * $itemQuantity;

            // Hitung jumlah diskon untuk item ini
            $discountAmount = ($subtotalItem * $itemDiscountPercent) / 100;

            // Hitung total harga setelah diskon
            $finalItemPrice = $subtotalItem - $discountAmount;

            // Tambahkan ke total keseluruhan
            $subtotal += $subtotalItem;
            $totalDiscount += $discountAmount;
            $total += $finalItemPrice;
        }


        $user = Auth::user(); // Dapatkan pengguna yang sedang login
        $defaultAddress = [
            'address' => '',    // Sesuai dengan kolom 'address' di tabel users
            'city' => '',
            'province' => '',
            'postal_code' => '',
        ];

        if ($user) {
            $defaultAddress['address'] = $user->address ?? '';
            $defaultAddress['city'] = $user->city ?? '';
            $defaultAddress['province'] = $user->province ?? '';
            $defaultAddress['postal_code'] = $user->postal_code ?? '';
        }

        return view('home.checkout.index', compact('cartItems', 'subtotal', 'totalDiscount', 'total', 'user', 'defaultAddress'));
    }

    /**
     * Memproses pesanan dan menyimpannya ke database.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processCheckout(Request $request)
    {
        // Validasi role: Hanya user biasa yang bisa melakukan checkout
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAuthor())) {
            return redirect()->route('home')->with('error', 'Hanya user yang dapat melakukan checkout.');
        }

        // Validasi data input dari form checkout
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:255',
            'shipping_province' => 'required|string|max:255',
            'shipping_postal_code' => 'nullable|string|max:10',
            'payment_method' => 'required|string|in:transfer_bank,cod,midtrans',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Keranjang Anda kosong. Tidak dapat memproses checkout.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $totalDiscount = 0;
            $finalTotalAmount = 0;

            // Validasi Stok Final dan Perhitungan Total
            foreach ($cartItems as $item) {
                $product = $item->product;

                if (!$product) {
                    DB::rollBack();
                    Log::error("Product with ID {$item->product_id} not found for cart item ID {$item->id} during checkout process.");
                    return redirect()->back()->with('error', 'Satu atau lebih produk di keranjang Anda tidak lagi tersedia atau telah dihapus.');
                }
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok untuk produk "' . $product->title . '" tidak cukup (' . $product->stock . ' tersedia). Harap periksa kembali keranjang Anda.');
                }

                $itemPrice = $item->price_at_add;
                $itemQuantity = $item->quantity;
                $itemDiscount = $item->discount_at_add;

                $totalItemPrice = $itemPrice * $itemQuantity;

                // Asumsi $itemDiscount adalah persentase (e.g., 20)
                if ($itemDiscount > 0) {
                    $discountAmount = ($totalItemPrice * $itemDiscount) / 100;
                    $totalDiscount += $discountAmount;
                    $finalTotalAmount += $totalItemPrice - $discountAmount;
                } else {
                    $finalTotalAmount += $totalItemPrice;
                }
            }

            // Buat Order baru
            $order = new Order();
            $order->user_id = Auth::check() ? Auth::id() : null;
            $order->order_number = 'INV-' . time() . '-' . Str::upper(Str::random(6));
            $order->total_amount = $finalTotalAmount;
            $order->status = 'pending';
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'pending';
            $order->customer_name = $request->customer_name;
            $order->customer_email = $request->customer_email;
            $order->customer_phone = $request->customer_phone;
            $order->shipping_address = $request->shipping_address;
            $order->shipping_city = $request->shipping_city;
            $order->shipping_province = $request->shipping_province;
            $order->shipping_postal_code = $request->shipping_postal_code;
            $order->save();

            // Simpan item-item pesanan dan kurangi stok
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product->id;
                $orderItem->product_name = $item->product->title;
                $orderItem->product_sku = $item->product->sku;
                $orderItem->product_image = $item->product->image;
                $orderItem->quantity = $item->quantity;
                $orderItem->price_per_unit = $item->price_at_add;
                $orderItem->discount_per_unit = $item->discount_at_add;
                $orderItem->save();

                // Kurangi stok produk
                $productToUpdate = $item->product;
                $productToUpdate->stock -= $item->quantity;
                $productToUpdate->save();

                // Hapus item dari keranjang setelah berhasil dipindahkan ke order
                $item->delete();
            }

            // Hapus keranjang itu sendiri setelah semua item dipindahkan
            $cart->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->order_number)->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi. (' . $e->getMessage() . ')');
        }
    }

    /**
     * Menampilkan halaman sukses checkout.
     * @param string $orderNumber
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function checkoutSuccess($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }
        return view('home.checkout.success', compact('orderNumber', 'order'));
    }
}
