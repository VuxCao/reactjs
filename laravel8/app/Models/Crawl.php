<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Crawl
 *
 * @property int $id
 * @property string $name
 * @property string $employer
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl query()
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Crawl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Crawl extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'employer', 'address'];
}
