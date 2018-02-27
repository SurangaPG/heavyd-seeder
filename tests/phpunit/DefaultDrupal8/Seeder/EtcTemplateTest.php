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
class EtcTemplateTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testEtcTemplateDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/etc/template');
    $subDir = glob($this->getProjectDirectory() . '/etc/template/*');
    $this->assertEquals(2, count($subDir), 'Only 2 files should exist in the etc/template folder.');
  }
}