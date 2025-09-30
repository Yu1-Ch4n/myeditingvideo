<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Information::latest();

        // Cek apakah ada parameter 'search' dalam request
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Tambahkan kondisi pencarian berdasarkan nama atau email
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%');
            });
        }

        // Ambil hasil paginasi
        $information = $query->paginate(10);

        return view('admin.information.index', compact('information'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_desc' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        Information::create([
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        // Pastikan view yang benar: 'admin.information.show'
        return view('admin.information.show', compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        return view('admin.information.edit', compact('information'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_desc' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        $information->update([
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dihapus.');
    }
}