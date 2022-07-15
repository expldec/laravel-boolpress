@extends('layouts.dashboard')

@section('content')
    <h1>Lista dei tuoi post</h1>
    <div class="row">
        <div class="col">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary my-3">Crea post</a>
        </div>
    </div>
    <div class="row row-cols-3">
        @foreach ($posts as $post)
            {{-- Single post --}}
            <div class="col">
                <div class="card mb-3" style="width: 18rem;">
                    @if ($post->cover)
                        <img class="img-fluid" src="{{ asset('storage/' . $post->cover) }}" alt="">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-primary">Leggi
                            post</a>
                    </div>
                </div>
            </div>
            {{-- /Single post --}}
        @endforeach
    </div>
@endsection
