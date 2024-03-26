<?php

namespace Drupal\drush_update\Commands;

use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;

/**
 * Defines Drush command for changing paragraph text format.
 */
class BatchFormatUpdate extends DrushCommands {

  use DependencySerializationTrait;

  public function __construct(protected EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct();
  }

  /**
   * Updates paragraph text format.
   *
   * @command custom-command
   */
  public function runBatchUpdate() {
    $batch = [
      'operations' => [
        [[$this, 'processItems'], []],
      ],
    ];

    batch_set($batch);
    drush_backend_batch_process();
  }

  /**
   * Process batch items.
   */
  public function processItems(&$context): void {
    $limit = 20;
    $format = 'limited_html';
    $query = $this->entityTypeManager->getStorage('paragraph')
      ->getQuery()
      ->accessCheck(FALSE)
      ->condition('field_regular_text.format', $format, '<>')
      ->range(0, $limit);
    $paragraphs = $query->execute();
    if (empty($paragraphs)) {
      $context['finished'] = 1;
      return;
    }
    $multipleParagraphs = $this->entityTypeManager
      ->getStorage('paragraph')
      ->loadMultiple($paragraphs);
    foreach ($multipleParagraphs as $paragraph) {
      $this->formatUpdate($paragraph, $format);
    }
    $context['finished'] = 0;
  }

  /**
   * Update the text format of a paragraph.
   */
  public function formatUpdate($paragraph, &$format):void {
    $paragraph->get('field_regular_text')->format = $format;
    $paragraph->save();
  }

}
