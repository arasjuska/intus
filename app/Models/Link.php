<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Link extends Model
{
    protected $fillable = [
        'url',
        'hash',
    ];
}
