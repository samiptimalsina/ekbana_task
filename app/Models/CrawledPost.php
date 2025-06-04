<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrawledPost extends Model
{
    //

        protected $fillable = [
        'blog_source_id', 'url', 'title', 'content', 'original_date'
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(BlogSource::class, 'blog_source_id');
    }
}
