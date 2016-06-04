<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:07
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingEmail extends NoCountSharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'mailto:?subject=' . str_replace('&', '%26', $subject) . '&amp;body=' . str_replace('&', '%26', $content) . '%20' . $url;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-envelope" href="' . $this->getSharingUrl($url, $subject, $content) . '">';
        $button .= '<i class="fa fa-envelope"></i>&nbsp; Email';
        $button .= '</a>';
        return $button;
    }

    protected function listGroup($url, $enableCount, $subject, $content)
    {
        $button = '<a class="text-light" href="' . $this->getSharingUrl($url, $subject, $content) . '">';
        $button .= '<i class="fa fa-envelope fa-fw"></i> Email';
        $button .= '</a>';
        return $button;
    }

    protected function listNormal($url, $enableCount, $subject, $content)
    {
        $button = '<a href="' . $this->getSharingUrl($url, $subject, $content) . '">';
        $button .= 'Email';
        $button .= '</a>';
        return $button;
    }
}