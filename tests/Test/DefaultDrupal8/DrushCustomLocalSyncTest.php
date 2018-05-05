<?php

namespace surangapg\HeavydSeeder\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\HeavydSeeder\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class TestsTest
 */
class DrushCustomLocalSyncTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/drush/custom/drush_locale_sync');
    $this->assertFileExists($this->getProjectDirectory() . '/drush/custom/drush_locale_sync/drush_locale_sync.drush.inc');
  }
}
