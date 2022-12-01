<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Categories;
use App\Models\Settings;
use Jenssegers\Agent\Agent;
class LoadServicesMiddleware
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
        if(empty(session('CURRENT_LANGUAGE'))){
            $request->session()->put('CURRENT_LANGUAGE', config('env.LANGUAGE_DEFAULT'));
        }

        /*$settings = Settings::get();
        $all_settings = [];
        if($settings){
            foreach($settings as $setting){
                $all_settings[$setting->setting_key] = $setting->value;
            }
        }*/


        Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
        $all_product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        \View::share('all_product_categories', $all_product_categories);

        \View::share('domain_name', config('env.DOMAIN_NAME'));

        $agent = new Agent();
        \View::share("is_mobile", $agent->isMobile());

        return $next($request);
    }
}
