<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param string EventCode
 * @param string EventCodeDesc
 */
class EventCode extends Model
{
    public $table = 'EventCode';
    public $primaryKey = 'EventCodeID';

    public $timestamps = false;

    public $fillable = [];
}
