<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather extends CI_Model
{
    private $apiKey;

    public function __construct()
    {
        parent::__construct();

        $this->setApiKey();
    }

    // Public
    public function getWeather($lat, $lon)
    {
        $url = $this->buildApiUrl($lat, $lon);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    // Private
    private function setApiKey() {
        $this->apiKey = $_ENV[ENV_WEATHER_KEY] ?? getenv(ENV_WEATHER_KEY);
        
        if (empty($this->apiKey)) {
            show_error('API key missing');
        }
    }

    private function buildApiUrl($lat, $lon)
    {
        $queryParams = [
            'lat' => $lat,
            'lon' => $lon,
            'units' => OWM_UNITS,
            'appid' => $this->apiKey,
            'lang' => 'en'
        ];

        return OWM_API_URL . '?' . http_build_query($queryParams);
    }
}