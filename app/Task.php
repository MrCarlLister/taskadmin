<?php

namespace App;

use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    //
    use Notifiable;

    protected $fillable = [
        'description',
        'command',
        'expression',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email'
    ];

    public function getLastRunAttribute()
    {
        if ($last = $this->results()->orderBy('id', 'desc')->first()) {
            return $last->ran_at->setTimezone('Europe/London')->format('Y-m-d h:i A');
        }
        return 'N/A';
    }

    public function getAverageRuntimeAttribute()
    {
        return number_format($this->results()->avg('duration') / 1000, 2) . ' seconds';
    }

    /**
     * Gets the next run time for the task
     *
     * @return string
     */
    public function getNextRunAttribute()
    {
        return CronExpression::factory($this->getCronExpression())->getNextRunDate('now', 0, false, 'Europe/London')->format('Y-m-d h:i A');
    }

    /**
     * Returns the correct value from -> expression or the default cron expression if it is empty
     *
     * @return string
     */
    public function getCronExpression()
    {
        return $this->expression ?: '* * * * *';
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getActive()
    {

        return Cache::rememberForever('tasks.active', function () {
            return $this->getAll()->filter(function ($task) {
                return $task->is_active;
            });
        });
    }

    public function getAll()
    {
        return Cache::rememberForever('tasks.all', function () {
            return $this->all();
        });
    }

    public function routeNotificationForMail()
    {
        return $this->notification_email;
    }
}
