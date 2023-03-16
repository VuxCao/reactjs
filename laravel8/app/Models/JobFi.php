<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobFi
 *
 * @property int $id
 * @property string $name
 * @property string $open_positions
 * @property string $location
 * @property string $website
 * @property string $founded
 * @property string $employees
 * @property string $industries
 * @property string $business_model
 * @property string $funding_state
 * @property string $details
 * @property string $benefits
 * @property string $team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereBusinessModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereEmployees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereFounded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereFundingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereIndustries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereOpenPositions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobFi whereWebsite($value)
 * @mixin \Eloquent
 */
class JobFi extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'open_positions',
            'location',
            'website',
            'founded',
            'employees',
            'industries',
            'business_model',
            'funding_state',
            'details',
            'benefits',
            'team',
        ];
}
