<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 11:08
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;


class SharingDocumentPrint extends NoCountSharingButton
{
    protected function getSharingUrl($url, $subject = '', $content = '')
    {
        // TODO: Implement getSharingUrl() method.
    }

    protected function inline($url, $enableCount, $subject, $content)
    {
        $button = '<a role="button" class="btn btn-sharing btn-print open-sharing" href="#" data-href="#print">';
        $button .= '<i class="fa fa-print"></i>&nbsp; Print';
        $button .= '</a>';
        return $button;
    }

    protected function listGroup($url, $enableCount, $subject, $content)
    {
        $button = '<a class="text-light open-sharing" href="#" data-href="#print">';
        $button .= '<i class="fa fa-print fa-fw"></i> Print';
        $button .= '</a>';
        return $button;
    }

    protected function listNormal($url, $enableCount, $subject, $content)
    {
        $button = '<a class="open-sharing" href="#" data-href="#print">';
        $button .= 'Print';
        $button .= '</a>';
        return $button;
    }
}