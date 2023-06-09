<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Post
 *
 * @mixin Builder
 */
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
    ];
}
