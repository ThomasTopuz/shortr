<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Stevebauman\Location\Facades\Location as LocationDetect;

class LocationAnalysisService
{
    public function handle($url, $request)
    {
        $location = $this->getLocation($request);
        $foundEntry = Location::where([['urlId', '=', $url->id], ['name', '=', $location]])->get();
        if (count($foundEntry) == 0) {
            $osEntry = new Location;
            $osEntry->name = $location;
            $osEntry->urlId = $url->id;
            $osEntry->count = 1;
            $osEntry->save();
        } else {
            $foundEntry[0]->count += 1;
            $foundEntry[0]->save();
        }
    }

    private function getLocation($request): string
    {
        $ip = $request->ip;
        return LocationDetect::get()->countryName;
    }

    public function getStats($urlId)
    {
        return Location::where('urlId', $urlId)->get();
    }
}
