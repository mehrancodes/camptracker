<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'basecamp_id',
        'name',
        'email',
        'title',
        'title',
        'avatar',
    ];

    /**
     * Get the time trackers for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    /**
     * Get the basecamp projects for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get the to-dos for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function todos()
    {
        return $this->belongsToMany(Todo::class);
    }

    /**
     * Gets the latest ten projects for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Query\Builder
     */
    public function lastTenProjects()
    {
        return $this
            ->projects()
            ->orderByDesc('created_at')
            ->take(10);
    }

    /**
     * Gets the latest ten to-dos for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Query\Builder
     */
    public function lastTenTodos()
    {
        return $this
            ->todos()
            ->orderByDesc('created_at')
            ->take(10);
    }

    /**
     * Gets the latest ten time trackers for the developer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function lastTenTrackers()
    {
        return $this
            ->trackers()
            ->orderByDesc('created_at')
            ->take(10);
    }
}
