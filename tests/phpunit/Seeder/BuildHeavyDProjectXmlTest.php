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
class BuildHeavyDProjectXmlTest extends AbstractBaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testBuildHeavyDProjectXmlExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/heavyd.project.xml');
  }
}