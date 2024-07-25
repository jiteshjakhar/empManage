<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'date_of_birth', 'contact_number', 'email', 'street', 'city', 'state', 'zip_code',
        'expected_ctc', 'status'
    ];

    // Experiences relationship
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    //Educations relationship
    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
