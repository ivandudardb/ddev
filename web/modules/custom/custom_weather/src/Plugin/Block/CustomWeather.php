<?php

namespace Drupal\custom_weather\Plugin\Block;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use GuzzleHttp\Client;

/**
 * Provides a 'WeatherBlock' block.
 */
#[Block(
  id: "custom_weather_block",
  admin_label: new TranslatableMarkup("Custom Weather block"),
)]


class CustomWeather extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build():array {
    $weatherData = $this->getWeatherApi();
    $temp = $weatherData['main']['temp'];
    $weather_text = $weatherData['weather'][0]['main'];
    $temp = round($temp - 273);

    return [
      '#theme' => 'custom_weather_block',
      '#temp' => $temp,
      '#weather_text' => $weather_text,
    ];
  }

  /**
   * Protected function for getting array with temperature.
   */
  protected function getWeatherApi():mixed {
    $client = new Client();
    $request = $client->get(
      'https://api.openweathermap.org/data/2.5/weather?lat=50.7593&lon=25.3424&appid=23033cae7426d33b990b8c0c4dffe352'
    );
    $response = $request->getBody()->getContents();
    return Json::decode($response);
  }

}
