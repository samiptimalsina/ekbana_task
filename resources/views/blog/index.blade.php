@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crawled Blog Posts</h1>
    
    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                From: {{ $post->blog->name }} • 
                {{ $post->original_date->diffForHumans() }}
            </h6>
            <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
            <a href="{{ route('blog.show', $post) }}" class="card-link">Read more</a>
        </div>
    </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection