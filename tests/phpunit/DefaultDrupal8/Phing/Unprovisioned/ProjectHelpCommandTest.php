<?php

namespace surangapg\Test\DefaultDrupal8\Phing\Unprovisioned;

use PHPUnit\Framework\TestCase;
use surangapg\Test\DefaultDrupal8\AbstractDefaultDrupal8BaseTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ListCommandTest
 */
class ProjectHelpCommandTest extends AbstractDefaultDrupal8BaseTestCase {

  /**
   * Checks or the heavyd.project.xml exists.
   */
  public function testListCommand() {
    $output = [];
    $this->projectRunPhing('project:help', $output);

    // Assert some basic commands:
    foreach ($this->provideCommandList() as $command) {
      $this->assertContains($command, $output['stdout'], 'The command "' . $command .'" should have been visible in the outputted list');
    }
  }

  /**
   * @TODO Split these up per smaller part.
   *
   * @return array
   *   List of all the commands this part expects.
   */
  protected function provideCommandList() {
    return [
      "composer:build",
      "composer:dev",
      "composer:full",

      "docker-compose:status",
      "docker-compose:stop",
      "docker-compose:up",

      "docker:selenium-bridged-start",
      "docker:selenium-start",
      "docker:selenium-start-debug",
      "docker:selenium-stop",
      "docker:setup-compose",

      "drupal:env:activate-etc-files",
      "drupal:env:settings-file",
      "drupal:init:baseline-module",
      "drupal:init:baseline-theme",
      "drupal:init:cleanup",
      "drupal:init:config",
      "drupal:init:site-dir",
      "drupal:stage:activate-etc-files",
      "drupal:stage:htaccess",
      "drupal:stage:htpasswd",
      "drupal:stage:robots",
      "drupal:stage:services",
      "drupal:stage:settings-file",
      "drupal:stage:sites",

      "haunt:baseline",
      "haunt:compare",

      "project:activate-env",
      "project:activate-site",
      "project:activate-stage",
      "project:build",
      "project:init",
      "project:install",
      "project:install-dependencies",
      "project:property-cleanse",
      "project:reset-install",
      "project:selenium-start",
      "project:selenium-start-debug",
      "project:selenium-stop",
      "project:setup",
      "project:setup-services",
      "project:start-services",
      "project:stop-services",
      "project:write-property-files",

      "property:activate:env",
      "property:activate:site",
      "property:activate:stage",
      "property:cleanse",
      "property:cleanse:env",
      "property:cleanse:generated",
      "property:cleanse:site",
      "property:cleanse:stage",

      "server:env-file:validate",
      "server:host-file",
      "server:host-file:validate",
    ];
  }
}
