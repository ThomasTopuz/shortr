<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $shorted = substr(md5(microtime()), rand(0, 26), 5);
        $url = new Url;
        $url->destination = $request->url;
        $url->short = $shorted;
        $url->userId = Auth::user()->id;
        $url->save();
        $host = env('HOST');

        return redirect('/');
    }

    public function resolve(Request $request, $short)
    {
        \Log::info($short);
        $found = Url::where('short', $short)->get();
        \Log::info($found);
        return redirect($found[0]->destination);
    }

    public function index(Request $request)
    {
        \Log::info(Auth::id());
        $urls = Url::where('userId', Auth::user()->id)->get();
        \Log::info($urls);
        return view('welcome', ['myUrls'=> $urls]);
    }
}
