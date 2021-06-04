<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dp extends Model
{
    //use HasFactory;
    public $table = "dp";

    protected $fillable = [
        'dp'
    ];

    public $timestamps = false;
}
