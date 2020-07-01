<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Projects extends Model
{
    use SoftDeletes;

    protected $fillable = ["project_name"];
}
