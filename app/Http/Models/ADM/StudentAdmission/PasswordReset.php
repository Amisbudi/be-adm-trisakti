<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'password_reset';

    protected $fillable = [ 
        'username',
        'token',
        'participant_id',
    ];
}
