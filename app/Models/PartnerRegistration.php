<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PartnerRegistration extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql_secondary'; // Use the secondary DB
    protected $table = 'partner_registrations'; // Your actual table

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
}
