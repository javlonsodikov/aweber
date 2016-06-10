<?php

require_once('config.php');

//Awber API
require_once('aweber_api/aweber_api.php');

//Components work with
require('components/authweber.php');
require('components/createsubscriber.php');
$auth_key = AuthWeber::getAuthKey($app_url, $username, $password);
if ($debug) echo "Key:" . $auth_key[0] . PHP_EOL;
$app = new CreateSubscriber($auth_key[0]);
$app->setDebug($debug);
$list = $app->findList($listname);

$files = glob($csv_path . '*.csv');
foreach ($files as $file) {
    echo "Importing file: " . $file . PHP_EOL;
    $handle = fopen($file, "r");
    //skip first header line
    $line = fgets($handle);

    while ($data = fgetcsv($handle)) {
        $Timer = new microTimer();
        $subscriber = array(
            'email' => $data[0],
            'name' => $data[1] . ' ' . $data[2],
            'status' => 'subscribed'
        );
        if ($app->addSubscriber($subscriber, $list)) {
            if ($debug) {
                echo " - " . $data[0] . " successfully imported" . PHP_EOL;
            }
        }
        if (intval($Timer->get()) < 1) {
            sleep(1);
        }
    }
    fclose($handle);
    $processed_filename = pathinfo($file, PATHINFO_BASENAME);
    @rename($file, $imported_files_path . $processed_filename);
}








