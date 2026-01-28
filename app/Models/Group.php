<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "group_name",
        "description"
   ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
