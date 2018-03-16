<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectInstallTest
 */
class ProjectInstallTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an environment fails to activate when properties are missing.
   */
  public function testProjectInstall() {
    $output = [];
    $return = $this->projectRunPhing('project:install', $output);
    $this->markTestIncomplete('To be completed, project install without specifying stage/env/site should default.');
  }
}