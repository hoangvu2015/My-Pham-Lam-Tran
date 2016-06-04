<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:08
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingVkontakte extends NoCountSharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        return 'http://vkontakte.ru/share.php?url=' . $url;
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-vk open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-vk"></i>&nbsp; Vkontakte';
        $button .= '</a>';
        return $button;
    }

    protected function listGroup($url, $enableCount, $subject, $content)
    {
        $button = '<a class="text-light open-sharing" href="#" data-href="' . $this->getSharingUrl($url) . '">';
        $button .= '<i class="fa fa-vk fa-fw"></i> ' . trans('label.share_on') . ' Vkontakte';
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
        $button .= trans('label.share_on') . ' Vkontakte';
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