@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $blogSource->name }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Configuration</h5>
            <dl class="row">
                <dt class="col-sm-3">URL</dt>
                <dd class="col-sm-9"><a href="{{ $blogSource->url }}" target="_blank">{{ $blogSource->url }}</a></dd>
                
                <dt class="col-sm-3">Post Selector</dt>
                <dd class="col-sm-9"><code>{{ $blogSource->post_selector }}</code></dd>
                
                <dt class="col-sm-3">Title Selector</dt>
                <dd class="col-sm-9"><code>{{ $blogSource->title_selector }}</code></dd>
                
                <dt class="col-sm-3">Content Selector</dt>
                <dd class="col-sm-9"><code>{{ $blogSource->content_selector }}</code></dd>
                
                @if($blogSource->date_selector)
                <dt class="col-sm-3">Date Selector</dt>
                <dd class="col-sm-9"><code>{{ $blogSource->date_selector }}</code></dd>
                @endif
                
                <dt class="col-sm-3">Crawl Interval</dt>
                <dd class="col-sm-9">{{ $blogSource->crawl_interval }} hours</dd>
                
                <dt class="col-sm-3">Last Crawled</dt>
                <dd class="col-sm-9">{{ $blogSource->last_crawled_at ? $blogSource->last_crawled_at->format('Y-m-d H:i:s') : 'Never' }}</dd>
            </dl>
            
            <div class="d-flex gap-2">
                <a href="{{ route('blog-sources.edit', $blogSource) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('blog-sources.destroy', $blogSource) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <form action="{{ route('blog-sources.crawl', $blogSource) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Crawl Now</button>
                </form>
            </div>
        </div>
    </div>
    
    <h2>Crawled Posts</h2>
    <!-- You can add a list of crawled posts here if needed -->
</div>
@endsection