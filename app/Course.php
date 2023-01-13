<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function units(){
        return $this->hasMany(CourseUnit::class);
    }
}
