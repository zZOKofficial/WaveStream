@extends('layouts.admin')

@section('title', 'Manage Music')

@section('content')
<div class="container-fluid">
    <!-- Upload Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-dark border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Upload New Song</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.music.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control bg-dark text-white @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="artist" class="form-label">Artist</label>
                                <input type="text" class="form-control bg-dark text-white @error('artist') is-invalid @enderror" 
                                       id="artist" name="artist" value="{{ old('artist') }}" required>
                                @error('artist')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select bg-dark text-white @error('category_id') is-invalid @enderror" 
                                        id="category" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="audio_file" class="form-label">Audio File</label>
                                <input type="file" class="form-control bg-dark text-white @error('audio_file') is-invalid @enderror" 
                                       id="audio_file" name="audio_file" accept="audio/*" required>
                                @error('audio_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cover_image" class="form-label">Cover Image</label>
                                <input type="file" class="form-control bg-dark text-white @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" name="cover_image" accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Upload Song
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Song List -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Song List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Category</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($songs as $song)
                                <tr>
                                    <td>
                                        <img src="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : asset('images/default-album.png') }}" 
                                             alt="{{ $song->title }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $song->title }}</td>
                                    <td>{{ $song->artist }}</td>
                                    <td>{{ $song->category->name }}</td>
                                    <td>{{ $song->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.music.edit', $song) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.music.destroy', $song) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $songs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control, .form-select {
        border: 1px solid #333;
    }
    .form-control:focus, .form-select:focus {
        background-color: #181818;
        border-color: #1DB954;
        box-shadow: 0 0 0 0.25rem rgba(29, 185, 84, 0.25);
    }
    .table {
        margin-bottom: 0;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush
@endsection 