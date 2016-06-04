<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-24
 * Time: 15:25
 */

namespace Antoree\Models\Plugins\SiteInformation;

use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Themes\Extension as BaseExtension;
use Antoree\Models\Themes\LmsThemeFacade;

class Extension extends BaseExtension
{
    const EXTENSION_NAME = 'site_information';
    const EXTENSION_DISPLAY_NAME = 'Site Information';
    const EXTENSION_DESCRIPTION = 'Set up Information about the Website';
    const EXTENSION_EDITABLE = true;
    const EXTENSION_TRANSLATABLE = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        $title = $this->getProperty('title');
        if (!empty($title)) {
            LmsThemeFacade::titleRoot($title);
        }
        $description = $this->getProperty('description');
        if (!empty($description)) {
            LmsThemeFacade::description($description);
        }
        $author = $this->getProperty('author');
        if (!empty($author)) {
            LmsThemeFacade::author($author);
        }
        $keywords = explode(PHP_EOL, $this->getProperty('keywords'));
        if (count($keywords) > 0 && !empty($keywords[0])) {
            LmsThemeFacade::keywords($keywords);
        }

        $google_webmaster_tools = $this->getProperty('google_webmaster_tools');
        if (!empty($google_webmaster_tools)) {
            enqueue_theme_header(t_metaName('google-site-verification', $google_webmaster_tools), 'google_webmaster_tools');
        }
        $bing_webmaster_center = $this->getProperty('bing_webmaster_center');
        if (!empty($bing_webmaster_center)) {
            enqueue_theme_header(t_metaName('msvalidate.01', $bing_webmaster_center), 'bing_webmaster_center');
        }
        $pinterest_site_verification = $this->getProperty('pinterest_site_verification');
        if (!empty($pinterest_site_verification)) {
            enqueue_theme_header(t_metaName('p:domain_verify', $pinterest_site_verification), 'pinterest_site_verification');
        }
        $yandex_webmaster = $this->getProperty('yandex_webmaster');
        if (!empty($yandex_webmaster)) {
            enqueue_theme_header(t_metaName('yandex-verification', $yandex_webmaster), 'yandex_webmaster');
        }
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'google_webmaster_tools',
            'bing_webmaster_center',
            'pinterest_site_verification',
            'yandex_webmaster',
        ]);
    }

    public function localizedFields()
    {
        return array_merge(parent::localizedFields(), [
            'title', 'description', 'author', 'keywords'
        ]);
    }

    public function localizedValidationRules()
    {
        return array_merge(parent::localizedValidationRules(), [
            'title' => 'sometimes|max:255',
            'author' => 'sometimes|max:255',
        ]);
    }
}