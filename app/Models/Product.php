<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'Product_name',
        'description',
        'section_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function sections()
    {
        return $this->belongsToMany(sections::class);
    }
}
