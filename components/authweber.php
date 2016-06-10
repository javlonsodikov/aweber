<?php

/**
 * Created by PhpStorm.
 * Author: Javlon Sodikov
 * Date time: 10.06.2016 20:03
 */
class AuthWeber
{
    const uagent = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0";

    public static function getAuthKey($url = "https://auth.aweber.com/1.0/oauth/authorize_app/1b14fabd", $login = "gray675", $password = "Haleygray675")
    {
        $content = static::loginUrl($url, $login, $password);
        return static::extractData($content, "/\<textarea onclick=\"this\.select\(\)\; return false\;\">(.*)\<\/textarea\>/i");
    }

    private static function loginUrl($url = "https://auth.aweber.com/1.0/oauth/authorize_app/1b14fabd", $login = "gray675", $password = "Haleygray675")
    {
        /*
                oauth_username	gray675
        oauth_password	Haleygray675
        oauth_submit	Allow Access
        oauth_token
        display	page
        oauth_callback	oob*/

        $fields_string = "oauth_username=" . $login . "&oauth_password=" . $password . "&oauth_submit=Allow+Access&oauth_token=&display=page&oauth_callback=oob";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, static::uagent);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        //curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        //curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . "/cookie.txt");
        //curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . "/cookie.txt");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        $content = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $content;
    }

    public static function extractData($html, $pattern)
    {
        preg_match_all($pattern, $html, $data);
        return $data[1];
    }
}