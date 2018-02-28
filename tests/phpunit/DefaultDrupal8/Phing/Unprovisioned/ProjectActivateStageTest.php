<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectActivateStageTest
 */
class ProjectActivateStageTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an environment fails to activate when properties are missing.
   */
  public function testActivateStageWithoutProperties() {
    $output = [];
    $return = $this->projectRunPhing('project:activate-stage', $output);
    $this->assertCommandNotSuccessful($return, 'project:activate-stage shouldn \'t have been able to run without specifying an environment.');
  }

  /**
   * Checks or an environment fails to activate when the env is missing.
   */
  public function testActivateStageWithNonExistingStage() {
    $this->markTestIncomplete('To be completed, pointing at an stage that does not have a dir should fail.');
  }

  /**
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateStageAcc() {
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=acc', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the stage.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/acc/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/acc/properties/project.yml', $this->getProjectDirectory() . '/properties/stage/project.yml');

    // Ensure the services.yml doesn't exist.
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/services.stage.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }

  /**
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateStageDev() {
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=dev', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the stage.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/dev/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/dev/properties/project.yml', $this->getProjectDirectory() . '/properties/stage/project.yml');

    // Ensure the services.yml file is correct exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/dev/services.stage.yml', $this->getProjectDirectory() . '/web/sites/default/services.stage.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }


  /**
   * Checks or an the install stage is activated correctly.
   */
  public function testActivateStageInstall() {
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=install', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the stage.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/install/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/install/properties/project.yml', $this->getProjectDirectory() . '/properties/stage/project.yml');

    // Ensure the services.yml doesn't exist.
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/services.stage.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }

  /**
   * Checks or an the prod stage is activated correctly.
   */
  public function testActivateStageProd() {
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=prod', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the stage.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/prod/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/prod/properties/project.yml', $this->getProjectDirectory() . '/properties/stage/project.yml');

    // Ensure the services.yml doesn't exist.
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/services.stage.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }

  /**
   * Checks or an the prod stage is activated correctly.
   */
  public function testActivateStageTest() {
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=test', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the stage.');

    // Check that the services.stage.yml file does not exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/test/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');

    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/test/properties/project.yml', $this->getProjectDirectory() . '/properties/stage/project.yml');

    // Ensure the services.yml doesn't exist.
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/services.stage.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }
}