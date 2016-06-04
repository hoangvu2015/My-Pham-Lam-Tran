<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:06
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingPinterest extends SharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'http://pinterest.com/pin/create/bookmarklet/?is_video=false&amp;url=' . $url . '&amp;description=' . $subject;
    }

    protected function count($url)
    {
        $data = $this->getSharingData('http://api.pinterest.com/v1/urls/count.json?callback=&url=' . $url, [
            'timeout' => 1,
        ]);
        if ($data !== false) {
            return isset($data['count']) ? intval($data['count']) : 0;
        }

        return 0;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-pinterest open-sharing" href="#" data-href="' . $this->getSharingUrl($url, $subject) . '">';
        $button .= '<i class="fa fa-pinterest"></i>&nbsp; Pinterest';
        if ($enableCount) {
            $count = $this->count($url);
            if ($count > 0) {
                $button .= ' &nbsp;<span class="badge">' . $count . '</span>';
            }
        }
        $button .= '</a>';
        return $button;
    }

    protected function listGroup($url, $enableCount, $subject, $content)
    {
        $button = '<a class="text-light open-sharing" href="#" data-href="' . $this->getSharingUrl($url, $subject) . '">';
        $button .= '<i class="fa fa-pinterest fa-fw"></i> ' . trans('label.share_on') . ' Pinterest';
        $button .= '</a>';
        if ($enableCount) {
            $count = $this->count($url);
            if ($count > 0) {
                $button .= '<span class="badge pull-right">' . $count . '</span>';
            }
        }
        return $button;
    }

    protected function listNormal($url, $enableCount, $subject, $content)
    {
        $button = '<a class="open-sharing" href="#" data-href="' . $this->getSharingUrl($url, $subject) . '">';
        $button .= trans('label.share_on') . ' Pinterest';
        $button .= '</a>';
        if ($enableCount) {
            $count = $this->count($url);
            if ($count > 0) {
                $button .= ' <span class="badge">' . $count . '</span>';
            }
        }
        return $button;
    }
}