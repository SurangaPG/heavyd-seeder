<?php

namespace Drupal\staged_content;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountSwitcherInterface;
use Drupal\staged_content\Storage\StorageHandlerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * A service for handling import of default content.
 *
 * @todo throw useful exceptions
 */
class LayeredImporter {

  /**
   * List of all the redefined id's.
   *
   * In case of duplication of id's a new id will be assigned.
   * If the id of an item was already set we'll reevaluate to preven errors
   * later. Note that all the references in the content storage are based on
   * the uuid, so this should not pose any issues. Except maybe in the rare
   * case of the 403, 404 and front page. So we'll emit a warning later for the
   * user to check the config manually.
   *
   * @var array
   *   List of all the id's that have been redefined.
   */
  protected $redefinedIds = [];

  /**
   * Defines relation domain URI for entity links.
   *
   * @var string
   */
  protected $linkDomain;

  /**
   * The serializer service.
   *
   * @var \Symfony\Component\Serializer\Serializer
   */
  protected $serializer;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * A list of vertex objects keyed by their link.
   *
   * @var array
   */
  protected $vertexes = [];

  /**
   * The graph entries.
   *
   * @var array
   */
  protected $graph = [];

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * The account switcher.
   *
   * @var \Drupal\Core\Session\AccountSwitcherInterface
   */
  protected $accountSwitcher;

  /**
   * The storage handler with all the content.
   *
   * @var \Drupal\staged_content\Storage\StorageHandlerInterface
   *   The storage handler with all the content.
   */
  protected $storageHandler;

  /**
   * Constructs the default content manager.
   *
   * @param \Symfony\Component\Serializer\Serializer $serializer
   *   The serializer service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Session\AccountSwitcherInterface $account_switcher
   *   The account switcher.
   */
  public function __construct(Serializer $serializer, EntityTypeManagerInterface $entity_type_manager, AccountSwitcherInterface $account_switcher) {
    $this->serializer = $serializer;
    $this->entityTypeManager = $entity_type_manager;
    $this->accountSwitcher = $account_switcher;
  }

  /**
   * Import all the data based on a given set of files.
   *
   * @param \Drupal\staged_content\Storage\StorageHandlerInterface $storageHandler
   *   The handler that holds all the information about the stored files.
   */
  public function importContent(StorageHandlerInterface $storageHandler) {
    $this->storageHandler = $storageHandler;
    $detectedTypes = $storageHandler->detectEntityTypes();

    // @TODO Improve output.
    foreach ($detectedTypes as $detectedTypeId => $info) {
      echo $detectedTypeId . " - count: " . $info['count'];
      echo $info['preserve_original_id'] ? " | Preserving ids \n" : "\n";
    }

    // Load in all the items that should saved first.
    // E.g the items that should have their id's preserved.
    $this->precreateEntitiesWithPreservedId($detectedTypes);

    // Add the actual entities.
    $this->updateReferences($detectedTypes);

    // Print out the final report if needed.
    // @TODO Improve logging.
    if (!empty($this->redefinedIds)) {
      echo " ======================== WARNING ======================== \n";
      echo " Duplicate id's were detected \n ";
      echo " following content has been assigned a new id: \n";

      foreach ($this->redefinedIds as $uuid => $entityInfo) {
        echo $uuid . ': ' . $entityInfo . "\n";
      }
      echo " ======================== ======= ======================== \n";
    }
  }

  /**
   * Ensures all the items that have their id's preserved are added.
   *
   * This ensures both their id and their revision id are kept in tune.
   *
   * @param array $types
   *   Array of all the types that will be imported.
   */
  public function precreateEntitiesWithPreservedId(array $types) {
    // When preserving the keys an entity will be added a first time without
    // any of it's references (to prevent interference when generating
    // the correct id's).
    $context['ignore_references'] = TRUE;

    foreach ($types as $entityTypeId => $info) {
      $dataList = $this->prepareList($entityTypeId, $info);

      // Import the "preserved" items first, and the "new" items second.
      foreach ($dataList['preserved'] as $preservedId => $uuid) {
        // @TOOD Improve output.
        echo "Precreating preserved item: " . $entityTypeId . ':' . $preservedId . ' => ' . $uuid . "\n";
        $this->importEntity($entityTypeId, $uuid, $context);
      }

      // Import the "new" items second since their id is not set in stone.
      foreach ($dataList['shifted'] as $uuid) {
        // @TOOD Improve output.
        echo "Precreating shifted item: " . $entityTypeId . ' => ' . $uuid . "\n";
        $this->importEntity($entityTypeId, $uuid, $context, TRUE);
      }

      // Import the "new" items second since their id is not set in stone.
      foreach ($dataList['new'] as $uuid) {
        // @TOOD Improve output.
        echo "Precreating new item: " . $entityTypeId . ' => ' . $uuid . "\n";
        $this->importEntity($entityTypeId, $uuid, $context);
      }
    }
  }

