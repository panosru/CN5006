<?php
declare(strict_types=1);

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class RoleModel extends Model
{
    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name',
        'permission_ids',
        'user_model_ids',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        '_id' => 'string',
        'permission_ids' => 'array',
        'user_model_ids' => 'array'
    ];
}
