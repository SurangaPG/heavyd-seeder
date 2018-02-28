<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class BuildTest
 *
 * @TODO Extend the tested cases.
 */
class ProjectBuildTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testListCommand() {
    $output = [];

    // Remove this before the install to check that it was regenerated.
    $this->fs->remove($this->getProjectDirectory() . '/vendor');

    $this->projectRunPhing('project:build', $output);

    $this->assertFile($this->getProjectDirectory() . '/vendor');
  }
}
