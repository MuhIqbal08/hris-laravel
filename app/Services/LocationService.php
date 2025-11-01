<?php

namespace App\Services;

Class LocationService {
    public static function calculateDistance(float $lat1, float $long1, float $lat2, float $long2) {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($long1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($long2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}