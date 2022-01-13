<?php

namespace App\Listeners;

use Basecamp;
use Facades\App\Basecamp\Comment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class BasecampEventSubscriber implements ShouldQueue
{
    protected $notifications;

    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\ProjectCreated',
            'App\Listeners\BasecampEventSubscriber@handleProjectCreated'
        );
    }

    /**
     * Handle user login events.
     *
     * @param $event
     */
    public function handleProjectCreated($event)
    {
        $user = $event->user;
        $account = $event->account;
        $project = $event->project;

        if ($this->AddBaseCampWebhook($user, $account, $project)) {
            // event to sync project's to-do comments to track current hours
            $bcProject = Basecamp::projects()->show($project->basecamp_id);
            $recordings = Basecamp::recordings();
            $comments = $recordings->index('Comment', [
                'bucket' => $bcProject->id,
            ]);

            // Handle the pagination to get all the projects
            do {
                foreach ($comments->all() as $comment) {
                    Comment::updateOrCreate($comment, $project->basecamp_id);
                }

                $nextPage = $comments->nextPage();
                $comments = $recordings->index('Comment', [
                    'bucket' => $bcProject->id,
                ], $nextPage);
            } while ($nextPage);

            // Notify the user a new tracker has been added.
            $this->notifications->create($user, [
                'icon' => 'fa-refresh',
                'body' => "Project \"{$project->name}\" has been added, as well as developers hours",
            ]);
        }
    }

    private function AddBaseCampWebhook($user, $account, $project): bool
    {
        $this->initBasecamp($user, $account);

        $basecampProject = Basecamp::projects()
            ->show($project->basecamp_id);

        $webhookUrl = env('BASECAMP_WEBHOOK_URL').'/'.$basecampProject->id;
        $thereIsNotAnyWebhook = $basecampProject
            ->webhooks()
            ->index()
            ->filter(function ($webhook) use ($webhookUrl) {
                return $webhook->payload_url === $webhookUrl;
            })
            ->isEmpty();

        if ($thereIsNotAnyWebhook) {
            // Create a new webhook
            $basecampProject->webhooks()->store([
                'payload_url' => $webhookUrl,
                'types' => ['Comment', 'Todo'],
            ]);
        }

        return true;
    }

    private function initBasecamp($user, $account)
    {
        Basecamp::init([
            'id' => $account->basecamp_id,
            'href' => $account->href,
            'token' => $user->token,
            'refresh_token' => $user->refresh_token,
        ]);

        Basecamp::setCache(Cache::store('redis'));

        Basecamp::setMiddlewares([
            \GuzzleHttp\Middleware::log(
                app('log')->getLogger(),
                new \GuzzleHttp\MessageFormatter('{method} {uri} HTTP/{version} {req_body}')
            ),
        ]);
    }
}
