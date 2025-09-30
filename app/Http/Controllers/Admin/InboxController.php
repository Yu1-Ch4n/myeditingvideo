<?php

namespace App\Http\Controllers\Admin;
use App\Models\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::latest();

        // Cek apakah ada parameter 'search' dalam request
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Tambahkan kondisi pencarian berdasarkan nama atau email
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('subject', 'like', '%' . $searchTerm . '%');
            });
        }

        // Ambil hasil paginasi
        $inbox = $query->paginate(10);

        return view('admin.inbox.index', compact('inbox'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function toggleStatus(Contact $inbox)
    {
        // Balikkan nilai status (true menjadi false, false menjadi true)
        $inbox->status = !$inbox->status;
        $inbox->save();

        return redirect()->route('admin.inbox.index')->with('success', 'Status pesan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $inbox)
    {
        $inbox->delete();
        return redirect()->route('admin.inbox.index')->with('success', 'Pesan berhasil dihapus.');
    }
}