<?php

/**
 * @file includes the needed settings form for a level27 server.
 */

$envFile = dirname(dirname(dirname(__DIR__))) . '/.env';

// Get the files from the .env file
$envConf = base64_decode(file_get_contents($envFile));
$envConf = json_decode($envConf, TRUE);

foreach ($envConf['database'] as $joinedKey => $data) {
  $keyParts = explode('--', $joinedKey);

  $databases[$keyParts[0]][$keyParts[1]] = $data;
}

$settings['hash_salt'] = $envConf['hash_salt'];