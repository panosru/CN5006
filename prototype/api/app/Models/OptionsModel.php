<?php

declare(strict_types=1);

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Maklad\Permission\Traits\HasRoles;

class OptionsModel extends Model
{
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'options';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'key',
        'value'
        //, 'address', 'city', 'state', 'zip', 'phone', 'email', 'schedule'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        '_id'
    ];

    protected $appends = [
        'id'
    ];

    protected string $guard_name = 'api';

    public function getIdAttribute($value = null): string
    {
        return $this->key;
    }
}
