<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'product';

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class);
    }
    use HasFactory;
    use SoftDeletes;
}
