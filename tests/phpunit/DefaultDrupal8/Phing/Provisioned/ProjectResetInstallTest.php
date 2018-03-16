<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectInstallTest
 */
class ProjectResetInstallTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an install can be reset correctly even in a fully locked file
   * system.
   */
  public function testProjectResetInstall() {

    // @TODO Lock the filesystem fully.

    $output = [];
    $return = $this->projectRunPhing('project:reset-install', $output);
    $this->markTestIncomplete('To be completed, project reset install should pass in a fully locked file system.');
  }
}