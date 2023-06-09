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
    private BrowserAnalysisService $browserAnalysisService;
    private LocationAnalysisService $locationAnalysisService;

    public function __construct(OsAnalysisService $osAnalysisService, BrowserAnalysisService $browserAnalysisService, LocationAnalysisService $locationAnalysisService)
    {
        $this->osAnalysisService = $osAnalysisService;
        $this->browserAnalysisService = $browserAnalysisService;
        $this->locationAnalysisService = $locationAnalysisService;
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
        $this->browserAnalysisService->handle($url, $agent);
        $this->locationAnalysisService->handle($url, $request);

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
        $id = $found[0]->id;

        $osStats = $this->osAnalysisService->getStats($id);
        $broserStats = $this->browserAnalysisService->getStats($id);
        $locationStats = $this->locationAnalysisService->getStats($id);

        return view('stats', ['user' => Auth::user(), 'url' => $found[0], 'os' => $osStats, 'browser' => $broserStats, 'location' => $locationStats]);
    }

    public function index(Request $request)
    {
        $urls = Url::where('userId', Auth::user()->id)->get();
        return view('welcome', ['myUrls' => $urls, 'user' => Auth::user(), 'host' => env("HOST")]);
    }
}
