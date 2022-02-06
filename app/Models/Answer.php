<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $number
 * @property string $text
 */
class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'round_id',
        'number',
        'text'
    ];
}