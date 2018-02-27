<?php

namespace surangapg\Test\DefaultDrupal8\Seeder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class EtcEnvTest
 *
 * Checks that the various expected environment directories have been added.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class EtcSiteTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testEtcEnvDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcSiteDirDefaultExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default');

    // Only 3 files should exist.
    $subDirs = glob($this->getProjectDirectory() . '/etc/site/default/*', GLOB_ONLYDIR);
    $this->assertEquals(3, count($subDirs), 'Only 3 sub directories should exist.');

    // Check the actual file names.
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/config');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/properties');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/site/default/translations');
  }
}