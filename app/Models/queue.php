<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $table = 'queues';

    protected $fillable = [
        'state'
    ];

    public function users() {
        return $this->hasMany('App\Models\QueuePlayers','queue_id');
    }
}
