<?php

namespace App\Http\Controllers;

use App\Tools\RedirectRecorder;
use App\Url;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function mainPage()
    {
        return view('welcome');
    }

    public function minify(Request $request)
    {
        $url = new Url;
        $url['url'] = $request['url'];
        $url['expires_at'] = $request['expires_at'];
        $url->save();

        return [
            'url' => url($url['id']),
            'info' => url("/info/$url->id]")
        ];
    }

    public function redirect($url_id)
    {
        // todo: check whether redirect is expired
        $url = Url::find($url_id);
        // todo: rework existence check (add view)
        if (!$url)
            return 'No such url';

        RedirectRecorder::record($url->id, request());
        return redirect($url->url);
    }

    public function info($url_id)
    {

    }
}
