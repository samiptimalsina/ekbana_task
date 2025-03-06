<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    //

    protected $table = "company_categories";

    protected $guarded=[];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
