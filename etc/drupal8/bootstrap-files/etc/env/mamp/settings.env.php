<?php

// Generate a dummy local hash
$dummy_hash = [];
exec('whoami', $dummy_hash);
$settings['hash_salt'] = base64_encode($dummy_hash[0] . __DIR__);

// Read the machine name from the current dir
$baseSiteName = basename(__DIR__);

/*
 * Read all the other data from the db properties.
 */
$dbPropertiesFile = dirname(dirname(dirname(__DIR__))) . '/properties/db.yml';
$dbPropertieSets = ['default--default' => []];

if (file_exists($dbPropertiesFile)) {
  $dbPropertieSets = \Symfony\Component\Yaml\Yaml::parse(
    file_get_contents($dbPropertiesFile)
  );
}

/*
 * Fish the data for the local server from the config
 * If no settings can be found we'll default to meaningful defaults which should
 * allow most devs to install the site without adding a local setup.
 */
foreach ($dbPropertieSets as $keyName => $dbPropertieSet) {
  $keyName = explode('--', $keyName);
  $databases[$keyName[0]][$keyName[1]] = [
    'host' => isset($dbPropertieSet['host']) ? $dbPropertieSet['host'] : 'localhost',
    'port' => isset($dbPropertieSet['port']) ? $dbPropertieSet['port'] : '3306',
    'username' => isset($dbPropertieSet['user']) ? $dbPropertieSet['user'] : 'root',
    'password' => isset($dbPropertieSet['password']) ? $dbPropertieSet['password'] : 'root',
    'database' => isset($dbPropertieSet['database']) ? $dbPropertieSet['database'] : 'workflow_8_' . $keyName . '_' . md5(__DIR__),
    'driver' => isset($dbPropertieSet['db_driver']) ? $dbPropertieSet['driver'] : 'mysql',
    'namespace' => isset($dbPropertieSet['namespace']) ? $dbPropertieSet['namespace'] : "Drupal\\Core\\Database\\Driver\\mysql",
  ];
}
