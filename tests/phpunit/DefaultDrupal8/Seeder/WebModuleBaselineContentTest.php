<?php

namespace surangapg\Test\DefaultDrupal8\Seeder;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class TestsTest
 */
class WebModuleBaselineContentTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the etc folder exists.
   */
  public function testPropertiesDirExists() {
    $this->assertFileExists($this->getProjectDirectory() . '/web/modules/custom/baseline_content');
    $this->assertFileExists($this->getProjectDirectory() . '/web/modules/custom/baseline_content/baseline_content.info.yml');
  }
}