  /**
   * Add all the entities, since all the needed straight items have been added.
   *
   * @param array $types
   *   Array of all the types that will be imported.
   */
  public function updateReferences(array $types) {
    // Second pass, with auto importing of the references.
    foreach ($types as $entityTypeId => $info) {
      foreach ($info['uuids'] as $preservedId => $uuid) {
        // @TOOD Improve output.
        echo "Completing references for " . $entityTypeId . ':' . $uuid . "\n";
        $this->importEntity($entityTypeId, $uuid);
      }
    }
  }

  /**
   * Prepare/sort the list of items.
   *
   * This will ensure that any items that should preserve their id's are added
   * first and in the correct order. Afterwards any items that should not
   * preserve their id's are added.
   *
   * @param string $entityType
   *   The type of the entity.
   * @param array $info
   *   All the extra info connected to the entity type.
   *
   * @return array
   *   All the data to import, in the correct order.
   */
  protected function prepareList(string $entityType, array $info) {
    $itemList = [
      'preserved' => [],
      'shifted' => [],
      'new' => [],
    ];

    foreach ($info['uuids'] as $uuid) {
      $data = $this->serializer->decode($this->storageHandler->readRawData($entityType, $uuid), 'storage_json');

      if ($data['meta']['preserve_original_id']) {
        // If the id of an item was already set we'll reevaluate to prevent
        // errors later. Note that all the references in the content storage
        // are based on the uuid, so this should not pose any issues. Except
        // maybe in the rare case of the 403, 404 and front page.
        // So we'll emit a warning later for the user to check the config
        // manually.
        if (isset($itemList['preserved'][$data['meta']['original_id']])) {
          // @TODO Improve Logging.
          echo sprintf("Preserved id altered! \n");
          echo sprintf("%s with id: %s was already defined for uuid: %s \n", $entityType, $data['meta']['original_id'], $itemList['preserved'][$data['meta']['original_id']]);

          // Place this item to the "new" queue to enforce generating a new id.
          $itemList['shifted'][] = $uuid;

          // Mark this item, so we can display the information later.
          $this->redefinedIds[$uuid] = $entityType . ':' . $data['meta']['original_id'] . ' --> ';
        }
        else {
          $itemList['preserved'][$data['meta']['original_id']] = $uuid;
        }
      }
      else {
        $itemList['new'][] = $uuid;
      }
    }

    ksort($itemList['preserved']);

    return $itemList;
  }

  /**
   * Import a single entity.
   *
   * @param string $entityType
   *   The entity type.
   * @param string $uuid
   *   The uuid.
   * @param array $context
   *   Extra context for the import/.
   * @param bool $stripPreservedId
   *   In some cases the preserved id has to be stripped from the data.
   *   This is most common in case of duplicate entity id's. Where the preserved
   *   Id is automatically shifted.
   */
  protected function importEntity(string $entityType, string $uuid, array $context = [], bool $stripPreservedId = FALSE) {
    $context += [
      'ignore_references' => FALSE,
    ];

    $decoded = $this->serializer->decode($this->storageHandler->readRawData($entityType, $uuid), 'storage_json');

    // Hard strip the original id if relevant.
    if ($stripPreservedId) {
      $decoded['meta']['preserve_original_id'] = FALSE;
      unset($decoded['meta']['original_id']);
    }

    $class = $this->entityTypeManager->getDefinition($entityType)->getClass();
    $denormalized = $this->serializer->denormalize($decoded, $class, 'storage_json', $context);
    $denormalized->save();

    // If this item was marked as one of the items with it's id redefined,
    // Mark the new id here.
    if ($stripPreservedId && isset($this->redefinedIds[$denormalized->uuid()])) {
      $this->redefinedIds[$denormalized->uuid()] .= $denormalized->id();
    }
  }

}
