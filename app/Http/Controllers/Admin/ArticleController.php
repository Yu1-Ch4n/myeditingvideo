<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category'])->latest();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika pengguna adalah author, hanya tampilkan artikel miliknya
        if ($user && $user->isAuthor()) {
            $query->where('user_id', $user->id);
        }

        // Cek apakah ada parameter 'search' dalam request
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Tambahkan kondisi pencarian berdasarkan 'title' artikel
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
        $articles = $query->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        // Pastikan view yang benar: 'admin.articles.create'
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'meta_desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048', // 2MB Max
            'status' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menyimpan langsung ke disk 'public' di folder 'articles'
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Pastikan view yang benar: 'admin.articles.show'
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // Pastikan hanya pemilik artikel atau admin yang bisa mengedit
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $article->user_id && !$user->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        // Pastikan view yang benar: 'admin.articles.edit'
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Pastikan hanya pemilik artikel atau admin yang bisa mengupdate
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $article->user_id && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'meta_desc' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::disk('public')->delete($article->image); // Pastikan menghapus dari disk 'public'
            }
            // KOREKSI: Menyimpan langsung ke disk 'public' di folder 'articles'
            $imagePath = $request->file('image')->store('articles', 'public');
        } elseif ($request->input('remove_image')) {
            // Jika user memilih untuk menghapus gambar
            if ($article->image) {
                Storage::disk('public')->delete($article->image); //  Pastikan menghapus dari disk 'public'
                $imagePath = null;
            }
        }

        $article->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'meta_desc' => $request->meta_desc,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Pastikan hanya pemilik artikel atau admin yang bisa menghapus
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $article->user_id && !$user->isAdmin()) {
            abort(403);
        }

        if ($article->image) {
            Storage::disk('public')->delete($article->image); //Pastikan menghapus dari disk 'public'
        }

        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}