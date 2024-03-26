<?php

/**
 * @file
 * Implements hook_post_update_NAME.
 */

/**
 * Get paragraph and call function for update text format.
 */
function batch_update_post_update_formatter(&$context): void {
  if (empty($context['sandbox']['progress'])) {
    $context['sandbox']['progress'] = 0;
  }
  $limit = 20;
  $format = 'limited_html';
  $query = \Drupal::entityTypeManager()->getStorage('paragraph')
    ->getQuery()
    ->accessCheck(FALSE)
    ->condition('field_regular_text.format', $format, '<>')
    ->range($context['sandbox']['progress'], $context['sandbox']['progress'] + $limit);
  $paragraphs = $query->execute();
  if (empty($paragraphs)) {
    $context['#finished'] = 1;
    return;
  }
  $multipleParagraphs = \Drupal::entityTypeManager()
    ->getStorage('paragraph')
    ->loadMultiple($paragraphs);
  foreach ($multipleParagraphs as $paragraph) {
    format_change($paragraph, $format);
    $context['sandbox']['progress']++;
  }
  $context['#finished'] = 0;
}

/**
 * Update the text format of a paragraph.
 */
function format_change($paragraph, $format):void {
  $paragraph->get('field_regular_text')->format = $format;
  $paragraph->save();
}
