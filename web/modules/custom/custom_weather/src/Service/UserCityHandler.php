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
    $query = $this->connection->select('custom_registration_data', 'crd');
    $query->addField('crd', 'city');
    $query->condition('uid', $user_id);
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
    $this->connection->merge('custom_registration_data')
      ->keys(['uid' => $user_id])
      ->fields([
        'city' => $selected_user_city,
        'uid' => $user_id,
      ])
      ->execute();
  }

  /**
   * Return array with cities.
   */
  public function cities(): array {
    $cities = [
      'Kyiv' => t('Kyiv'),
      'Lviv' => t('Lviv'),
      'Rivne' => t('Rivne'),
      'Lutsk' => t('Lutsk'),
      'Zhytomyr' => t('Zhytomyr'),
      'Chernivtsi' => t('Chernivtsi'),
      'Ternopil' => t('Ternopil'),
      'Khmelnytskyi' => t('Khmelnytskyi'),
      'Uzhhorod' => t('Uzhhorod'),
      'Vinnytsia' => t('Vinnytsia'),
      'Cherkasy' => t('Cherkasy'),
      'Poltava' => t('Poltava'),
      'Chernihiv' => t('Chernihiv'),
    ];

    return $cities;
  }

}
