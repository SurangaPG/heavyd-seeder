<?php

namespace surangapg\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractBaseTestCase extends TestCase {

  /**
   * The directory where the actual project will reside.
   * @var string
   */
  protected $projectDirectory;

  /**
   * Filesystem class so we don't have to instantiate it all over.
   *
   * @var Filesystem
   */
  protected $fs;

  /**
   * DrupalBaseTest constructor.
   * @inheritdoc
   */
  public function __construct($name = null, array $data = [], $dataName = '') {

    $this->setProjectDirectory($this->generateProjectDirectory());

    $this->fs = new Filesystem();

    parent::__construct($name, $data, $dataName);
  }

  abstract function generateProjectDirectory();

  /**
   * @param string $projectDirectory
   */
  public function setProjectDirectory($projectDirectory) {
    $this->projectDirectory = $projectDirectory;
  }

  /**
   * @return string
   */
  public function getProjectDirectory() {
    return $this->projectDirectory;
  }

}