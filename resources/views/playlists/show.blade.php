@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-dark text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">{{ $playlist->name }}</h2>
                        <div class="btn-group">
                            <a href="{{ route('playlists.edit', $playlist) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this playlist?')">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($playlist->description)
                        <p class="text-muted mb-4">{{ $playlist->description }}</p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Songs</h4>
                        <a href="{{ route('songs.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Songs
                        </a>
                    </div>

                    @if($playlist->songs->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-music fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No songs in this playlist yet.</p>
                            <a href="{{ route('songs.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Add Songs
                            </a>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($playlist->songs as $song)
                                <div class="list-group-item bg-dark text-white border-secondary mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">{{ $song->title }}</h5>
                                            <p class="mb-1 text-muted">{{ $song->artist }}</p>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <form action="{{ route('playlists.songs.remove', $playlist) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="song_id" value="{{ $song->id }}">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
        transform: translateX(5px);
    }
    
    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection 