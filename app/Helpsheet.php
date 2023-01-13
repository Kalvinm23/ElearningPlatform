<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpsheet extends Model
{
    public function assignments(){
        return $this->hasMany(AssignmentHelpsheet::class);
    }
}
