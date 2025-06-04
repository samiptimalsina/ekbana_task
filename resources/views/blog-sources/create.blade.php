@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Blog Source</h1>
    
    <form action="{{ route('blog-sources.store') }}" method="POST">
        @csrf
        
        <div class="form-group mb-3">
            <label for="name">Blog Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="url">Blog URL</label>
            <input type="url" name="url" id="url" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="post_selector">Post Selector (CSS)</label>
            <input type="text" name="post_selector" id="post_selector" class="form-control" required>
            <small class="text-muted">e.g., "article.post" or "div.blog-item"</small>
        </div>
        
        <div class="form-group mb-3">
            <label for="title_selector">Title Selector (CSS)</label>
            <input type="text" name="title_selector" id="title_selector" class="form-control" required>
            <small class="text-muted">e.g., "h2.title"</small>
        </div>
        
        <div class="form-group mb-3">
            <label for="content_selector">Content Selector (CSS)</label>
            <input type="text" name="content_selector" id="content_selector" class="form-control" required>
            <small class="text-muted">e.g., "div.post-content"</small>
        </div>
        
        <div class="form-group mb-3">
            <label for="date_selector">Date Selector (CSS) - Optional</label>
            <input type="text" name="date_selector" id="date_selector" class="form-control">
            <small class="text-muted">e.g., "time.post-date"</small>
        </div>
        
        <div class="form-group mb-3">
            <label for="crawl_interval">Crawl Interval (hours)</label>
            <input type="number" name="crawl_interval" id="crawl_interval" class="form-control" value="24" min="1" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Blog Source</button>
    </form>
</div>
@endsection