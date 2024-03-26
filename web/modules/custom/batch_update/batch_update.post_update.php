<?php

/**
 * @file
 * Implements hook_post_update_NAME.
 */

/**
 * Get paragraph and call function for update text format.
 */
function batch_update_post_update_format3(&$context): void {
  $paragraph = \Drupal::entityQuery('paragraph');
  $paragraph->accessCheck(FALSE)
    ->exists('field_regular_text');
  $paragraphs = $paragraph->execute();
  $limit = 50;
  $format = 'limited_html';

  if (empty($context['sandbox']['progress'])) {
    $context['sandbox']['progress'] = 0;
    $context['sandbox']['max'] = count($paragraphs);
  }

  if (empty($context['sandbox']['items'])) {
    $context['sandbox']['items'] = $paragraphs;
  }

  $counter = 0;
  if (!empty($context['sandbox']['items'])) {

    if ($context['sandbox']['progress'] != 0) {
      array_splice($context['sandbox']['items'], 0, $limit);
    }

    foreach ($context['sandbox']['items'] as $item) {
      if ($counter != $limit) {
        process_item($item, $format);

        $counter++;
        $context['sandbox']['progress']++;
      }
    }
  }

  if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
    $context['sandbox']['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
  }
}

/**
 * Update the text format for paragraph.
 */
function process_item($nid, &$context): void {
  $paragraph_storage = \Drupal::entityTypeManager()->getStorage('paragraph');
  $paragraph = $paragraph_storage->load($nid);
  $paragraph->get('field_regular_text')->format = $context;
  $paragraph->save();
}
