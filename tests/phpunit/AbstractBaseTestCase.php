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
   * Does the return data of the command indicate that it was successful.
   *
   * @param int $return
   *   Return value for the command.
   * @param string $message
   *   The message to display.
   */
  public function assertCommandSuccessful($return, $message = '') {
    $message = 'Command failed: ' . PHP_EOL . $message;
    $this->assertEquals(0, $return, $message);
  }

  /**
   * Does the return data of the command indicate that it was not successful.
   *
   * @param int $return
   *   Return value for the command.
   * @param string $message
   *   The message to display.
   */
  public function assertCommandNotSuccessful($return, $message = '') {
    $this->assertNotEquals(0, $return, $message);
  }

  /**
   * Check or a file exists.
   *
   * @param $file
   *   Path to file.
   * @param $message
   *   Message to display.
   */
  public function assertFile($file, $message = '') {
    static::assertFileExists($file, $message);
  }

  /**
   * Check that a file doesn't exist.
   *
   * @param $file
   *   Path to file.
   * @param $message
   *   Message to display.
   */
  public function assertFileNot($file, $message = '') {
    static::assertFileNotExists($file, $message);
  }

  /**
   * Runs a heavyD command in the project.
   *
   * @param string $command
   *   The heavyd command to run (e.g project:switch-stage dev).
   * @param bool array $output
   *   The output for the command.
   *
   * @return integer
   *   Return value for the command.
   */
  protected function projectRunHeavyd($command, &$output = []) {
    $command = './.heavyd/vendor/bin/heavyd ' . $command;
    return $this->projectRun($command, $output);
  }

  /**
   * Runs a phing command in the project for this testcase.
   *
   * @param string $target
   *   The phing target to run.
   * @param bool array $output
   *   The output for the command.
   *
   * @return integer
   *   Return value for the command.
   */
  protected function projectRunPhing($target, &$output = []) {
    $command = './.heavyd/vendor/bin/phing ' . $target;
    $this->projectRun($command, $output);

    $stdErrFlag = (strpos($output['stderr'], 'BUILD FAILED') !== false);
    $stdOutFlag = (strpos($output['stdout'], 'BUILD FAILED') !== false);

    // Check the return output for the flag that marks phing as a success.
    return (int) ($stdErrFlag || $stdOutFlag);
  }

  /**
   * Runs a bash command in the project for this testcase.
   *
   * @param string $command
   *   The command to run.
   * @param bool array $output
   *   The output for the command.
   *
   * @return integer
   *   Return value for the command.
   */
  protected function projectRun($command, &$output = []) {

    $return = $this->runCommand($command, $output, $this->getProjectDirectory());
    // Account for the fact that writing out the stderr in the pipeline seems
    // to cause the return value to become 0
    if ($return == 0) {
      $return = (int) !empty($output['stderr']);
    }

    return $return;
  }

  /**
   * Runs a bash command in the container dir.
   *
   * @param string $command
   *   The command to run.
   * @param array $output
   *   The output for the command.
   * @param string dir
   *   The directory to run the command in.
   *
   * @return integer
   *   Return value for the command.
   */
  private function runCommand($command, &$output = [], $dir) {

    /*
     * Since we want to be able to show the error output but don't want it
     * printed inside the unit tests. We'll write it to a file and extract
     * it later.
     *
     * @TODO If this can be cleaner it really should be but I can't figure it out.
     */
    $tempFile = getcwd() . '/temp/command-output-' . time() . '.txt';
    $tempErrorFile = getcwd() . '/temp/command-output-' . time() . '-error.txt';

    $command .= ' >' . $tempFile . ' 2>' . $tempErrorFile;

    exec(sprintf("cd %s && %s", $dir, $command), $output, $return);

    $output['stderr'] = file_get_contents($tempErrorFile);
    $output['stdout'] = file_get_contents($tempFile);

    $this->fs->dumpFile($tempFile, $command . PHP_EOL . $output['stderr'] . PHP_EOL . $output['stdout']);

    return $return;
  }

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