<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company_infos';

    protected $fillable = [
        'c_name',
        'c_address',
        'c_logo',
        'c_phone',
        'c_phone1',
        'c_email',
        'c_fav_icon',
        'c_crncy_code'
    ];

}
