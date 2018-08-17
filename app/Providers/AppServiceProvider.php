<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\User;
use App\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);        

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // Sidebar menu items
            $owners = [
                'text' => 'Owners',
                'url' => 'owners',
                'icon' => 'users',
                'label'       => $this->getBadgeNumber('owners'),
                'label_color' => 'success'
            ];

            $inspectors = [
                'text' => 'Inspectors',
                'url' => 'inspectors',
                'icon' => 'users',
                'label'       => $this->getBadgeNumber('inspectors'),
                'label_color' => 'success'
            ];

            $pending_tasks = [
                'text' => 'Pending Jobs',
                'url' => 'pending-jobs',
                'icon' => 'tasks',
                'label'       => $this->getBadgeNumber('pending-jobs'),
                'label_color' => 'success'
            ];

            $finished_tasks = [
                'text' => 'Finished Jobs',
                'url' => 'finished-jobs',
                'icon' => 'tasks',
                'label'       => $this->getBadgeNumber('finished-jobs'),
                'label_color' => 'success'
            ];

            // add menu items
            $event->menu->add(
                $owners,
                $inspectors,
                $pending_tasks,
                $finished_tasks
            );
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

    /**
     * Get the number for sidebar badge.
     *
     * @return Integer
     */
    protected function getBadgeNumber($menu_name)
    {
        switch ($menu_name) {
            case 'owners':
                return User::role('owner')->count();
                break;
            case 'inspectors':
                return User::role('inspector')->count();
                break;
            case 'pending-jobs':
                return Task::where('status', '!=', 3)->count();
                break;
            case 'finished-jobs':
                return Task::where('status', 3)->count();
                break;
            
            default:
                return 0;
                break;
        }
    }
}