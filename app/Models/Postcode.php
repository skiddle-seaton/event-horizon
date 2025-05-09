<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param float $latitude
 * @param float $longitude
 */
class Postcode extends Model
{
    public $table = 'postcodes';
    public $primaryKey = '';

    public $timestamps = false;

    public $fillable = [];
}
