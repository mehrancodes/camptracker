<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'project_id',
        'basecamp_id',
        'title',
        'url',
        'completed',
    ];

    /**
     * Get the basecamp developers associated with the todo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }

    /**
     * Get the project that owns the todo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the time trackers for the to-do.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->hasMany(Tracker::class)
            ->orderBy('developer_id', 'asc');
    }

    public function onlyThreeTrackers()
    {
        return $this
            ->trackers()
            ->orderByDesc('created_at')
            ->take(3);
    }
}
