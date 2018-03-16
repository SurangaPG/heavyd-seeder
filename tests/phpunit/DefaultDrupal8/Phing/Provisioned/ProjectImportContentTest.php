<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectInstallTest
 */
class ProjectImportContentTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks that content can be imported correctly.
   */
  public function testProjectExportContent() {

    $output = [];
    $return = $this->projectRunPhing('project:import-content', $output);
    $this->markTestIncomplete('To be completed, project import content should be able to add content to the site.');
  }
}