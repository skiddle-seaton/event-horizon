<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param int GenreId
 * @param string GenreName
 */
class Genre extends Model
{
    public $table = 'Genres';
    public $primaryKey = 'GenreID';

    public $timestamps = false;

    public $fillable = [];
}
