<?php
header("Content-Type: application/json");

// Configuration
const REQUIRED_POST_FIELDS = [
    "city", "country", "temperature", "rain", "weather",
    "wind_speed", "wind_direction", "humidity", "user", "note"
];

const WEATHER_CODE_MAP = [
    0 => "Clear sky",
    1 => "Mainly clear",
    2 => "Partly cloudy",
    3 => "Overcast",
    45 => "Fog",
    61 => "Light rain",
    80 => "Rain showers",
    95 => "Thunderstorm"
];

// Main execution
try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'POST':
            handlePostRequest();
            break;
        case 'GET':
            handleGetRequest();
            break;
        default:
            sendResponse(405, ["error" => "Method not allowed"]);
    }
} catch (Exception $e) {
    sendResponse(500, ["error" => "Server error: " . $e->getMessage()]);
}

// Request handlers
function handlePostRequest() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        sendResponse(400, ["error" => "Invalid JSON data"]);
    }

    foreach (REQUIRED_POST_FIELDS as $field) {
        if (!isset($input[$field])) {
            sendResponse(400, ["error" => "Missing field: $field"]);
        }
    }

    sendResponse(200, [
        "message" => "Weather report added successfully",
        "report" => $input
    ]);
}

function handleGetRequest() {
    if (!isset($_GET['city'])) {
        sendResponse(400, ["error" => "City parameter required"]);
    }

    $city = filter_var(trim($_GET['city']), FILTER_SANITIZE_STRING);
    $geoData = fetchGeocodingData($city);

    if (empty($geoData['results'])) {
        sendResponse(404, ["error" => "City not found"]);
    }

    $location = $geoData['results'][0];
    $weatherData = fetchWeatherData($location['latitude'], $location['longitude']);

    sendResponse(200, formatWeatherResponse($location, $weatherData));
}

// API clients
function fetchGeocodingData($city) {
    $url = "https://geocoding-api.open-meteo.com/v1/search?" . http_build_query([
        'name' => $city,
        'count' => 1
    ]);
    
    $response = file_get_contents($url);
    if (!$response) {
        throw new Exception("Geocoding API failed");
    }
    
    return json_decode($response, true);
}

function fetchWeatherData($lat, $lon) {
    $url = "https://api.open-meteo.com/v1/forecast?" . http_build_query([
        'latitude' => $lat,
        'longitude' => $lon,
        'current' => 'rain,temperature_2m,weather_code,wind_speed_10m,wind_direction_10m,relative_humidity_2m'
    ]);
    
    $response = file_get_contents($url);
    if (!$response) {
        throw new Exception("Weather API failed");
    }
    
    return json_decode($response, true);
}

// Response formatting
function formatWeatherResponse($location, $weatherData) {
    $current = $weatherData['current'];
    
    return [
        "city" => $location['name'],
        "country" => $location['country'],
        "coordinates" => [
            "latitude" => $location['latitude'],
            "longitude" => $location['longitude']
        ],
        "temperature" => $current['temperature_2m'] . "°C",
        "rain" => $current['rain'] . " mm",
        "weather" => WEATHER_CODE_MAP[$current['weather_code']] ?? "Unknown",
        "wind" => [
            "speed" => $current['wind_speed_10m'] . " km/h",
            "direction" => $current['wind_direction_10m'] . "°"
        ],
        "humidity" => $current['relative_humidity_2m'] . "%",
        "timestamp" => date('c')
    ];
}

// Helper functions
function sendResponse($statusCode, $data) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}