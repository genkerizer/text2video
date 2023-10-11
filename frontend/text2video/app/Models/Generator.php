<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    use HasFactory;
    protected $table     = 'generators';
    protected $fillable  = ['description_prompt', 'inputvideo', 'outputvideo','language'];
    public $timestamps   = true;
}
