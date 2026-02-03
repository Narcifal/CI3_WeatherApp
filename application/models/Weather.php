<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather extends CI_Model
{
    private $apiKey;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->setApiKey();
    }

    public function getWeather($lat, $lon)
    {
        $url = $this->buildApiUrl($lat, $lon);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }

    public function getProcessedWeather($lat, $lon)
    {
        $rawData = $this->getWeather($lat, $lon);
        $data = new WeatherEntity($rawData);

        if ($data->isValid()) {
            $this->saveWeather($data);
        }

        return [
            'data' => $data,
            'history' => $this->getHistory()
        ];
    }

    private function saveWeather(WeatherEntity $entity)
    {
        $latest = $this->db->get_where('weather_history', ['id' => 1])->row_array();

        if ($latest) {
            $latest['id'] = 2;
            $this->db->replace('weather_history', $latest);
        }

        $this->db->replace('weather_history', [
            'id' => 1,
            'city_name' => $entity->cityName,
            'temperature' => $entity->temperature,
            'description' => $entity->description,
            'humidity' => $entity->humidity,
            'created_at' => $entity->createdAt
        ]);
    }

    private function setApiKey()
    {
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

    private function getHistory($order = 'ASC')
    {
        return $this->db->order_by('id', $order)->get('weather_history')->result_array();
    }
}