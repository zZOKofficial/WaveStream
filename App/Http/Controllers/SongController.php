<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $songs = Song::with('category')->paginate(12);
        return view('songs.index', compact('songs'));
    }

    public function show(Song $song)
    {
        return view('songs.show', compact('song'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('songs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'audio_file' => 'required|file|mimes:mp3,wav|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $audioPath = $request->file('audio_file')->store('songs', 'public');
        
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        $song = Song::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'category_id' => $request->category_id,
            'audio_file' => $audioPath,
            'cover_image' => $coverPath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('songs.show', $song)
            ->with('success', 'Song uploaded successfully.');
    }

    public function edit(Song $song)
    {
        $categories = Category::where('is_active', true)->get();
        return view('songs.edit', compact('song', 'categories'));
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:mp3,wav|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($song->file_path);
            $validated['file_path'] = $request->file('file')->store('songs', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($song->cover_image) {
                Storage::disk('public')->delete($song->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $song->update($validated);

        return redirect()->route('songs.show', $song)
            ->with('success', 'Song updated successfully.');
    }

    public function destroy(Song $song)
    {
        Storage::disk('public')->delete($song->file_path);
        if ($song->cover_image) {
            Storage::disk('public')->delete($song->cover_image);
        }
        
        $song->delete();

        return redirect()->route('songs.index')
            ->with('success', 'Song deleted successfully.');
    }
} 