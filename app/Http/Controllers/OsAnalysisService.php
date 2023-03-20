<?php

namespace App\Http\Controllers;

use App\Models\OS;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Os as OsDetect;


class OsAnalysisService
{
    public function handle($url, $agent)
    {
        $osName = $this->getOsFromAgent($agent);
        $foundOsEntry = OS::where([['urlId', '=', $url->id], ['name', '=', $osName]])->get();
        if (count($foundOsEntry) == 0) {
            $osEntry = new OS;
            $osEntry->name = $osName;
            $osEntry->urlId = $url->id;
            $osEntry->count = 1;
            $osEntry->save();
        } else {
            $foundOsEntry[0]->count += 1;
            $foundOsEntry[0]->save();
        }
    }

    private function getOsFromAgent($agent)
    {
        $os = new OsDetect($agent);
        $osName = $os->getName();
        if ($osName == OsDetect::WINDOWS) {
            return 'windows';
        }
        if ($osName == OsDetect::OSX) {
            return 'macos';
        }
        if ($osName == OsDetect::LINUX) {
            return 'linux';
        }

        return 'other';
    }

    public function getStats($urlId)
    {
        return OS::where('urlId', $urlId)->get();
    }
}
