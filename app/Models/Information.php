<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable =[

        'id',
        'surname_Lastname',
        'personal_Information',
        'bday',
        'linkedin',
        'city',
        'mail',
        'degree',
        'career_Information',
        'short_image',
        'full_image',
        'job',
        'im'
    ];
}
