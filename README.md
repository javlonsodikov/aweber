AWeber email importer
author: Javlon Sodikov

Important note fom API: 
https://labs.aweber.com/docs/faq
>>How many requests can my application make in a given amount of time?
>>AWeber API requests are limited to 60 requests per minute, per customer account.
so import rate is one email per second 
if you will have 10 000 emails they will be imported in 2 hours 40 minutes  
 

1. Give write permissions in server
chmod 0777 csv 
chmod 0777 imported


2. Configure config.php

//List in awber website. Subscribers will be imported in this list
$listname="List Group";

//Your Awber username
$username = "";

//Your Awber password
$password = "";

//If you will set it true more verbose data will be printed to your screen
$debug = true or false; 

3. put your *.csv files to "csv" folder
after importing they will be moved to "imported" folder
  
  
4. run script via 
php index.php 
