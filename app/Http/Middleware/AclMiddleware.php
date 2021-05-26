<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Route;

class AclMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url_list=array(   
            'home'                               =>  array(1,2,3),
            'list_user'                          =>  array(1,2,3),
            'add_user'                           =>  array(1,2),
            'save_user'                          =>  array(1,2),
            'edit_user'                          =>  array(1,2),
            'update_user'                        =>  array(1,2),
            'delete_user'                        =>  array(1,2),
            'export_user'                        =>  array(1,2,3),

            'list_category'                      =>  array(1,2,3),
            'add_category'                       =>  array(1,2),
            'save_category'                      =>  array(1,2),
            'edit_category'                      =>  array(1,2),
            'update_category'                    =>  array(1,2),
            'delete_category'                    =>  array(1,2),

            'list_product'                       =>  array(1,2,3),
            'add_product'                        =>  array(1,2),
            'save_product'                       =>  array(1,2),
            'edit_product'                       =>  array(1,2),
            'update_product'                     =>  array(1,2),
            'delete_product'                     =>  array(1,2)
        );

         $user_role = Auth::user()->role;
         $route = Route::current()->getName();

         if(isset($url_list[$route]) && in_array($user_role, $url_list[$route])){
            return $next($request);
        }

        return redirect(url('/home'));
    }
}
