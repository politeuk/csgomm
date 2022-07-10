<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueuePlayers extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_id',
        'user_id',
        'state',
        'updated_at'
    ];

    public function queue() {
        return $this->belongsTo('App\Models\Queue', 'id');
    }
}
