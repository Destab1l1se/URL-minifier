<?php

namespace App\Http\Controllers;

use App\Tools\RedirectLogger;
use App\Tools\UrlGenerator;
use App\Url;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function minify(Request $request)
    {
        $url = new Url;
        $url['redirects_to'] = $request['redirects_to'];
        // todo: make url validation
        $url['path'] = $request['custom-url'] ?? UrlGenerator::generate();
        $url['expires_at'] = $request['expires_at'];
        $url->save();

        return [
            'url' => url($url['path']),
            'info' => url("/info/{$url['path']}")
        ];
    }

    public function redirect($path)
    {
        // todo: check whether redirect is expired
        $url = Url::where('path',$path)->first();
        // todo: rework existence check (add view)
        if (!$url)
            return 'No such url';

        RedirectLogger::log($url->id, request());
        return redirect($url['redirects_to']);
    }

    public function info($path)
    {

    }
}
