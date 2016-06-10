<?php

class CreateSubscriber
{
    private $accessToken = null;
    private $consumerSecret = null;
    private $application;
    private $debug;

    //private $credentials;

    function __construct($authorization_code)
    {

//        $this->consumerKey = 'Ak3mqfhCbKcJwXkgU743XBG8';
//        $this->consumerSecret = 'bnLZNnztCfpMwtCUVhPPIHiVArhXmwtpqnJkJp7P';
//        $this->application = new AWeberAPI($this->consumerKey, $this->consumerSecret);
//        $credentials_file = __DIR__ . "/credentials1.php";
//        if (file_exists($credentials_file)) {
//            $this->credentials = unserialize(file_get_contents($credentials_file));
//        }
//        if (!$this->credentials['accessToken']) {
//            list($requestToken, $tokenSecret) = $this->application->getRequestToken('oob');
//            echo "Go to this url in your browser: {$this->application->getAuthorizeUrl()}\n";
//            echo 'Type code here: ';
//            $code = trim(fgets(STDIN));
//            $this->application->user->requestToken = $requestToken;
//            $this->application->user->tokenSecret = $tokenSecret;
//            $this->application->user->verifier = $code;
//            list($accessToken, $accessSecret) = $this->application->getAccessToken();
//            $this->credentials['accessToken'] = $accessToken;
//            $this->credentials['accessSecret'] = $accessSecret;
//            file_put_contents($credentials_file, serialize($this->credentials));
//        } else {
//            $accessToken = $this->credentials['accessToken'];
//            $accessSecret = $this->credentials['accessSecret'];
//        }
        $auth = AWeberAPI::getDataFromAweberID($authorization_code);
        list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->accessToken = $accessKey;
        $this->accessSecret = $accessSecret;
        $this->application = new AWeberAPI($this->consumerKey, $this->consumerSecret);
        $this->account = $this->application->getAccount($this->accessToken, $this->accessSecret);
    }

    function setDebug($debug)
    {
        $this->debug = $debug;
    }

    function addSubscriber($subscriber, $list)
    {
        global $debug;
        # get your aweber account
        $ret = true;
        try {
            # get your list

            $listUrl = "/accounts/{$this->account->id}/lists/{$list->id}";
            $list = $this->account->loadFromUrl($listUrl);
            // print_r($list);

            # create your subscriber
            $newSubscriber = $list->subscribers->create($subscriber);
        } catch (Exception $exc) {
            if ($this->debug){} echo " - " . $subscriber['email'] . " " . $exc->getMessage() . PHP_EOL;
            $ret = false;
        }
        return $ret;
    }

    function findList($listName)
    {
        $foundLists = $this->account->lists->find(array('name' => $listName));
        return $foundLists[0];
    }

    function findSubscriber($email)
    {
        try {
            $foundSubscribers = $this->account->findSubscribers(array('email' => $email));
            return $foundSubscribers[0];
        } catch (Exception $exc) {
            print $exc;
        }
    }

}
