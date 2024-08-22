<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Moodle_Users extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_users';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'participant_id',
        'auth',
        'userpicturepath',
        'userpicture',
        'json_response',
        'created_by',
        'updated_by'
    ];

    public $timestamps = true;

    //function for generate firstname and lastname for moodle user parameter
    public static function GenerateFirstLastNameFromFullname($name)
    {
        $name_array = explode(" ", trim(strtolower($name)));

        return [
            'firstname' => $name_array[0],
            'lastname' => end($name_array)
        ];
    }

    //function for generating username from name and participant_id
    public static function GenerateUsernameFromParticipantData($participant_id, $firstname, $lastname)
    {
        $pattern = " ";
        $name = $firstname . " " . $lastname;

        $firstPart = strstr(strtolower($name), $pattern, true);
        $secondPart = substr(strstr(strtolower($name), $pattern, false), 0,3);
        $nrRand = $participant_id;
        
        $username = trim($firstPart).trim($secondPart).trim($nrRand);

        return $username;
    }
}
?>