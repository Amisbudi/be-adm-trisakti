<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participants';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'username',
        'password',
        'fullname',
        'telutizen_status',
        'telutizen_student_id',
        'gender',
        'religion',
        'birth_country',
        'birth_province',
        'birth_city',
        'birth_place',
        'birth_date',
        'nationality',
        'origin_country',
        'identify_number',
        'passport_number',
        'passport_expiry_date',
        'marriage_status',
        'children_total',
        'address_country',
        'address_province',
        'address_city',
        'address_disctrict',
        'address_detail',
        'address_postal_code',
        'house_phone_number',
        'mobile_phone_number',
    	'created_by',
    	'updated_by',
        'isverification',
        'email_verified_at',
        'photo_url',
        'color_blind',
        'special_needs',
        'birth_province_foreign',
        'birth_city_foreign',
        'nisn',
        'nis',
        'size_almamater',
        'diploma_number'
    ];
    public $timestamps = true;

    public static function GetParticipant($email)
    {
        $result = Participant::select('fullname as name','username','photo_url')
                ->where('username',$email)
                ->get();
        return $result;
    }

    public static function GenerateFirstLastNameFromFullname($name)
    {
        $name_array = explode(" ", trim(strtolower($name)));

        return [
            'firstname' => $name_array[0],
            'lastname' => end($name_array)
        ];
    }
}
?>