<?php

namespace surangapg\Test\DefaultDrupal8\Seeder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class HeavyDFileTest
 *
 * Checks or the .heavyD file was generated and contains the correct data.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class ComposerTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the composer.json exists.
   */
  public function testComposerJsonExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/composer.json');
  }

  /**
   * Checks or the composer.lock exists.
   */
  public function testComposerLockExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/composer.lock');
  }
}