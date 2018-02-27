<?php

namespace surangapg\Test\DefaultDrupal8\Seeder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class EtcStageTest
 *
 * Checks that the various expected stage directories have been added.
 */
class EtcStageTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testStageDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirExists() {

    // Only 3 files should exist.
    $subDirs = glob($this->getProjectDirectory() . '/etc/stage/*', GLOB_ONLYDIR);
    $this->assertEquals(5, count($subDirs), 'Only 5 sub directories should exist.');

    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/acc');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/dev');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/install');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/prod');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/test');

  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirAccExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/acc/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/acc/settings.stage.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirDevExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/dev/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/dev/settings.stage.php');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/dev/services.stage.yml');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirInstallExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/install/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/install/settings.stage.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirProdExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/prod/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/prod/settings.stage.php');
  }

  /**
   * Checks or the docker basic files exist.
   */
  public function testEtcStageDirTestExists() {

    // Check the property file.
    $propertyFiles = glob($this->getProjectDirectory() . '/etc/stage/test/properties/*.yml');
    $this->assertEquals(1, count($propertyFiles), 'Only 1 property file should exist.');
    $this->assertFileExists($this->getProjectDirectory() . '/etc/stage/test/settings.stage.php');
  }
}