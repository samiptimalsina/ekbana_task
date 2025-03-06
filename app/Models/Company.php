<?php

namespace App\Models;

use App\Models\CompanyCategory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //

    protected $guarded=['id'];

    protected $casts = [
        'status' => 'integer',
    ];
    public function category()
    {
        return $this->belongsTo(CompanyCategory::class);
    }
}
