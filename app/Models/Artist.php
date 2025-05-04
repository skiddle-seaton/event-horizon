<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public $table = 'artists';
    public $primaryKey = 'artistID';

    public $timestamps = false;

    public $fillable = [];
}
