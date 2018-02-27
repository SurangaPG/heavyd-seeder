<?php

namespace surangapg\Test\Seeder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\Test\AbstractBaseTestCase;

/**
 * Class HeavyDFileTest
 *
 * Checks or the .heavyD file was generated and contains the correct data.
 *
 * @package test\Drupal8
 *
 * @covers seed:init
 */
class HeavyDFileTest extends AbstractBaseTestCase {

  /**
   * Checks or the project dir exists and has some expected basic files.
   */
  public function testHeavyDFileExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/.heavyd');
  }
}