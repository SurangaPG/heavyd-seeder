<?php

namespace surangapg\Test\DefaultDrupal8\HeavyD;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ListCommandTest
 */
class ListCommandTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testListCommand() {
    $output = [];
    $this->projectRunHeavyd('list', $output);

    // Assert some basic commands:
    $this->assertContains('list', $output['stdout'], 'The command should have been visible in the outputted list');
    $this->assertContains('help', $output['stdout'], 'The command should have been visible in the outputted list');
  }
}
