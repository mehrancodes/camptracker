<?php

namespace App\Basecamp;

use App\Project;
use App\Tracker;
use Carbon\Carbon;
use Facades\App\Basecamp\Developer;
use Facades\App\Basecamp\Todo;
use Facades\App\Basecamp\Utilities;

/**
 * Class Basecamp.
 */
class Comment
{
    public function updateOrCreate($bcComment, $projectId)
    {
        list($baseCampId, $baseCampTodo, $baseCampDeveloper, $content) = $this->initVariables($bcComment);

        // Check the if the comment parent is To-do
        if ($baseCampTodo->type !== 'Todo') {
            return;
        }

        // Get the working time from webhook
        if (! $time = Utilities::getTime($content)) {
            return;
        }

        $project = Project::where('basecamp_id', $projectId)
            ->with('account', 'user')
            ->first();

        // Don't continue the process if the project doesn't exists.
        if (is_null($project)) {
            return;
        }

        $description = Utilities::getDescription($content);
        $developer = Developer::updateOrCreate($project, $baseCampDeveloper);
        $todo = Todo::updateOrCreate($project, $developer, $baseCampTodo);
        $user = $project->user;
        $account = $project->account;

        $tracker = Tracker::updateOrCreate(
            ['basecamp_id' => $baseCampId],
            [
                'user_id' => $user->id,
                'account_id' => $account->id,
                'project_id' => $project->id,
                'todo_id' => $todo->id,
                'developer_id' => $developer->id,
                'basecamp_id' => $baseCampId,
                'duration' => $time,
                'description' => $description,
                'created_at' => Carbon::parse($bcComment->created_at),
                'updated_at' => Carbon::parse($bcComment->updated_at),
            ]
        );

        return collect([
            'todo' => $todo,
            'developer' => $developer,
            'project' => $project,
            'user' => $user,
            'tracker' => $tracker,
            'account' => $account,
        ]);
    }

    /**
     * @param \Belvedere\Basecamp\Models\Comment $bcComment
     *
     * @return array
     */
    private function initVariables($bcComment): array
    {
        $baseCampId = $bcComment->id;
        $baseCampTodo = $bcComment->parent;
        $baseCampDeveloper = $bcComment->creator;
        $content = $bcComment->content;

        return [$baseCampId, $baseCampTodo, $baseCampDeveloper, $content];
    }
}
