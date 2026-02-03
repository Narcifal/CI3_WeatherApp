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
        $weather = $this->Weather->getProcessedWeather(42.69, 27.70);

        $this->load->view('WeatherView', [
            'data' => $weather['data'],
            'history' => $weather['history']
        ]);
    }
}
