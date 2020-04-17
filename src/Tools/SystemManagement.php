<?php


namespace Tsung\Novaweb\Tools;


use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Tsung\Novaweb\Nova\Permission;
use Tsung\Novaweb\Nova\Role;
use Tsung\Novaweb\Nova\User;

class SystemManagement extends Tool
{
    public function boot()
    {
        Nova::script('novaweb', __DIR__ . '/../../dist/js/tool.js');

        Nova::resources([
            User::class,
            Role::class,
            Permission::class,
        ]);
    }

    public function renderNavigation()
    {
        return view("nova::tools.management");
    }
}