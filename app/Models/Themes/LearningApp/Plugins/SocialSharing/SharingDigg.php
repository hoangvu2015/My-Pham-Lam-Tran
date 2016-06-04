<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:06
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingDigg extends NoCountSharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'http://www.digg.com/submit?url=' . $url;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-digg open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-digg"></i>&nbsp; Digg';
        $button .= '</a>';
        return $button;
    }

    protected function listGroup($url, $enableCount, $subject, $content)
    {
        $button = '<a class="text-light open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-digg fa-fw"></i> ' . trans('label.share_on') . ' Digg';
        $button .= '</a>';
        return $button;
    }

    protected function listNormal($url, $enableCount, $subject, $content)
    {
        $button = '<a class="open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= trans('label.share_on') . ' Digg';
        $button .= '</a>';
        return $button;
    }
}