<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationCustom  extends Model
{
    protected $fillable = [
        'user_id',
        'sender_id',
        'message',
        'read',
    ];

    // Resto de la implementación del modelo, como relaciones y métodos.
}
