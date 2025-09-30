<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Untuk logging error
use Illuminate\Validation\Rule; // Untuk validasi enum status

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua pesanan dengan eager loading user dan item produk
        // Mengurutkan dari yang terbaru
        $orders = Order::with('user', 'items.product')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan tertentu.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Order $order)
    {
        // Eager load relasi yang diperlukan untuk detail order
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'processing', 'completed', 'cancelled', 'refunded'])],
            'payment_status' => ['required', 'string', Rule::in(['pending', 'paid', 'failed', 'refunded'])],
        ]);

        try {
            $order->status = $request->status;
            $order->payment_status = $request->payment_status;
            $order->save();

            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Order status update failed: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus pesanan.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        try {
            // Hapus semua item pesanan terkait terlebih dahulu
            $order->items()->delete();
            // Kemudian hapus pesanan itu sendiri
            $order->delete();

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Order deletion failed: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}
