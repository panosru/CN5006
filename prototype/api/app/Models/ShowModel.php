<?php

declare(strict_types=1);

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\BelongsTo;
use Jenssegers\Mongodb\Relations\HasMany;
use Maklad\Permission\Traits\HasRoles;

class ShowModel extends Model
{
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'shows';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'movie_id',
        'hall_number',
        'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $hidden = [
        '_id'
    ];

    protected string $guard_name = 'api';

    final public function tickets(): HasMany
    {
        return $this->hasMany(TicketModel::class, 'show_id');
    }

    final public function movie(): BelongsTo
    {
        return $this->belongsTo(MovieModel::class, 'movie_id');
    }

    final public function hall(): BelongsTo
    {
        return $this->belongsTo(HallModel::class, 'hall_number');
    }
}
