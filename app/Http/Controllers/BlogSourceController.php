<?php

namespace App\Http\Controllers;

use App\Models\BlogSource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\BlogCrawlerService;

class BlogSourceController extends Controller
{
    public function index()
    {
        $blogSources = BlogSource::latest()->paginate(10);
        return view('blog-sources.index', compact('blogSources'));
    }

    /**
     * Show the form for creating a new blog source.
     */
    public function create()
    {
        return view('blog-sources.create');
    }

    /**
     * Store a newly created blog source.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'post_selector' => 'required|string',
            'title_selector' => 'required|string',
            'content_selector' => 'required|string',
            'date_selector' => 'nullable|string',
            'crawl_interval' => 'required|integer|min:1'
        ]);

        BlogSource::create($validated);

        return redirect()->route('blog-sources.index')
                         ->with('success', 'Blog source added successfully!');
    }

    /**
     * Display the specified blog source.
     */
    public function show(BlogSource $blogSource)
    {
        return view('blog-sources.show', compact('blogSource'));
    }

    /**
     * Show the form for editing the blog source.
     */
    public function edit(BlogSource $blogSource)
    {
        return view('blog-sources.edit', compact('blogSource'));
    }

    /**
     * Update the specified blog source.
     */
    public function update(Request $request, BlogSource $blogSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'post_selector' => 'required|string',
            'title_selector' => 'required|string',
            'content_selector' => 'required|string',
            'date_selector' => 'nullable|string',
            'crawl_interval' => 'required|integer|min:1'
        ]);

        $blogSource->update($validated);

        return redirect()->route('blog-sources.index')
                         ->with('success', 'Blog source updated successfully!');
    }

    /**
     * Remove the specified blog source.
     */
    public function destroy(BlogSource $blogSource)
    {
        $blogSource->delete();

        return redirect()->route('blog-sources.index')
                         ->with('success', 'Blog source deleted successfully!');
    }

    /**
     * Trigger manual crawl for a blog source.
     */
    public function crawl(BlogSource $blogSource, BlogCrawlerService $crawler)
    {
        $result = $crawler->crawlBlog($blogSource);
        
        return back()->with(
            $result ? 'success' : 'error',
            $result ? 'Crawl completed successfully!' : 'Crawl failed! Check logs for details.'
        );
    }
}
