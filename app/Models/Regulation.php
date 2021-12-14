<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    public $table = 'regulations';
    public $incrementing = true;
    protected $primaryKey = 'guid';
    protected $fillable = [
        'guid',
        'link',
        'author',
        'title',
        'project_id',
        'project_created',
        'project_developer',
        'procedure',
        'kind'
    ];
}
