<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSource extends Model
{
    //

        protected $fillable = [
        'name', 'url', 'post_selector', 'title_selector',
        'content_selector', 'date_selector', 'crawl_interval'
    ];

        public function posts(): HasMany
    {
        return $this->hasMany(CrawledPost::class);
    }
}
