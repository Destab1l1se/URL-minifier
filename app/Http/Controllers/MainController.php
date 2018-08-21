<?php

namespace App\Http\Controllers;

use App\RedirectFact;
use App\Tools\RedirectLogger;
use App\Tools\UrlGenerator;
use App\Tools\UrlValidator;
use App\Url;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    const ERROR_NO_SUCH_URL = 'No such URL';
    const ERROR_URL_EXPIRED = 'URL expired';

    public function minify(Request $request)
    {
        $validator = Validator::make($request->only('redirects_to'),
            ['redirects_to' => 'required|url'],
            [
                'required' => 'Your URL is empty',
                'url' => 'Your URL is invalid'
            ]);
        if ($validator->fails())
            return ['error' => $validator->errors()->first('redirects_to')];

        $url = new Url;
        $url['redirects_to'] = $request['redirects_to'];

        if ($request['custom-url']) {
            $validator = Validator::make($request->only('custom-url'),
                ['custom-url' => 'unique:urls,path']
            );
            if ($validator->fails())
                return ['error' => 'Path already exists'];

            if (strpos($request['custom-url'], '/') !== false || strpos($request['custom-url'], '\\') !== false)
                return ['error' => 'Custom path can\'t contain slashes'];

            $intended_url = url($request['custom-url']);
            $validator = Validator::make(['url' => $intended_url],
                ['url' => 'url']
            );
            if ($validator->fails())
                return ['error' => 'Path is not valid url'];

            $url['path'] = $request['custom-url'];
        } else
            $url['path'] = UrlGenerator::generate();

        $url['expires_at'] = $request['expires_at'];
        $url->save();

        return [
            'url' => url($url['path']),
            'info' => url("/info/{$url['path']}")
        ];
    }

    public function redirect($path)
    {
        $url = Url::where('path', $path)->first();
        if (!$url)
            return view('error')->with(['error' => self::ERROR_NO_SUCH_URL]);
        elseif ($url['expires_at'] !== null && $url['expires_at'] < Carbon::now())
            return view('error')->with(['error' => self::ERROR_URL_EXPIRED]);

        RedirectLogger::log($url->id, request());
        return redirect($url['redirects_to']);
    }

    public function info($path)
    {
        $url = Url::where('path', $path)->first();
        if (!$url)
            return view('error')->with(['error' => self::ERROR_NO_SUCH_URL]);

        return view('info');
    }

    public function infoJson($path)
    {
        $url_id = Url::where('path', $path)->first()['id'];

        $json['countries'] = RedirectFact::selectRaw('country, count(country) as amount')
            ->where('url_id', $url_id)
            ->groupBy('country')->get();

        $json['languages'] = RedirectFact::selectRaw('language, count(language) as amount')
            ->where('url_id', $url_id)
            ->groupBy('language')->get();

        $json['browsers'] = RedirectFact::selectRaw('browser, count(browser) as amount')
            ->where('url_id', $url_id)
            ->groupBy('browser')->get();

        $json['total'] = RedirectFact::selectRaw('count(*) as total')
            ->where('url_id', $url_id)
            ->first()['total'];

        return $json;
    }
}
