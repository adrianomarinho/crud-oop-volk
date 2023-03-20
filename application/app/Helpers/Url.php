<?php

namespace App\Helpers;

class Url
{
    /**
     * Redirect to chosen url.
     *
     * @param  string  $url      the url to redirect to
     * @param  boolean $fullpath if true use only url in redirect instead of using env('CONFIG_DIR')
     */


    public static function getBaseUrl()
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        // Append the host(domain name, ip) to the URL.
        $url.= $_SERVER['HTTP_HOST'];

        return $url;

    }

    public static function redirect($url = null)
    {
//        header('Location: ' . self::getBaseUrl() .$url);
//        exit;
        echo '<script language="javascript">window.location.href ="'.self::getBaseUrl() .$url.'"</script>';

    }
}