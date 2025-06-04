<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index()
    {
        $posts = CrawledPost::with('blog')
            ->latest('original_date')
            ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    public function show(CrawledPost $post)
    {
        return view('blog.show', compact('post'));
    }

    public function crawl(BlogCrawlerService $crawler, BlogSource $blog)
    {
        $result = $crawler->crawlBlog($blog);
        
        return back()->with('status', $result ? 'Crawl successful!' : 'Crawl failed');
    }
}
