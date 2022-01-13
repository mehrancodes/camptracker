<?php

namespace App\Basecamp;

use App\Developer;
use App\Project;
use App\Todo as TodoModel;

/**
 * Class Todo.
 */
class Todo
{
    /**
     * Create a to-do associated with the working hours comment.
     *
     * @param \App\Project   $project
     * @param \App\Developer $developer
     * @param                $data
     *
     * @return \App\Todo
     */
    public function updateOrCreate(Project $project, Developer $developer, $data): TodoModel
    {
        $todo = TodoModel::updateOrCreate(
            ['basecamp_id' => $data->id],
            [
                'user_id' => $project->user->id,
                'account_id' => $project->account->id,
                'project_id' => $project->id,
                'title' => $data->title,
                'url' => $data->app_url,
            ]
        );

        // Assign the to-do to the developer
        $todo->developers()->syncWithoutDetaching([$developer->id]);

        return $todo;
    }
}
