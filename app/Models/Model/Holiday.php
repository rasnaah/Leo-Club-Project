<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    //use HasFactory;
    public $table = "holiday";

    protected $fillable = [

        'holiday',
        'date'
    ];

    public $timestamps = false;

}
