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

  public function __construct(
    protected AccountProxyInterface $accountProxy,
    protected Connection $connection,
    protected UserCityHandler $userCityHandler,
  ) {
  }

  /**
   *
   */
  public static function getLabel() {
    return 'City cache context';
  }

  /**
   *
   */
  public function getContext() {
    $city = $this->userCityHandler->getCurrentCity();
    return 'custom_cache_context:' . $city;
  }

  /**
   *
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
