<?php
/**
 * Created by PhpStorm.
 * User: kovalchuk.v
 * Date: 20/08/2018
 * Time: 15:24
 */

namespace App\Tools;


use App\RedirectFact;

class RedirectLogger
{
    // could be made with facade or DI
    public static function log($url_id, \Illuminate\Http\Request $request)
    {
        $redirect = new RedirectFact;
        $redirect['url_id'] = $url_id;

        $lang_code = substr($request->server('HTTP_ACCEPT_LANGUAGE'),0,2);
        $redirect['language'] = RedirectLoggerHelper::lang_code_to_lang_name($lang_code);
        $redirect['browser'] = get_browser($request->header('User-Agent'))->parent;
        if ($ip = $request->ip() != '127.0.0.1')
            $redirect['country'] = RedirectLoggerHelper::ip_to_country($request->ip());
        else $redirect['country'] = 'localhost';

        $redirect->save();
    }
}