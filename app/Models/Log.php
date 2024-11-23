<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = "log";
    protected $fillable = [
        'id',
        'action',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(-User::class, 'user_id', 'id');
    }
}
