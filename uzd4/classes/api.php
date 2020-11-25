<?php

require_once "./apiConfig.php";

class Weather_API
{
    private $api_key;
    private $base_url;
    private $units;
    private $mode;


    public function __construct(string $key, string $url, string $units, string $mode)
    {
        $this->api_key = $key;
        $this->base_url = $url;
        $this->units = $units ? $units : "";
        $this->mode = $mode ? $mode : "";
    }

    public function getWeather($query)
    {
        $url = sprintf(
            "%s?q=%s&mode=%s&units=%s&APPID=%s",
            $this->base_url,
            htmlspecialchars($query),
            $this->mode,
            $this->units,
            $this->api_key
        );

        return @simplexml_load_file($url);
    }
}
$weather_api = new Weather_API(API_KEY, BASE_URL, UNITS, MODE);