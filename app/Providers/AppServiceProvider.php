<?php

namespace App\Providers;

use App\Enums\UserType;
use App\Http\Controllers\Site\WebsiteController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserManagement\RolePermissionController;
use App\Http\Repository\Language\LanguageRepository;
use App\Http\Repository\UtilityRepository;

class AppServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*', function ($view) {
            if (UtilityRepository::isSiteInstalled()==true) {
                $webController = new WebsiteController();
                $langRepo=new LanguageRepository();
                if (auth::check() && auth::user()->user_type == UserType::SystemUser) {
                    $rolePermission = new RolePermissionController;
                    View::share([
                        'menuList' => $rolePermission->getMenuList(),
                        'userInfo' => auth::user()->only('id', 'name', 'email', 'photo', 'username', 'is_sys_adm'),
                        'appearance' => $webController->getAppearance(),
                        'language'=>$langRepo->getLanguage()
                    ]);
                } else if (auth::check() && auth::user()->user_type == UserType::WebsiteUser) {
                    View::share([
                        'menuList' => $webController->getMenu(),
                        'appearance' => $webController->getAppearance(),
                        'userInfo' => auth::user()->only('id', 'name', 'email', 'photo', 'username', 'is_sys_adm'),
                        'language'=>$langRepo->getLanguage()
                    ]);
                } else {
                    View::share([
                        'menuList' => $webController->getMenu(),
                        'appearance' => $webController->getAppearance(),
                        'language'=>$langRepo->getLanguage()
                    ]);
                }
            }
        });
    }
}
