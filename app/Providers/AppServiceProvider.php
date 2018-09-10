<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         view()->composer('*',function($view) {
            $view->with('user', Auth::user()); 
              
              
            if(Auth::user()){
               if(Auth::user()->role == 3) $condition = "company";                        
               else if(Auth::user()->role == 2) $condition = "supervisor";                        
               else if(Auth::user()->role == 1) $condition = "admin";
               else $condition = "user";


               $view->with('adminMenu',DB::table('menus')->where('active','=','1')
                                     ->where($condition,'=',1)
                                     ->where('parent','=',0)->orderby('sort','asc')->get());

               $view->with('adminMenuSub',DB::table('menus')->where('active','=','1')
                                     ->where($condition,'=',1)
                                     ->where('parent','!=',0)->orderby('sort','asc')->get());
               }
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
}
