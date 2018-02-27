<?php

namespace surangapg\Test\DefaultDrupal8;

use PHPUnit\Framework\TestCase;
use surangapg\Test\AbstractBaseTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractDefaultDrupal8BaseTestCase extends AbstractBaseTestCase {

  public function generateProjectDirectory() {
    return getcwd() . '/build/default-d8';
  }

}