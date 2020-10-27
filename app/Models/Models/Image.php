<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    const TYPE_ORIGINAL = 1;
    const TYPE_SQUARE   = 2;
    const TYPE_SMALL    = 3;
    const TYPE_ALL      = 4;
}
