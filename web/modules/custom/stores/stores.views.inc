<?php

/**
 * @file
 * Provide views data for our custom stores.
 */

/**
 * Implements hook_views_data().
 */
function stores_views_data() {

  $data['views']['map_area'] = [
    'title' => t('My map area'),
    'help' => t('Provide map for my custom site.'),
    'area' => [
      'id' => 'map_area',
    ],
  ];

  return $data;
}
