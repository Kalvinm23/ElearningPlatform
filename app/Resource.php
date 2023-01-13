<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public function assignments(){
        return $this->hasMany(AssignmentResource::class);
    }
}
