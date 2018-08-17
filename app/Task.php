<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'deadline', 'description', 'status', 'rate',
    ];

    /**
     * Get the user that owns the task.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
