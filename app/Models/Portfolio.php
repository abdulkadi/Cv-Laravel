<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Portfolio extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable=[
        'name',
        'category',
        'demo',
        'url',
        'detail',
        'slug',


    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
