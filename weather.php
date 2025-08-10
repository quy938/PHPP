<?php
// Repository: php-weather-api
// Description: Fetch weather data from an external API and display it.

$apiKey = "your_api_key_here";
$city = "London";
$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data && $data['cod'] == 200) {
    $weather = $data['weather'][0]['description'];
    $temperature = $data['main']['temp'];
    echo "Weather in $city: $weather\n";
    echo "Temperature: $temperature °C\n";
} else {
    echo "Failed to fetch weather data.";
}
?>
