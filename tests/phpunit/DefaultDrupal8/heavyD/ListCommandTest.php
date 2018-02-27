<?php

namespace surangapg\Test\DefaultDrupal8\Seeder;

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
  }
}