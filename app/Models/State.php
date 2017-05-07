<?php

namespace App\Models;

use App\Models\Contracts\InterfaceModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends AbstractModel implements InterfaceModel
{
    protected $table = 'states';

    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = ['id','name','initials'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'state_id', 'id');
    }

}