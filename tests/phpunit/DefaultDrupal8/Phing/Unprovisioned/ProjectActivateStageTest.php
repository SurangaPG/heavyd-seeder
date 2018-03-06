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
   * Checks or an environment can activate a stage.
   */
  public function testActivateStage() {

    // Ensure the stage dir exists.
    $this->provideDummyDir('etc/stage/temp');

    $output = [];
    $return = $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);
    $this->assertCommandSuccessful($return, 'project:activate-stage should have been able to run without specifying an environment.');

    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

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
   * Checks or a settings.stage.php file is copied over as expected.
   */
  public function testActivationSettingsPhp() {
    $this->provideDummyFile('etc/stage/temp/settings.stage.php');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/settings.stage.php', $this->getProjectDirectory() . '/web/sites/default/settings.stage.php');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a settings.stage.php file is deleted correctly if none exists in the stage.
   */
  public function testActivationDeleteSettingsPhp() {
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/settings.stage.php');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a settings.stage.php file is copied over as expected.
   */
  public function testActivationServicesYml() {
    $this->provideDummyFile('etc/stage/temp/services.stage.yml');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/services.stage.yml', $this->getProjectDirectory() . '/web/sites/default/services.stage.yml');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a services.stage.yml file is deleted correctly if none exists in the stage.
   */
  public function testActivationDeleteServicesYml() {
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/default/services.stage.yml');
  }

  /**
   * Checks or a robots.txt file is copied over as expected.
   */
  public function testActivationRobotsTxt() {
    $this->provideDummyFile('etc/stage/temp/robots.txt');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/robots.txt', $this->getProjectDirectory() . '/web/robots.txt');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a services.stage.yml file is reset correctly if none exists in the stage.
   */
  public function testActivationResetRobotsTxt() {
    $this->markTestIncomplete('To be completed, Should we backup the "default" robots.txt.');
  }

  /**
   * Checks or a .htaccess file is copied over as expected.
   */
  public function testActivationHtaccess() {
    $this->provideDummyFile('etc/stage/temp/.htaccess');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/.htaccess', $this->getProjectDirectory() . '/web/.htaccess');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a .htaccess file is reset correctly if none exists in the stage.
   */
  public function testActivationResetHtaccess() {
    $this->markTestIncomplete('To be completed, Should we backup the "default" .htaccess?');
  }

  /**
   * Checks or a .htpasswd file is copied over as expected.
   */
  public function testActivationHtpasswd() {
    $this->provideDummyFile('etc/stage/temp/.htpasswd');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/.htpasswd', $this->getProjectDirectory() . '/.htpasswd');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a .htaccess file is reset correctly if none exists in the stage.
   */
  public function testActivationDeleteHtpasswd() {
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);
    $this->assertFileNot($this->getProjectDirectory() . '/.htpasswd');
  }

  /**
   * Checks or a sites.stage.php file is copied over as expected.
   */
  public function testActivationSitesPhp() {
    $this->provideDummyFile('etc/stage/temp/sites.stage.php');
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);

    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/temp/sites.stage.php', $this->getProjectDirectory() . '/web/sites/sites.stage.php');
    $this->fs->remove($this->getProjectDirectory() . '/etc/stage/temp');
  }

  /**
   * Checks or a sites.stage.php file is reset correctly if none exists in the stage.
   */
  public function testActivationDeleteSitesPhp() {
    $this->projectRunPhing('project:activate-stage -Dstage.to.activate=temp', $output);
    $this->assertFileNot($this->getProjectDirectory() . '/web/sites/sites.stage.php');
  }

  /**
   * Checks or an the docker stage is activated correctly.
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

    // Ensure the services.yml file is correct exist.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/install/services.stage.yml', $this->getProjectDirectory() . '/web/sites/default/services.stage.yml');


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

    // Ensure the .htaccess file is correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/stage/prod/.htaccess', $this->getProjectDirectory() . '/web/.htaccess');

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