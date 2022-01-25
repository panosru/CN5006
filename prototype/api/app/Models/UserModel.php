<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;
use Maklad\Permission\Traits\HasRoles;
use Ramsey\Uuid\Uuid;

class UserModel extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'users';
    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'surname', 'email', 'api_key'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '_id', 'password',
    ];

    protected $appends = [
        'full_name'
    ];

    protected string $guard_name = 'api';

    final public function tickets(): HasMany
    {
        return $this->hasMany(TicketModel::class, 'user_id');
    }

    final public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public static function createToken(): string
    {
        return \base64_encode(Uuid::uuid4()->toString());
    }
}
