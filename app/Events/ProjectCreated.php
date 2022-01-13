<?php

namespace App\Events;

use App\Account;
use App\Project;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Project
     */
    public $project;

    /**
     * @var \App\Account
     */
    public $account;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Account $account
     * @param \App\Project $project
     * @param              $user
     */
    public function __construct(Account $account, Project $project, $user)
    {
        $this->account = $account;
        $this->project = $project;
        $this->user = $user;
    }
}
