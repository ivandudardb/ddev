<?php

namespace Drupal\custom_weather\Service;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Determines the city for displaying weather.
 */
class UserCityHandler {

  /**
   * Stores DB connection.
   */

  protected mixed $connection;

  /**
   * Stores current user id.
   */
  protected int $currentUser;

  public function __construct(Connection $connection, AccountProxyInterface $currentUser) {
    $this->connection = $connection;
    $this->currentUser = $currentUser->id();
  }

  /**
   * Update city name in Database if it exists.
   */
  public function updateWeatherData($selected_user_city, $user_id): void {
    $connection = $this->connection;
    $connection->update('custom_weather_data')
      ->fields([
        'city' => $selected_user_city,
      ])
      ->condition('user_id', $user_id)
      ->execute();
  }

  /**
   * Set city name to Database.
   *
   * @throws \Exception
   */
  public function setWeatherData($selected_user_city, $user_id): void {
    $connection = $this->connection;
    $connection->insert('custom_weather_data')
      ->fields([
        'city' => $selected_user_city,
        'user_id' => $user_id,
      ])
      ->execute();
  }

  /**
   * Returns the city from the database or sets a default value.
   */
  public function getCurrentCity() {
    $user_id = $this->currentUser;
    $connection = $this->connection;
    $query = $connection->select('custom_weather_data', 'cwd');
    $query->addField('cwd', 'city');
    $query->condition('user_id', $user_id);
    $city = $query->execute()->fetchField();
    if (empty($city)) {
      $city = 'Kyiv';
    }

    return $city;
  }

  /**
   * Getting array with temperature.
   */
  public function getWeatherApi($apiKey, $city, $httpClient): array|false {
    if (empty($apiKey)) {
      return FALSE;
    }
    $client = $httpClient->fromOptions();
    $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $apiKey;
    try {
      $request = $client->get($url);
      $response = $request->getBody()->getContents();
      return Json::decode($response);
    }
    catch (\Exception $e) {
      return FALSE;
    }
  }

}
