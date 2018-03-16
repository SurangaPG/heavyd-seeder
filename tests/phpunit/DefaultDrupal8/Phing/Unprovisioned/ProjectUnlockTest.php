<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectActivateEnvTest
 */
class ProjectUnlockTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks that cleansing a project removes all the needed yml files.
   */
  public function testPropertyCleanse() {
    $output = [];
    $return = $this->projectRunPhing('project:unlock', $output);
    $this->markTestIncomplete('Check that the filesystem is unlocked.');
  }

}
