<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:03
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;

use GuzzleHttp\Client as SocialClient;
use GuzzleHttp\Exception\RequestException;

abstract class SharingButton
{
    const STYLE_INLINE = 'inline';
    const STYLE_LIST_GROUP = 'list_group';
    const STYLE_LIST_NORMAL = 'list_normal';

    protected $socialClient;

    public function __construct()
    {
        $this->socialClient = new SocialClient();
    }

    protected function extractJson($source)
    {
        if (empty($source)) return false;
        $start = strpos($source, '{');
        $end = strrpos($source, '}', $start);
        return json_decode(substr($source, $start, $end - $start + 1), true);
    }

    protected function getSharingData($url, array $options = [])
    {
        try {
            $response = $this->socialClient->get($url, $options);
            if ($response->getStatusCode() == 200) {
                return $this->extractJson($response->getBody());
            }
        } catch (RequestException $ex) {

        }

        return false;
    }

    protected function getRawSharingData($url, array $options = [])
    {
        try {
            $response = $this->socialClient->get($url, $options);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            }
        } catch (RequestException $ex) {

        }

        return '';
    }

    protected function postSharingData($url, array $options = [])
    {
        try {
            $response = $this->socialClient->post($url, $options);
            if ($response->getStatusCode() == 200) {
                return $this->extractJson($response->getBody());
            }
        } catch (RequestException $ex) {

        }

        return false;
    }

    public function render($style, $enableCount, $url, $subject, $content)
    {
        switch ($style) {
            case self::STYLE_INLINE :
                return $this->inline($url, $enableCount, $subject, $content);
            case self::STYLE_LIST_GROUP:
                return $this->listGroup($url, $enableCount, $subject, $content);
            case self::STYLE_LIST_NORMAL:
                return $this->listNormal($url, $enableCount, $subject, $content);
            default:
                return '';
        }
    }

    protected abstract function getSharingUrl($url, $subject = '', $content = '');

    protected abstract function count($url);

    protected abstract function inline($url, $enableCount, $subject, $content);

    protected abstract function listGroup($url, $enableCount, $subject, $content);

    protected abstract function listNormal($url, $enableCount, $subject, $content);
}

abstract class NoCountSharingButton extends SharingButton
{
    protected function count($url)
    {
        return 0;
    }
}