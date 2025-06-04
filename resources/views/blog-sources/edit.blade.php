@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Blog Source</h4>
                        <a href="{{ route('blog-sources.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('blog-sources.update', $blogSource) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Blog Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $blogSource->name) }}" required>
                            <div class="form-text">The display name for this blog</div>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Blog URL *</label>
                            <input type="url" class="form-control" id="url" name="url" 
                                   value="{{ old('url', $blogSource->url) }}" required>
                            <div class="form-text">Full URL of the blog homepage</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_selector" class="form-label">Post Selector *</label>
                            <input type="text" class="form-control" id="post_selector" name="post_selector" 
                                   value="{{ old('post_selector', $blogSource->post_selector) }}" required>
                            <div class="form-text">CSS selector for post containers (e.g., "article.post")</div>
                        </div>

                        <div class="mb-3">
                            <label for="title_selector" class="form-label">Title Selector *</label>
                            <input type="text" class="form-control" id="title_selector" name="title_selector" 
                                   value="{{ old('title_selector', $blogSource->title_selector) }}" required>
                            <div class="form-text">CSS selector for post titles (e.g., "h2.title")</div>
                        </div>

                        <div class="mb-3">
                            <label for="content_selector" class="form-label">Content Selector *</label>
                            <input type="text" class="form-control" id="content_selector" name="content_selector" 
                                   value="{{ old('content_selector', $blogSource->content_selector) }}" required>
                            <div class="form-text">CSS selector for post content (e.g., "div.post-content")</div>
                        </div>

                        <div class="mb-3">
                            <label for="date_selector" class="form-label">Date Selector</label>
                            <input type="text" class="form-control" id="date_selector" name="date_selector" 
                                   value="{{ old('date_selector', $blogSource->date_selector) }}">
                            <div class="form-text">Optional CSS selector for post dates (e.g., "time.post-date")</div>
                        </div>

                        <div class="mb-3">
                            <label for="crawl_interval" class="form-label">Crawl Interval (hours) *</label>
                            <input type="number" class="form-control" id="crawl_interval" name="crawl_interval" 
                                   min="1" value="{{ old('crawl_interval', $blogSource->crawl_interval) }}" required>
                            <div class="form-text">How often to check for new posts (in hours)</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Blog Source
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection