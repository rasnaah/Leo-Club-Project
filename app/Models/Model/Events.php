<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    //use HasFactory;
    public $table = "event";

    protected $fillable = [
        'title',
        'club',
        'date',
        'time',
        'image',
        'description'
    ];

    public $timestamps = false;

    /*    public function setDateAttribute($value)
        {
            $this->attributes['date'] = Carbon::createFromFormat('yyyy/mm/dd', $value)->toDateString();
        }*/
    /*    public function setTimeAttribute($value)
        {
            $this->attributes['time'] = Carbon::createFromFormat('yyyy/mm/dd', $value)->toDateString();
        }*/
}
