<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:04
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingFacebook extends SharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
    }

    protected function count($url)
    {
        $data = $this->getSharingData('http://graph.facebook.com/?id=' . $url, [
            'timeout' => 1,
        ]);
        if ($data !== false) {
            return isset($data['shares']) ? intval($data['shares']) : 0;
        }

        return 0;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-facebook open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-facebook"></i>&nbsp; Facebook';
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
        $button = '<a class="text-light open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-facebook fa-fw"></i> ' . trans('label.share_on') . ' Facebook';
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
        $button = '<a class="open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= trans('label.share_on') . ' Facebook';
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