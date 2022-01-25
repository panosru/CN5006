<?php
declare(strict_types=1);

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Maklad\Permission\Traits\HasRoles;

class TicketModel extends Model
{
    use HasRoles;

    /**
     * The collection associated with the model.
     * @var string
     */
    protected $collection = 'tickets';

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
        'id', 'row', 'seat', 'show_id', 'user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '_id',
    ];

    protected $appends = [
        'human_seat'
    ];

    protected string $guard_name = 'api';

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function show()
    {
        return $this->belongsTo(ShowModel::class, 'show_id');
    }

    public function getHumanSeatAttribute()
    {
        return \range('A', 'Z')[$this->row - 1] . ' ' . $this->seat;
    }
}
