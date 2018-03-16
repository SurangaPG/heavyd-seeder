<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectActivateEnvTest
 */
class ProjectPropertyWritePropertyFilesTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks that cleansing a project removes all the needed yml files.
   */
  public function testPropertyCleanse() {
    $output = [];
    $return = $this->projectRunPhing('project:write-property-files', $output);
    $this->markTestIncomplete('Validate that all the properties have been generated.');
  }

}
