<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:05
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingGooglePlus extends SharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'https://plus.google.com/share?url=' . $url;
    }

    protected function count($url)
    {
        $data = $this->getRawSharingData('http://share.yandex.ru/gpp.xml?url=' . $url, [
            'timeout' => 1,
        ]);
        $data = str_replace(['services.gplus.cb("', '");'], '', $data);

        return intval($data);
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-google-plus open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-google-plus"></i>&nbsp; Google+';
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
        $button .= '<i class="fa fa-google-plus fa-fw"></i> ' . trans('label.share_on') . ' Google+';
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
        $button .= trans('label.share_on') . ' Google+';
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