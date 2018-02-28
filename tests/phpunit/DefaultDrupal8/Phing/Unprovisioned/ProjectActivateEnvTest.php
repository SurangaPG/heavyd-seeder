<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectActivateEnvTest
 */
class ProjectActivateEnvTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an environment fails to activate when properties are missing.
   */
  public function testActivateEnvWithoutProperties() {
    $output = [];
    $return = $this->projectRunPhing('project:activate-env', $output);
    $this->assertCommandNotSuccessful($return, 'project:activate-env shouldn \'t have been able to run without specifying an environment.');
  }

  /**
   * Checks or an environment fails to activate when the env is missing.
   */
  public function testActivateEnvWithoutNonExistingEnv() {
    $this->markTestIncomplete('To be completed, pointing at an environment that does not have a dir should fail.');
  }

  /**
   * Checks or an environment fails to activate when the env is missing.
   */
  public function testActivateEnvProd() {
    $return = $this->projectRunPhing('project:activate-env -Denv.to.activate=docker', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the environment.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/docker/settings.env.php', $this->getProjectDirectory() . '/web/sites/default/settings.env.php');

  }

}
