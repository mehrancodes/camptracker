<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'basecamp_id',
        'name',
        'href',
    ];

    /**
     * Get the user owns the basecamp account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the projects for the basecamp account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the developers for the basecamp account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function developers()
    {
        return $this->hasMany(Developer::class);
    }
}
