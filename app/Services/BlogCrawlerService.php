<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\BlogSource;
use App\Models\CrawledPost;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BlogCrawlerService
{
    protected $client;
    protected $timeout = 30;
    protected $maxRedirects = 5;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'timeout' => $this->timeout,
            'max_redirects' => $this->maxRedirects,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (compatible; Laravel Crawler/1.0)',
                'Accept' => 'text/html,application/xhtml+xml',
            ]
        ]);
    }

    public function crawlBlog(BlogSource $blog): bool
    {
        try {
            Log::info("Starting crawl for blog: {$blog->name} ({$blog->url})");

            $response = $this->client->get($blog->url);
            
            if (!$response->successful()) {
                throw new \Exception("HTTP request failed with status: {$response->status()}");
            }

            $html = $response->body();
            $crawler = new Crawler($html);

            $postUrls = $crawler->filter($blog->post_selector)
                ->each(function (Crawler $node) use ($blog) {
                    try {
                        $link = $node->filter('a')->first()->attr('href');
                        return $this->normalizeUrl($link, $blog->url);
                    } catch (\Exception $e) {
                        Log::warning("Failed to extract link from post node: " . $e->getMessage());
                        return null;
                    }
                });

            // Filter out null values
            $postUrls = array_filter($postUrls);

            if (empty($postUrls)) {
                Log::warning("No post links found for blog: {$blog->name}");
                return false;
            }

            $successCount = 0;
            foreach ($postUrls as $postUrl) {
                if ($this->crawlPost($blog, $postUrl)) {
                    $successCount++;
                }
            }

            $blog->update(['last_crawled_at' => now()]);
            Log::info("Crawl completed for {$blog->name}. Successfully crawled {$successCount}/" . count($postUrls) . " posts");
            
            return $successCount > 0;

        } catch (\Exception $e) {
            Log::error("Crawling failed for blog {$blog->id}: " . $e->getMessage());
            return false;
        }
    }

    protected function crawlPost(BlogSource $blog, string $url): bool
    {
        if (CrawledPost::where('url', $url)->exists()) {
            Log::debug("Post already exists, skipping: {$url}");
            return false;
        }

        try {
            Log::debug("Crawling post: {$url}");
            $startTime = microtime(true);

            $response = $this->client->get($url);
            
            if (!$response->successful()) {
                throw new \Exception("HTTP request failed with status: {$response->status()}");
            }

            $crawler = new Crawler($response->body());

            $postData = [
                'title' => $this->cleanText($this->extractText($crawler, $blog->title_selector)),
                'content' => $this->cleanText($this->extractText($crawler, $blog->content_selector)),
            ];

            if ($blog->date_selector) {
                try {
                    $dateText = $this->extractText($crawler, $blog->date_selector);
                    $postData['original_date'] = $this->parseDate($dateText);
                } catch (\Exception $e) {
                    Log::warning("Failed to parse date for post {$url}: " . $e->getMessage());
                }
            }

            // Generate excerpt if needed
            if (!isset($postData['excerpt'])) {
                $postData['excerpt'] = Str::limit($postData['content'], 200);
            }

            $blog->posts()->create($postData + ['url' => $url]);

            $duration = round(microtime(true) - $startTime, 2);
            Log::debug("Successfully crawled post in {$duration}s: {$url}");

            return true;

        } catch (\Exception $e) {
            Log::error("Failed to crawl post {$url}: " . $e->getMessage());
            return false;
        }
    }

    protected function extractText(Crawler $crawler, string $selector): string
    {
        try {
            return $crawler->filter($selector)->first()->text();
        } catch (\Exception $e) {
            throw new \Exception("Failed to extract text using selector '{$selector}': " . $e->getMessage());
        }
    }

    protected function normalizeUrl(string $url, string $baseUrl): string
    {
        if (empty($url)) {
            throw new \Exception("Empty URL provided");
        }

        // If URL already has scheme, return as-is
        if (parse_url($url, PHP_URL_SCHEME)) {
            return $url;
        }

        // Handle protocol-relative URLs
        if (strpos($url, '//') === 0) {
            return parse_url($baseUrl, PHP_URL_SCHEME) . ':' . $url;
        }

        // Handle root-relative URLs
        if (strpos($url, '/') === 0) {
            $base = parse_url($baseUrl);
            return $base['scheme'] . '://' . $base['host'] . $url;
        }

        // Handle relative URLs
        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }

    protected function cleanText(string $text): string
    {
        $text = html_entity_decode($text);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        return strip_tags($text);
    }

    protected function parseDate(string $dateString): Carbon
    {
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            Log::warning("Failed to parse date '{$dateString}': " . $e->getMessage());
            return now();
        }
    }
}