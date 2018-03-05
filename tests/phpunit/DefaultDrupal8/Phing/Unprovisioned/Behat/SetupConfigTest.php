<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Uprovisioned\Behat;

use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;

/**
 * Class ListCommandTest
 */
class SetupConfigCommandTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the behat.yml file is generated correctly.
   */
  public function testGenerateConfigFile() {
    // Make sure the file doesn't exist yet.
    $this->fs->remove($this->getProjectDirectory() . '/tests/behat/behat.yml');

    $output = [];
    $return = $this->projectRunPhing('behat:setup-config', $output);
    $this->assertCommandSuccessful($return, $output['stderr']);

    $this->assertFileContainsValidYml($this->getProjectDirectory() . '/tests/behat/behat.yml');
    $this->assertFileHasNoPlaceholders($this->getProjectDirectory() . '/tests/behat/behat.yml');
  }

}