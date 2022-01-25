<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;
use Maklad\Permission\Traits\HasRoles;

class MovieModel extends Model
{
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'movies';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'title',
        'year',
        'image',
        'duration',
        'plot',
        'directors',
        'stars',
        'genres',
        'country',
        'language',
        'rating',
        'trailer'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        '_id'
    ];

    protected string $guard_name = 'api';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'directors' => 'array',
        'stars' => 'array',
        'genres' => 'array'
    ];

    final public function shows(): HasMany
    {
        return $this->hasMany(ShowModel::class, 'movie_id')
            ->where('datetime', '>', Carbon::now('Europe/Athens'));
    }
}
