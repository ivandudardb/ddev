<?php

namespace Drupal\custom_weather\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\custom_weather\Service\UserCityHandler;
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
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected ClientFactory $httpClient, protected ConfigFactoryInterface $configFactory, protected UserCityHandler $userCityHandler) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('http_client_factory'),
      $container->get('config.factory'),
      $container->get('custom_weather.user_city_handler'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build():array {
    $apiKey = $this->configFactory->get('custom_weather.settings')->get('api_key');
    $city = $this->userCityHandler->getCurrentCity();
    $httpClient = $this->httpClient;
    $weatherData = $this->userCityHandler->getWeatherApi($apiKey, $city, $httpClient);
    if ($weatherData) {
      $temp = round($weatherData['main']['temp'] - 273.15, 1);
      $weather_text = $weatherData['weather'][0]['main'];
      return [
        '#theme' => 'custom_weather_block',
        '#temp' => $temp,
        '#weather_text' => $weather_text,
        '#selected_city' => $city,
        '#cache' => [
          'contexts' => ['user'],
          'max-age' => 30 * 60,
        ],
      ];
    }
    else {
      return [];
    }
  }

}
