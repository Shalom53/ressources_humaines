<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSanction extends Model
{
    use HasFactory;

    protected $table = 'type_sanctions';

    protected $fillable = [
        'nom',
        'etat',
        'reduction',
    ];
}

