<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCode extends Model
{
    public $table = 'EventCode';
    public $primaryKey = 'EventCodeID';

    public $timestamps = false;

    public $fillable = [];
}
