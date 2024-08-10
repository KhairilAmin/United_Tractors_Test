<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    protected $table = 'category_product';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    use HasFactory;
    use SoftDeletes;    
}
