<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProjectActivateSiteTest
 */
class ProjectActivateSiteTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or an environment fails to activate when properties are missing.
   */
  public function testActivateSiteWithoutProperties() {
    $output = [];
    $return = $this->projectRunPhing('project:activate-site', $output);
    $this->assertCommandNotSuccessful($return, 'project:activate-site shouldn \'t have been able to run without specifying an environment.');
  }

  /**
   * Checks or an environment fails to activate when the env is missing.
   */
  public function testActivateSiteWithNonExistingEnv() {
    $this->markTestIncomplete('To be completed, pointing at an site that does not have a dir should fail.');
  }

  /**
   * Checks or an the docker env is activated correctly.
   */
  public function testActivateSiteDefault() {
    $return = $this->projectRunPhing('project:activate-site -Dsite.to.activate=default', $output);
    $this->assertCommandSuccessful($return, 'Failed to activate the site.');


    // Ensure all the property files are correct.
    $this->assertFileEquals($this->getProjectDirectory() . '/etc/site/default/properties/project.yml', $this->getProjectDirectory() . '/properties/site/project.yml');

    // Validate the count of items.
    $items = glob($this->getProjectDirectory() . '/properties/site/*.yml');
    $this->assertEquals(1, count($items), 'Incorrect number of items found.');
  }
}