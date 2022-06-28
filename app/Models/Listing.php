<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'user_id', 'location', 'website', 'tags', 'email', 'description', 'logo'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag']) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }
        if ($filters['search']) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    //Relation to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
