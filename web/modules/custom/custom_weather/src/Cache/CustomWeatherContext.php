<?php

namespace Drupal\custom_weather\Cache;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\custom_weather\Service\UserCityHandler;

/**
 *
 */
class CustomWeatherContext implements CacheContextInterface {

  /**
   * Constructs a new CustomWeatherContext object.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $accountProxy
   *   The account proxy service.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection service.
   * @param \Drupal\custom_weather\Service\UserCityHandler $userCityHandler
   *   The user city handler service.
   */
  public function __construct(
    protected AccountProxyInterface $accountProxy,
    protected Connection $connection,
    protected UserCityHandler $userCityHandler,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return 'City cache context';
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $city = $this->userCityHandler->getCurrentCity();
    return 'custom_cache_context:' . $city;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
