<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'image',
        'slug',
    ];

    /**
 * Get the route key for the model.
 */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function Type(){
        return $this->belongsTo(Type::class);
    }
}
