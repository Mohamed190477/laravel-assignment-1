<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'contact_person_name',
        'company_industry',
        'contact_person_phone_number',
        'email',
        'company_address',
        'longitude',
        'latitude',
        'company_size',
        'password',
        'image',
    ];
}
