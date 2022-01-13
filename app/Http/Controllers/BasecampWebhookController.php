<?php

namespace App\Http\Controllers;

use App\Project;
use App\Todo;
use App\Tracker;
use Facades\App\Basecamp\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class BasecampWebhookController extends Controller
{
    /**
     * Handle a Stripe webhook call.
     *
     * @param \Illuminate\Http\Request $request
     * @param $BaseCampProjectId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request, $BaseCampProjectId)
    {
        $payload = json_decode($request->getContent());

        $method = 'handle'.Str::studly(str_replace('.', '_', $payload->kind));

        if (method_exists($this, $method)) {
            return $this->{$method}($payload, $BaseCampProjectId);
        }

        // Make Sure to always send the 200 response in all of the situations!
        return $this->responseOk();
    }

    /**
     * Create a time tracker record for the given to-do.
     *
     * @param $payload
     * @param $BaseCampProjectId
     * @return Response
     */
    public function handleCommentCreated($payload, $BaseCampProjectId)
    {
        $comment = Comment::updateOrCreate($payload->recording, $BaseCampProjectId);

        if ($comment) {
            // Notify the user a new tracker has been added.
            $this->notifications->create($comment->get('user'), [
                'icon' => 'fa-clock-o',
                'body' => "\"{$comment->get('developer')->name}\" added a tracker to project \"{$comment->get('project')->name}\"",
                'action_text' => 'View Todo',
                'action_url' => route('accounts.projects.todos.show', [
                    $comment->get('account')->id,
                    $comment->get('project')->id,
                    $comment->get('todo')->id,
                ]),
            ]);
        }

        return $this->responseOk();
    }

    /**
     * Update a time tracker record for the given to-do.
     *
     * @param $payload
     * @param $BaseCampProjectId
     * @return Response
     */
    public function handleCommentContentChanged($payload, $BaseCampProjectId)
    {
        $comment = Comment::updateOrCreate($payload->recording, $BaseCampProjectId);

        if ($comment) {
            // Notify the user a new tracker has been updated.
            $this->notifications->create($comment->get('user'), [
                 'icon' => 'fa-refresh',
                 'body' => "\"{$comment->get('developer')->name}\" updated a tracker in project \"{$comment->get('project')->name}\"",
                 'action_text' => 'View Todo',
                 'action_url' => route('accounts.projects.todos.show', [
                     $comment->get('account')->id,
                     $comment->get('project')->id,
                     $comment->get('todo')->id,
                 ]),
             ]);
        }

        return $this->responseOk();
    }

    /**
     * Mark a to-do as done.
     *
     * @param $payload
     * @param $BaseCampProjectId
     * @return Response
     */
    public function handleTodoCompleted($payload, $BaseCampProjectId)
    {
        $baseCampTodoId = $payload->recording->id;
        $creator = $payload->creator;
        $todo = Todo::where('basecamp_id', $baseCampTodoId)->first();

        // Ignore the to-dos that not exists in the database.
        if (isset($todo)) {
            $project = Project::where('basecamp_id', $BaseCampProjectId)
                ->with('account', 'user')
                ->firstOrFail();

            $todo->update(['completed' => true]);

            // Notify the user the to-do done.
            $this->notifications->create($project->user, [
                'icon' => 'fa-check-square-o',
                'body' => "\"{$creator->name}\" marked a todo as completed in project \"{$project->name}\"",
                'action_text' => 'View Todo',
                'action_url' => route('accounts.projects.todos.show', [$project->account->id, $project->id, $todo->id]),
            ]);
        }

        return $this->responseOk();
    }

    /**
     * Return back the to-do to in progress.
     *
     * @param $payload
     * @param $BaseCampProjectId
     * @return Response
     */
    public function handleTodoUncompleted($payload, $BaseCampProjectId)
    {
        $baseCampTodoId = $payload->recording->id;
        $creator = $payload->creator;
        $todo = Todo::where('basecamp_id', $baseCampTodoId)->first();

        // Ignore the todos that not exists in the database.
        if (isset($todo)) {
            $project = Project::where('basecamp_id', $BaseCampProjectId)
                ->with('account', 'user')
                ->firstOrFail();

            $todo->update(['completed' => false]);

            // Notify the user the to-do done.
            $this->notifications->create($project->user, [
                'icon' => 'fa-square-o',
                'body' => "\"{$creator->name}\" marked a todo as uncompleted in project \"{$project->name}\"",
                'action_text' => 'View Todo',
                'action_url' => route('accounts.projects.todos.show', [$project->account->id, $project->id, $todo->id]),
            ]);
        }

        return $this->responseOk();
    }

    public function handleTodoTrashed($payload, $BaseCampProjectId)
    {
        return $this->handleTodoDeleted($payload, $BaseCampProjectId);
    }

    public function handleTodoDeleted($payload, $BaseCampProjectId): Response
    {
        $baseCampTodoId = $payload->recording->id;
        $creator = $payload->creator;
        $todo = Todo::where('basecamp_id', $baseCampTodoId)->first();

        // Ignore the to-dos that not exists in the database.
        if (isset($todo)) {
            $project = Project::where('basecamp_id', $BaseCampProjectId)
                ->with('user')
                ->firstOrFail();

            // Remove the to-do
            $todoTitle = substr($todo->title, 0, 25).'...';
            $todo->delete();

            // Notify the user the to-do done.
            $this->notifications->create($project->user, [
                'icon' => 'fa-trash-o',
                'body' => "\"{$creator->name}\" removed todo \"{$todoTitle}\" from project \"{$project->name}\"",
            ]);
        }

        return $this->responseOk();
    }

    public function handleCommentTrashed($payload, $BaseCampProjectId)
    {
        return $this->handleCommentDeleted($payload, $BaseCampProjectId);
    }

    public function handleCommentDeleted($payload, $BaseCampProjectId): Response
    {
        $baseCampCommentId = $payload->recording->id;
        $creator = $payload->creator;
        $tracker = Tracker::where('basecamp_id', $baseCampCommentId)->first();

        // To-do's title string limited by character
        $todoTitle = $payload->recording->parent->title;
        $todoTitle = substr($todoTitle, 0, 25).'...';

        // Ignore the to-dos that not exists in the database.
        if (isset($tracker)) {
            $project = Project::where('basecamp_id', $BaseCampProjectId)
                ->with('user')
                ->firstOrFail();

            // Remove the to-do
            $tracker->delete();

            // Notify the user the to-do done.
            $this->notifications->create($project->user, [
                'icon' => 'fa-trash-o',
                'body' => "\"{$creator->name}\" removed comment for todo \"{$todoTitle}\" from project \"{$project->name}\"",
            ]);
        }

        return $this->responseOk();
    }

    /**
     * Handle response to all calls.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responseOk()
    {
        return new Response('Webhook Handled', 200);
    }
}
