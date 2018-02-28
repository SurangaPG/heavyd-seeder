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
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateEnvDocker() {
    $return = $this->projectRunPhing('project:activate-env -Denv.to.activate=docker', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the environment.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/docker/settings.env.php', $this->getProjectDirectory() . '/web/sites/default/settings.env.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/docker/properties/docker.yml', $this->getProjectDirectory() . '/properties/env/docker.yml');
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/docker/properties/host.yml', $this->getProjectDirectory() . '/properties/env/host.yml');
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/docker/properties/project.yml', $this->getProjectDirectory() . '/properties/env/project.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/env/*.yml');
    $this->assertEquals(3, count($items), 'Incorrect number of items found.');
  }

  /**
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateEnvEnvFile() {
    $return = $this->projectRunPhing('project:activate-env -Denv.to.activate=env-file', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the environment.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/env-file/settings.env.php', $this->getProjectDirectory() . '/web/sites/default/settings.env.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/env-file/properties/project.yml', $this->getProjectDirectory() . '/properties/env/project.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/env/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }

  /**
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateEnvLocalhost() {
    $return = $this->projectRunPhing('project:activate-env -Denv.to.activate=localhost', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the environment.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/localhost/settings.env.php', $this->getProjectDirectory() . '/web/sites/default/settings.env.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/env/localhost/properties/project.yml', $this->getProjectDirectory() . '/properties/env/project.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/env/*.yml');
    $this->assertEquals(3, count($items), 'Incorrect number of items found.');
  }
}
