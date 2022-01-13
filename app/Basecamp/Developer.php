<?php

namespace App\Basecamp;

use App\Developer as DeveloperModel;
use App\Project;

/**
 * Class Todo.
 */
class Developer
{
    /**
     * Create a to-do associated with the working hours comment.
     *
     * @param \App\Project $project
     * @param              $data
     *
     * @return \App\Developer
     */
    public function updateOrCreate(Project $project, $data): DeveloperModel
    {
        $developer = DeveloperModel::updateOrCreate(
            ['basecamp_id' => $data->id],
            [
                'user_id' => $project->user->id,
                'account_id' => $project->account->id,
                'name' => $data->name,
                'email' => $data->email_address,
                'title' => $data->title,
                'avatar' => $data->avatar_url,
            ]
        );

        // Assign the developer to the project
        $project->developers()->syncWithoutDetaching([$developer->id]);

        return $developer;
    }
}
