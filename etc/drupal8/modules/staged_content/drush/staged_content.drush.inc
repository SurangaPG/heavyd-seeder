<?php

/**
 * @file
 * Drush integration for the default_content module.
 */

use Drupal\staged_content\Storage\JsonFileStorage;

/**
 * Implements hook_drush_command().
 */
function staged_content_drush_command() {
  $items['staged-content-export-type'] = [
    'description' => dt('Exports all entities of a given type'),
    'arguments' => [
      'entity_type' => dt('The entity type to export.'),
    ],
    'options' => [
      'folder' => dt('Write out the exported content to a folder'),
      'include-id' => dt('Should the id be included in the export (useful for nodes etc that have links to various other items in the site.), defaults to false.'),
    ],
    'aliases' => ['scet'],
    'required-arguments' => 1,
  ];
  $items['staged-content-import'] = [
    'description' => dt('Imports all entities in a given storage folder'),
    'arguments' => [
      'source_folder' => dt('Source folder with all the data.'),
    ],
    'aliases' => ['sci'],
    'required-arguments' => 1,
  ];
  return $items;
}

/**
 * Exports a piece of content into the stdout or into a file.
 *
 * @param string $entityTypeId
 *   The entity type ID.
 */
function drush_staged_content_export_type($entityTypeId) {
  $outputFolder = drush_get_option('folder');
  // @TODO Clean up the output dir default.
  $outputFolder = isset($outputFolder) ? $outputFolder : getcwd() . '/staged-content-output';
  $storageHandler = new JsonFileStorage(['outputFolder' => $outputFolder]);

  /** @var \Drupal\staged_content\LayeredExporter $exporter */
  $exporter = \Drupal::service('staged_content.exporter');
  $exporter->setStorageHandler($storageHandler);

  if (drush_get_option('include-id')) {
    $exporter->setIncludeId(TRUE);
  }

  if (drush_get_option('include-references')) {
    $includedReferences = explode(',', drush_get_option('include-references'));
  }
  else {
    $includedReferences = ['file', 'media', 'paragraph'];
  }

  $exporter->exportType($entityTypeId, $includedReferences);
}

/**
 * Exports a piece of content into the stdout or into a file.
 *
 * @param string $sourceDir
 *   Source directory where all the files can be found.
 */
function drush_staged_content_import($sourceDir) {
  $storageHandler = new JsonFileStorage(['outputFolder' => $sourceDir]);

  /** @var \Drupal\staged_content\LayeredImporter $importer */
  $importer = \Drupal::service('staged_content.importer');
  $importer->importContent($storageHandler);
}
