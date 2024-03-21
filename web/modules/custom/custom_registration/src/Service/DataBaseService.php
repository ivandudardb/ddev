<?php

namespace Drupal\custom_registration\Service;

use Drupal\Core\Database\Connection;

/**
 * Saves data from custom registration fields into the database.
 */
class DataBaseService {

  /**
   * Constructs a new DataBaseService object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection service.
   */
  public function __construct(
    protected Connection $connection,
  ) {

  }

  /**
   * Saves data from custom registration fields into the database.
   *
   * @param string $country_value
   *   The value of the country.
   * @param string $city_value
   *   The value of the city.
   * @param int $interested_in_value
   *   The value indicating user's interest.
   * @param int $user_id
   *   The user ID associated with the registration data.
   *
   * @throws \Exception
   *   Thrown if there is an error during data insertion.
   */
  public function saveData(string $country_value, string $city_value, int $interested_in_value, int $user_id): void {
    $this->connection->insert('custom_registration_data')
      ->fields([
        'uid' => $user_id,
        'country' => $country_value,
        'interested_in' => $interested_in_value,
      ])
      ->execute();

    $this->connection->merge('custom_weather_data')
      ->keys(['user_id' => $user_id])
      ->fields([
        'city' => $city_value,
        'user_id' => $user_id,
      ])
      ->execute();
  }

}
