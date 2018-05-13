<?php


namespace src\Core\Utitlity;


class UrlHelper
{
    /**
     * @param $url
     * @param $queryParams
     * @return string
     */
    public static function getCreatedUrl($url, $queryParams)
    {
        $queryParts = [];
        foreach ($queryParams as $index => $value) {
            $queryParts[] = $index . '=' . $value; 
        }

        $queryString = implode('&', $queryParts);
        
        $url .= '?' . $queryString;

        return $url;
    }
}