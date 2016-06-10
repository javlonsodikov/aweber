<?php
/**
 * Created by PhpStorm.
 * Author: Javlon Sodikov
 * Date time: 10.06.2016 19:37
 */

//List in awber website. Subscribers will be imported in this url. Please fill put listname exactly as in awber website.
$listname = "Incomehack Group";


//Awber username and password
$username = "";
$password = "";

//show importing process
$debug = true;

//DONT change configs below this line
$csv_path = __DIR__ . '/csv/';

//imported csv files
$imported_files_path = __DIR__ . '/imported/';

//app url
$app_url = "https://auth.aweber.com/1.0/oauth/authorize_app/1b14fabd";


