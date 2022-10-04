<?php

use Aws\S3\S3Client;

require 'vendor/autoload.php';

$config = require('application/config/cloud.php');

// S3
$s3 = S3Client::factory([
    'version'     => 'latest',
    'region'      => 'eu-central-1',
    'credentials' => [
        'key'    => $config['s3']['key'],
        'secret' => $config['s3']['secret'],
    ]
]);


