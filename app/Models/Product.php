<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = ['id','created_at','updated_at'];

    // داخل كلاس Product
public function category()
{
    return $this->belongsTo(Category::class);
}

public function dosage()
{
    return $this->belongsTo(Dosage::class);
}
public function company()
{
    return $this->belongsTo(Company::class);
}
}
