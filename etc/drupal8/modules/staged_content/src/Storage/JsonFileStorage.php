<?php

namespace Drupal\staged_content\Storage;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Store the data in json files.
 */
class JsonFileStorage implements StorageHandlerInterface {

  /**
   * Output folder root.
   *
   * @var string
   *   The root output folder.
   */
  protected $outputFolder;

  /**
   * Filesystem helper.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   *   Filesystem helper.
   */
  protected $fileSystem;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $config = []) {
    // @TODO default to the file dir.
    $outputFolder = isset($config['outputFolder']) ? $config['outputFolder'] : getcwd();
    $this->setOutputFolder($outputFolder);

    $this->fileSystem = new Filesystem();
  }

  /**
   * {@inheritdoc}
   */
  public function storeData(string $data, string $entityType, string $uuid, string $originalId = NULL) {

    $this->fileSystem->mkdir($this->outputFolder . '/' . $entityType);

    file_put_contents($this->generateFileName($entityType, $uuid), $data);

    // @TODO, improve output logging.
    echo '  Saved data for ' . $uuid . "\n";
  }

  /**
   * {@inheritdoc}
   */
  public function detectEntityTypes() {
    $return = [];
    $entityTypes = glob($this->outputFolder . '/*', GLOB_ONLYDIR);

    foreach ($entityTypes as $entityTypeFolder) {
      $entityType = basename($entityTypeFolder);
      $sampleFiles = glob($this->outputFolder . '/' . $entityType . '/*.json');

      $return[$entityType]['count'] = count($sampleFiles);

      // Attach all the uuid to the array of data.
      $return[$entityType]['uuids'] = [];
      foreach ($sampleFiles as $sampleFile) {
        $rawFileName = str_replace('.json', '', basename($sampleFile));
        $return[$entityType]['uuids'][] = $rawFileName;
      }
    }

    return $return;
  }

  /**
   * Load all the data for a given file.
   *
   * @param string $entityType
   *   The entity type to load.
   * @param string $uuid
   *   The uuid for the entity to load.
   *
   * @return string
   *   Data for this entity.
   */
  public function generateFileName(string $entityType, string $uuid) {
    $fileName = $uuid . '.json';
    return $this->outputFolder . '/' . $entityType . '/' . $fileName;
  }

  /**
   * {@inheritdoc}
   */
  public function readRawData(string $entityType, string $uuid) {
    return file_get_contents($this->generateFileName($entityType, $uuid));
  }

  /**
   * Get the root output folder.
   *
   * @return string
   *   The output folder.
   */
  public function getOutputFolder() {
    return $this->outputFolder;
  }

  /**
   * Set the output folder.
   *
   * @param string $outputFolder
   *   The output folder.
   */
  public function setOutputFolder(string $outputFolder) {
    $this->outputFolder = $outputFolder;
  }

}
