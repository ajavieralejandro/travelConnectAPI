<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subdomain', // Allow mass assignment for subdomain
        'template',  // Allow mass assignment for template
        // Add other fields that should be mass assignable here
    ];

    // Other model methods and properties can be added here
}
