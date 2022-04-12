<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    // one role has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //table roles
    protected $table = 'roles';
}
