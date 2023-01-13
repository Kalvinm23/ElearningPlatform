<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function resources(){
        return $this->hasMany(AssignmentResource::class);
    }
    public function helpsheets(){
        return $this->hasMany(AssignmentHelpsheet::class);
    }
}
