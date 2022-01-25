<?php

declare(strict_types=1);

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;
use Maklad\Permission\Traits\HasRoles;

class HallModel extends Model
{
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'halls';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'number';

    protected $keyType = 'integer';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'number',
        'rows',
        'seats_per_row',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        '_id'
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    protected string $guard_name = 'api';

    protected $appends = [
        'capacity',
        'id'
    ];

    final public function shows(): HasMany
    {
        return $this->hasMany(ShowModel::class, 'hall_number');
    }

    final public function getIdAttribute($value = null)
    {
        return $this->number;
    }

    final public function getCapacityAttribute(): int
    {
        return $this->rows * $this->seats_per_row;
    }
}
