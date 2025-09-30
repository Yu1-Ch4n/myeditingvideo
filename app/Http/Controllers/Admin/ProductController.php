<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['user', 'type'])->latest();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika pengguna adalah author, hanya tampilkan produk miliknya
        if ($user && $user->isAuthor()) {
            $query->where('user_id', $user->id);
        }

        // Cek apakah ada parameter 'search' dalam request
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Tambahkan kondisi pencarian berdasarkan 'title' produk
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%');
            });
        }

        // Cek apakah ada parameter 'status' dalam request
        if ($request->has('status')) {
            // Pastikan status adalah boolean yang valid (0 atau 1)
            $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($status !== null) {
                $query->where('status', $status);
            }
        }

        // Ambil hasil paginasi
        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        // Pastikan view yang benar: 'admin.products.create'
        return view('admin.products.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'content' => 'required|string',
            'meta_desc' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048', // 2MB Max
            'status' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menyimpan langsung ke disk 'public' di folder 'products'
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(),
            'type_id' => $request->type_id,
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'sku' => $request->sku ?? strtoupper(Str::random(5)), 
            'image' => $imagePath,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Pastikan view yang benar: 'admin.products.show'
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Pastikan hanya pemilik produk atau admin yang bisa mengedit
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $product->user_id && !$user->isAdmin()) {
            abort(403);
        }

        $types = Type::all();
        // Pastikan view yang benar: 'admin.products.edit'
        return view('admin.products.edit', compact('product', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Pastikan hanya pemilik produk atau admin yang bisa mengupdate
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $product->user_id && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'meta_desc' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku' . $product->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image); // Pastikan menghapus dari disk 'public'
            }
            // KOREKSI: Menyimpan langsung ke disk 'public' di folder 'products'
            $imagePath = $request->file('image')->store('products', 'public');
        } elseif ($request->input('remove_image')) {
            // Jika user memilih untuk menghapus gambar
            if ($product->image) {
                Storage::disk('public')->delete($product->image); //  Pastikan menghapus dari disk 'public'
                $imagePath = null;
            }
        }

        $product->update([
            'type_id' => $request->type_id,
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'sku' => $request->sku ?? strtoupper(Str::random(5)),
            'image' => $imagePath,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Pastikan hanya pemilik produk atau admin yang bisa menghapus
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $product->user_id && !$user->isAdmin()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image); //Pastikan menghapus dari disk 'public'
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}