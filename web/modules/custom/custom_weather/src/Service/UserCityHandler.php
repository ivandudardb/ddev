<?php

namespace Drupal\custom_weather\Service;

use Drupal\Core\Database\Database;

/**
 * Determines the city for displaying weather.
 */
class UserCityHandler {

  /**
   * Returns the city from the database or sets a default value.
   */
  public function getCityFromDatabase() {
    $user_id = \Drupal::currentUser()->id();
    $connection = Database::getConnection();
    $query = $connection->select('custom_weather_data', 'cwd');
    $query->addField('cwd', 'city');
    $query->condition('user_id', $user_id);
    $city = $query->execute()->fetchField();
    if (empty($city)) {
      $city = 'Kyiv';
    }

    return $city;
  }

}
