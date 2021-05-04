<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name', 'user', 'members', 'actions'];
    use HasFactory;
}
