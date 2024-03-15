<?php

namespace Drupal\custom_weather\Plugin\Block;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WeatherBlock' block.
 */
#[Block(
  id: "custom_weather_block",
  admin_label: new TranslatableMarkup("Custom Weather block"),
)]
class CustomWeather extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Stores the API key used for accessing weather data.
   */
  protected string $apiKey;

  /**
   * Stores the selected city.
   */
  protected string $selectedCity;

  /**
   * {@inheritdoc}
   */
  public function __construct(protected ClientFactory $httpClient, array $configuration, $plugin_id, $plugin_definition, protected ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->apiKey = $this->configFactory->get('custom_weather.settings')->get('api_key');
    $this->selectedCity = $this->configFactory->get('custom_weather.settings')->get('selected_city');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
      $container->get('http_client_factory'),
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build():array {
    $city = $this->getCityFromDatabase();
    $weatherData = $this->getWeatherApi();
    if ($weatherData) {
      $temp = round($weatherData['main']['temp'] - 273.15, 1);
      $weather_text = $weatherData['weather'][0]['main'];
      return [
        '#theme' => 'custom_weather_block',
        '#temp' => $temp,
        '#weather_text' => $weather_text,
        '#selected_city' => $city,
      ];
    }
    else {
      return [];
    }
  }

  /**
   * Protected function for getting array with temperature.
   */
  protected function getWeatherApi(): array|false {
    if (empty($this->apiKey)) {
      return FALSE;
    }
    $city = $this->getCityFromDatabase();
    $client = $this->httpClient->fromOptions();
    $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $this->apiKey;
    try {
      $request = $client->get($url);
      $response = $request->getBody()->getContents();
      return Json::decode($response);
    }
    catch (\Exception $e) {
      return FALSE;
    }
  }

  /**
   *
   */
  public function getCityFromDatabase() {
    $user_id = \Drupal::currentUser()->id();
    $connection = Database::getConnection();
    $query = $connection->select('custom_weather_data', 'cwd');
    $query->fields('cwd', ['city']);
    $query->condition('user_id', $user_id);
    return $query->execute()->fetchField();
  }

}
