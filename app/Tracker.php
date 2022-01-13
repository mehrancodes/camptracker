<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'project_id',
        'todo_id',
        'developer_id',
        'basecamp_id',
        'duration',
        'description',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the project that owns the tracker.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the developer that owns the tracker.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    /**
     * Get the to-do that owns the tracker.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
