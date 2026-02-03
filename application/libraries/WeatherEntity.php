<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WeatherEntity
{
    public $temperature;
    public $description;
    public $humidity;
    public $cityName;
    public $errorMessage;

    public function __construct(?array $data = null)
    {
        $statusCode = (int) ($data['cod'] ?? 0);

        if ($statusCode === 200 && isset($data['main'])) {
            $this->parseSuccess($data);
        } else {
            $this->parseError($data);
        }
    }

    // Public
    public function hasData()
    {
        return $this->errorMessage === null && $this->temperature !== null;
    }

    // Private
    private function parseSuccess(array $data)
    {
        $this->temperature = (int) round($data['main']['temp'] ?? 0);
        $this->humidity = (int) ($data['main']['humidity'] ?? 0);
        $this->description = (string) ($data['weather'][0]['description'] ?? 'no description');
        $this->cityName = (string) ($data['name'] ?? 'Unknown location');
        $this->errorMessage = null;
    }

    private function parseError(?array $data)
    {
        $this->errorMessage = (string) ($data['message'] ?? 'Unknown API error occurred');
        $this->temperature = null;
    }
}