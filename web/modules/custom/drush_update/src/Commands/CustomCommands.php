<?php

namespace Drupal\drush_update\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;

/**
 * Creates custom drush command for changing paragraph text format.
 */
class CustomCommands extends DrushCommands {

  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager
  ) {
    parent::__construct();
  }

  /**
   * Changes the text format for paragraphs.
   *
   * @command custom-command
   */
  public function changeTextFormat():void {
    $limit = 50;
    $format = 'limited_html';
    $paragraph_storage = $this->entityTypeManager->getStorage('paragraph');
    $paragraph_query = $paragraph_storage->getQuery()
      ->accessCheck(FALSE)
      ->exists('field_regular_text');
    $paragraphs = $paragraph_query->execute();
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
          $this->processItem($item, $format, $paragraph_storage);

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
   * Updates paragraph text format.
   */
  public function processItem($nid, &$context, $paragraph_storage): void {
    $paragraph = $paragraph_storage->load($nid);
    $paragraph->get('field_regular_text')->format = $context;
    $paragraph->save();
  }

}
