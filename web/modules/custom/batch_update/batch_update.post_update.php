<?php

/**
 * @file
 * Install, update and uninstall functions for the batch_api module.
 */

/**
 * Implements hook_post_update_NAME().
 */
function batch_update_post_update_formatter(&$sandbox): void {
  $limit = 20;
  $format = 'limited_html';
  $query = \Drupal::entityTypeManager()->getStorage('paragraph')
    ->getQuery()
    ->accessCheck(FALSE)
    ->condition('field_regular_text.format', $format, '<>')
    ->range(0, $limit);
  $paragraphs = $query->execute();
  if (empty($paragraphs)) {
    $sandbox['#finished'] = 1;
    return;
  }
  $multipleParagraphs = \Drupal::entityTypeManager()
    ->getStorage('paragraph')
    ->loadMultiple($paragraphs);
  foreach ($multipleParagraphs as $paragraph) {
    format_change($paragraph, $format);
  }
  $sandbox['#finished'] = 0;
}

/**
 * Update the text format of a paragraph.
 */
function format_change($paragraph, $format):void {
  $paragraph->get('field_regular_text')->format = $format;
  $paragraph->save();
}
