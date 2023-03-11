<?php

namespace App\Http\Controllers;

use App\Models\OS;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OsAnalysisService;

class UrlController extends Controller
{

    private OsAnalysisService $osAnalysisService;

    public function __construct(OsAnalysisService $osAnalysisService)
    {
        $this->osAnalysisService = $osAnalysisService;
    }

    public function shorten(Request $request)
    {
        $shorted = substr(md5(microtime()), rand(0, 26), 5);
        $url = new Url;
        $url->destination = $request->url;
        $url->short = $shorted;
        $url->userId = Auth::user()->id;
        $url->clicks = 0;

        $url->save();
        return redirect('/');
    }

    public function resolve(Request $request, $short)
    {
        if ($request->has('admin')) {
            return $this->handlStatistics($short);
        }

        $found = Url::where('short', $short)->get();
        $url = $found[0];
        $url->clicks += 1;
        $url->save();
        $agent = $request->header('User-Agent');

        $this->osAnalysisService->handle($url, $agent);

        // check OS


        return redirect($found[0]->destination);
    }


    public function handlStatistics($short)
    {
        if (!Auth::check()) {
            return redirect('/auth/redirect');
        }

        $found = Url::where([['short', '=', $short], ['userId', '=', Auth::id()]])->get();
        if (count($found) == 0) {
            return redirect('/');
        }
        $osEntries = OS::where('urlId',$found[0]->id)->get();

        return view('stats', ['user' => Auth::user(), 'url' => $found[0], 'os' => $osEntries],);
    }

    public function index(Request $request)
    {
        $urls = Url::where('userId', Auth::user()->id)->get();
        return view('welcome', ['myUrls' => $urls, 'user' => Auth::user(), 'host' => env("HOST")]);
    }
}
