<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'basecamp_id',
        'webhook_id',
        'name',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    /**
     * Gets the latest ten to-dos for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function onlyTenTodos()
    {
        return $this->todos()
            ->orderByDesc('updated_at')
            ->take(10);
    }

    /**
     * Gets the latest five developers for the project.
     *
     * @return mixed
     */
    public function onlyFiveDevelopers()
    {
        return $this->developers
            ->sortByDesc('name')
            ->take(5);
    }

    /**
     * Gets the latest ten developers for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Query\Builder
     */
    public function onlyTenDevelopers()
    {
        return $this->developers()
            ->take(10);
    }

    /**
     * Gets the latest three time trackers for the project.
     *
     * @return mixed
     */
    public function onlyThreeTrackers()
    {
        return $this->trackers
            ->sortByDesc('created_at')
            ->take(3);
    }

    /**
     * Detect if the project belongs to the given account.
     *
     * @param Account $account
     * @return bool
     */
    public function belongsToAccount(Account $account)
    {
        return $this->account_id === $account->id;
    }
}
