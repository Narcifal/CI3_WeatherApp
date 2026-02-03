<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WeatherController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Weather');
    }

    public function index()
    {
        $rawData = $this->Weather->getWeather(42.69, 27.70);
        $data = ['data' => new WeatherEntity($rawData)];

        $this->load->view('WeatherView', $data);
    }
}
