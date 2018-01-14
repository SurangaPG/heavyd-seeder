<?php

/**
 * @file
 * This is a basic settings file. It forms the root of any project.
 */

// Default Drupal 8 settings.
//
// These are already explained with detailed comments in Drupal's
// default.settings.php file.
//
// See https://api.drupal.org/api/drupal/sites!default!default.settings.php/8
$databases = [];
$config_directories = [];
$settings['update_free_access'] = FALSE;

// Config installer is used as the install profile to enable installing on
// write only environments such as platform.sh
$settings['install_profile'] = 'config_installer';

//
$config_directories[CONFIG_SYNC_DIRECTORY] = '../etc/site/' . basename(__DIR__) . '/config';

// Export the dev stage data to the correct folder.
$config['config_split.config_split.stage_dev']['folder'] = '../etc/stage/dev/config';

$settings['file_private_path'] = __DIR__ . '/files/private';
$config['system.file']['path']['temporary'] = __DIR__ . '/files/temp';
$config['locale.settings']['translation']['path'] = '../etc/site/' . basename(__DIR__) . '/translations';

/*
 * Get the different level of service.yml files. These follow the same logic as
 * the settings.php files. And are also injected by the activating of a stage or
 * env.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';
if (file_exists(__DIR__ . '/services.stage.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.stage.yml';
}

if (file_exists(__DIR__ . '/services.env.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.env.yml';
}

/*
 * Detect the local settings file if it is set, this allows for the
 * adding of dev settings to the repo. Note that no sensitive database info
 * that should be added to the ignored settings.env.php
 */
if (file_exists(__DIR__ . '/settings.stage.php')) {
  include __DIR__ . '/settings.stage.php';
}

/*
 * As a final step include the env files. These read in any db information etc
 */
if (file_exists(__DIR__ . '/settings.env.php')) {
  include __DIR__ . '/settings.env.php';
}
