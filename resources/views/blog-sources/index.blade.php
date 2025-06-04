@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1>Blog Sources</h1>
        <a href="{{ route('blog-sources.create') }}" class="btn btn-primary">Add New Blog</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Last Crawled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogSources as $blog)
                <tr>
                    <td>{{ $blog->name }}</td>
                    <td><a href="{{ $blog->url }}" target="_blank">{{ $blog->url }}</a></td>
                    <td>{{ $blog->last_crawled_at ? $blog->last_crawled_at->diffForHumans() : 'Never' }}</td>
                    <td>
                        <a href="{{ route('blog-sources.edit', $blog) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('blog-sources.destroy', $blog) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        <form action="{{ route('blog-sources.crawl', $blog) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Crawl Now</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $blogSources->links() }}
</div>
@endsection