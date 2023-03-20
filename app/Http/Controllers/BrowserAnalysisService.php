<?php

namespace App\Http\Controllers;

use App\Models\Browser;
use Sinergi\BrowserDetector\Browser as BrowserDetect;

class BrowserAnalysisService
{
    public function handle($url, $agent)
    {
        $browserName = $this->getBrowserFromAgent($agent);
        $foundOsEntry = Browser::where([['urlId', '=', $url->id], ['name', '=', $browserName]])->get();
        if (count($foundOsEntry) == 0) {
            $osEntry = new Browser;
            $osEntry->name = $browserName;
            $osEntry->urlId = $url->id;
            $osEntry->count = 1;
            $osEntry->save();
        } else {
            $foundOsEntry[0]->count += 1;
            $foundOsEntry[0]->save();
        }
    }

    private function getBrowserFromAgent($agent): string
    {
        $agent = strtolower($agent);
        $browserDetect = new BrowserDetect($agent);
        $browser = $browserDetect->getName();
        if ($browser == BrowserDetect::CHROME) {
            return 'chrome';
        }
        if ($browser == BrowserDetect::FIREFOX) {
            return 'firefox';
        }
        if ($browser == BrowserDetect::SAFARI) {
            return 'safari';
        }
        return 'other';
    }

    public function getStats($urlId)
    {
        return Browser::where('urlId', $urlId)->get();
    }
}
