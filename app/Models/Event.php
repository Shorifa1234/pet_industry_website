<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'featured_image',
        'event_type', 'start_date', 'end_date', 'location', 'venue', 'city',
        'country', 'website_url', 'registration_url', 'price', 'is_free',
        'is_featured', 'status', 'organizer', 'tags'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')->where('start_date', '>=', now());
    }
}
