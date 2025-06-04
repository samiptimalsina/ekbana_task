@extends('layouts.app')

@section('content')
<div class="container">
    <article>
        <h1>{{ $post->title }}</h1>
        <div class="text-muted mb-3">
            Source: <a href="{{ $post->blog->url }}" target="_blank">{{ $post->blog->name }}</a> • 
            Published: {{ $post->original_date->format('F j, Y') }}
        </div>
        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>
        <a href="{{ $post->url }}" target="_blank" class="btn btn-primary mt-3">View Original</a>
    </article>
</div>
@endsection