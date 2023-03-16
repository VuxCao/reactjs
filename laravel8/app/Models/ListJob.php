<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListJob
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListJob whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListJob extends Model
{
    use HasFactory;
    protected $table = 'list_jobs';
    protected $fillable =
        [
            'name',
        ];
}
