@extends('layouts.dashboard')

@section('content')
    <h1> {{ $post->title }} </h1>
    <p>Slug: {{ $post->slug }}</p>
    <p>Categoria: {{ $category ? $category->name : 'nessuna categoria' }}</p>
    <p><strong>Tags: </strong>

        @forelse ($post->tags as $tag)
            {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
        @empty
            nessuno
        @endforelse
    </p>
    <p>{{ $post->content }}</p>

    <a class="btn btn-primary" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica</a>
    <form class="d-inline-block" action="{{ route('admin.posts.destroy', [ 'post' => $post->id ]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onClick="return confirm('You sure??');">Cancella</button>
    </form>
@endsection