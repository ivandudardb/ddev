<?php
namespace Drupal\custom_weather\Service;

use Drupal\Core\Database\Database;
public function getCityFromDatabase() {
  $user_id = \Drupal::currentUser()->id();
  $connection = Database::getConnection();
  $query = $connection->select('custom_weather_data', 'cwd');
  $query->fields('cwd', ['city']);
  $query->condition('user_id', $user_id);
  return $query->execute()->fetchField();
}
