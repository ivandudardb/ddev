<?php

namespace Drupal\custom_weather\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Database\Database;

/**
 * Determines the city for displaying weather.
 */
class DataBaseService implements ConfigFactoryInterface {

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

  /**
   * {@inheritdoc}
   */
  public function get($name) {
    // @todo Implement get() method.
  }

  /**
   * {@inheritdoc}
   */
  public function getEditable($name) {
    // @todo Implement getEditable() method.
  }

  /**
   * {@inheritdoc}
   */
  public function loadMultiple(array $names) {
    // @todo Implement loadMultiple() method.
  }

  /**
   * {@inheritdoc}
   */
  public function reset($name = NULL) {
    // @todo Implement reset() method.
  }

  /**
   * {@inheritdoc}
   */
  public function rename($old_name, $new_name) {
    // @todo Implement rename() method.
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheKeys() {
    // @todo Implement getCacheKeys() method.
  }

  /**
   * {@inheritdoc}
   */
  public function clearStaticCache() {
    // @todo Implement clearStaticCache() method.
  }

  /**
   * {@inheritdoc}
   */
  public function listAll($prefix = '') {
    // @todo Implement listAll() method.
  }

  /**
   * {@inheritdoc}
   */
  public function addOverride(ConfigFactoryOverrideInterface $config_factory_override) {
    // @todo Implement addOverride() method.
  }

}
