<?php

namespace App\Console\Commands;

use App\Models\BlogSource;
use Illuminate\Console\Command;
use App\Services\BlogCrawlerService;

class CrawlBlogs extends Command
{
    protected $signature = 'crawl:blogs {--blog= : ID of specific blog to crawl}';
    protected $description = 'Crawl all registered blogs';

    public function handle(BlogCrawlerService $crawler)
    {
        $query = BlogSource::where(function($q) {
            $q->whereNull('last_crawled_at')
              ->orWhere('last_crawled_at', '<', now()->subHours(24));
        });

        if ($this->option('blog')) {
            $query->where('id', $this->option('blog'));
        }

        $blogs = $query->get();

        if ($blogs->isEmpty()) {
            $this->info('No blogs need crawling right now.');
            return;
        }

        foreach ($blogs as $blog) {
            $this->info("Crawling blog: {$blog->name} ({$blog->url})");
            $success = $crawler->crawlBlog($blog);
            $this->info($success ? 'Success!' : 'Failed!');
        }

        $this->info('Crawling completed!');
    }
}
