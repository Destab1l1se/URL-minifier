<?php
/**
 * Created by PhpStorm.
 * User: kovalchuk.v
 * Date: 20/08/2018
 * Time: 15:24
 */

namespace App\Tools;


use App\Redirect;

class RedirectRecorder
{
    public static function record($url_id, \Illuminate\Http\Request $request)
    {
        $redirect = new Redirect();
        $redirect['url_id'] = $url_id;
        $redirect['ip'] = $request->ip();

        $redirect['language'] = substr($request->server('HTTP_ACCEPT_LANGUAGE'),0,5);

        $browser_info = get_browser($request->header('User-Agent'));
        $redirect['browser'] = $browser_info->parent;
        $redirect['javascript'] = $browser_info->javascript;
        $redirect['vbscript'] = $browser_info->vbscript;
        $redirect['javaapplets'] = $browser_info->javaapplets;
        $redirect['cssversion'] = $browser_info->cssversion;

        $redirect->save();
    }
}