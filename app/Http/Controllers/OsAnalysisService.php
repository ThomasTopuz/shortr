<?php

namespace App\Http\Controllers;

use App\Models\OS;
use Illuminate\Http\Request;

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
        $agent = strtolower($agent);
        if (str_contains($agent, 'macintosh')) {
            return 'macos';
        }
        if (str_contains($agent, 'windows')) {
            return 'windows';
        }
        if (str_contains($agent, 'linux')) {
            return 'linux';
        }

        return 'other';
    }
}
