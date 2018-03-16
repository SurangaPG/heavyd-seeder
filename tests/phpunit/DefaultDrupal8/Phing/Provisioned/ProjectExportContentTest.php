<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectInstallTest
 */
class ProjectExportTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an install can be reset correctly even in a fully locked file
   * system.
   */
  public function testProjectExportContent() {

    $output = [];
    $return = $this->projectRunPhing('project:export-content', $output);
    $this->markTestIncomplete('To be completed, project export content should generate the needed files in the etc/stage/content dirs.');
  }

  /**
   * Any files not in the current set should be removed from the filesystem.
   */
  public function testProjectExportContentClean() {

    $output = [];
    $return = $this->projectRunPhing('project:export-content', $output);
    $this->markTestIncomplete('To be completed, project export content should generate the needed files in the etc/stage/content dirs.');
  }
}