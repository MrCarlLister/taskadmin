<?php

namespace App\Providers;

use App\Events\TaskExecutedEvent;
use App\Observers\TaskObserver;
use App\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Task $task)
    {
        $task::observe(TaskObserver::class);
        $this->app->resolving(Schedule::class, function ($schedule) {
            $this->schedule($schedule);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function schedule(Schedule $schedule)
    {
        // Fetch all the active tasks

        $tasks = app('App\Task')->getActive();

        // LOOP THROUGH TASKS
        foreach ($tasks as $task) {
            $tempFile = storage_path('task-' . sha1($task->command . $task->expression));

            // SCHEDULE THE TASK 'COMMAND'
            $event = $schedule->exec($task->command);
            $event
                ->cron($task->expression)
                ->before(function () use ($event) {
                    $event->start = microtime(true);
                })
                ->after(function () use ($event, $task) {
                    $elapsed_time = microtime(true) - $event->start;
                    event(new TaskExecutedEvent($task, $elapsed_time));
                })
                ->sendOutputTo(storage_path('task-' . sha1($task->command . $task->expression)));

            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }
        }
        // Schedule tasks
    }
}
