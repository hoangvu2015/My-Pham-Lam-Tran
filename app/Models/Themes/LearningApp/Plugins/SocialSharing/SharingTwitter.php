<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:05
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingTwitter extends SharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'http://twitter.com/share?url=' . $url . '&amp;text=' . $subject;
    }

    protected function count($url)
    {
        $data = $this->getSharingData('http://cdn.api.twitter.com/1/urls/count.json?url=' . $url, [
            'timeout' => 1,
        ]);
        if ($data !== false) {
            return isset($data['count']) ? intval($data['count']) : 0;
        }

        return 0;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-twitter open-sharing" href="#" data-href="' . $this->getSharingUrl($url, $subject) . '">';
        $button .= '<i class="fa fa-twitter"></i>&nbsp; Twitter';
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
        $button .= '<i class="fa fa-twitter fa-fw"></i> ' . trans('label.share_on') . ' Twitter';
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
        $button .= trans('label.share_on') . ' Twitter';
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