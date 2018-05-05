<?php

namespace Drupal\staged_content\Storage;

/**
 * Interface to make the way data is stored to the filesystem more uniform.
 */
interface StorageHandlerInterface {

  /**
   * StorageHandlerInterface constructor.
   *
   * @param array $config
   *   Optional an array with config.
   */
  public function __construct(array $config = []);

  /**
   * Write away the data for an entity.
   *
   * @param string $data
   *   The normalized data for the entity to store.
   * @param string $entityType
   *   The entity type.
   * @param string $uuid
   *   The original id for the entity (if it has to be stored).
   */
  public function storeData(string $data, string $entityType, string $uuid);

  /**
   * Detect all the entity types that should be imported.
   *
   * @return array
   *   Array of entity types. With meta data about how they should be handled.
   */
  public function detectEntityTypes();

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
  public function readRawData(string $entityType, string $uuid);

}
