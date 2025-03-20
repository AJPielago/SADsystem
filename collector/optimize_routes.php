<?php
include '../routes_data.php'; // Ensure the path is correct

header('Content-Type: application/json');

// Read waypoints from the request
$inputData = json_decode(file_get_contents("php://input"), true);
$routes = isset($inputData['waypoints']) ? $inputData['waypoints'] : [];

if (empty($routes)) {
    echo json_encode([]);
    exit;
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Radius of the earth in km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c; // Distance in km
}

function tsp($routes) {
    $n = count($routes);
    $visited = array_fill(0, $n, false);
    $routeOrder = [];
    $currentIndex = 0;

    for ($i = 0; $i < $n; $i++) {
        $visited[$currentIndex] = true;
        $routeOrder[] = $routes[$currentIndex];
        $nearestIndex = -1;
        $nearestDistance = PHP_INT_MAX;

        for ($j = 0; $j < $n; $j++) {
            if (!$visited[$j]) {
                $distance = calculateDistance(
                    $routes[$currentIndex]['latitude'],
                    $routes[$currentIndex]['longitude'],
                    $routes[$j]['latitude'],
                    $routes[$j]['longitude']
                );

                if ($distance < $nearestDistance) {
                    $nearestDistance = $distance;
                    $nearestIndex = $j;
                }
            }
        }

        if ($nearestIndex != -1) {
            $currentIndex = $nearestIndex;
        }
    }

    return $routeOrder;
}

$optimizedRoutes = tsp($routes);
echo json_encode($optimizedRoutes);
exit;
