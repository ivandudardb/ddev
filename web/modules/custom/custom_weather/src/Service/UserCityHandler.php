<?php

namespace Drupal\custom_weather\Service;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Database\Connection;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Saves the city for displaying weather.
 */
class UserCityHandler {

  /**
   * Constructor of the class.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user.
   */
  public function __construct(
    protected Connection $connection,
    protected AccountProxyInterface $currentUser,
    protected ClientFactory $httpClient,
  ) {
  }

  /**
   * Return city name from the database or return a default value.
   */
  public function getCurrentCity() {
    $user_id = $this->currentUser->id();
    $query = $this->connection->select('custom_weather_data', 'cwd');
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
  public function getWeatherApi(string $apiKey, string $city): array|false {
    if (empty($apiKey)) {
      return FALSE;
    }
    $client = $this->httpClient->fromOptions();
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

  /**
   * Set or update user city in database.
   *
   * @throws \Exception
   */
  public function saveUserCity(string $selected_user_city): void {
    $user_id = $this->currentUser->id();
    $this->connection->merge('custom_weather_data')
      ->keys(['user_id' => $user_id])
      ->fields([
        'city' => $selected_user_city,
        'user_id' => $user_id,
      ])
      ->execute();
  }

}
