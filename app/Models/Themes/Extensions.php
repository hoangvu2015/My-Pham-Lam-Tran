<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-16
 * Time: 11:38
 */

namespace Antoree\Models\Themes;

use Antoree\Models\Helpers\AppOptionHelper;
use Antoree\Models\Plugins\Example\ContentShorten;
use Antoree\Models\Plugins\GoogleAnalytics\Extension as GoogleAnalytics;
use Antoree\Models\Plugins\AnalyticServices\Extension as AnalyticServices;
use Antoree\Models\Plugins\OpenGraphTags\Extension as OpenGraphTags;
use Antoree\Models\Plugins\TwitterOpenGraphTags\Extension as TwitterOpenGraphTags;
use Antoree\Models\Plugins\GoogleOpenGraphTags\Extension as GoogleOpenGraphTags;
use Antoree\Models\Plugins\OwnerInformation\Extension as OwnerInformation;
use Antoree\Models\Plugins\SiteInformation\Extension as SiteInformation;
use Antoree\Models\Plugins\FacebookIntegration\Extension as FacebookIntegration;
use Antoree\Models\Plugins\SocialIntegration\Extension as SocialIntegration;

class Extensions
{
    public function register()
    {
        $extensions = $this->activated();
        foreach ($extensions as $extension) {
            $extensionClass = $this->extensionClass($extension);
            if (!empty($extensionClass) && class_exists($extensionClass)) {
                $extension = new $extensionClass();
                $extension->register();
            }
        }
    }

    public function all()
    {
        return array_merge([
            ContentShorten::EXTENSION_NAME => ContentShorten::class,
            GoogleAnalytics::EXTENSION_NAME => GoogleAnalytics::class,
            AnalyticServices::EXTENSION_NAME => AnalyticServices::class,
            OpenGraphTags::EXTENSION_NAME => OpenGraphTags::class,
            TwitterOpenGraphTags::EXTENSION_NAME => TwitterOpenGraphTags::class,
            GoogleOpenGraphTags::EXTENSION_NAME => GoogleOpenGraphTags::class,
            OwnerInformation::EXTENSION_NAME => OwnerInformation::class,
            SiteInformation::EXTENSION_NAME => SiteInformation::class,
            FacebookIntegration::EXTENSION_NAME => FacebookIntegration::class,
            SocialIntegration::EXTENSION_NAME => SocialIntegration::class,
        ], LmsThemeFacade::extensions());
    }

    public function extensionClass($name)
    {
        static $extensions;
        if (empty($extensions)) {
            $extensions = $this->all();
        }
        return empty($extensions[$name]) ? null : $extensions[$name];
    }

    public function staticExtensions()
    {
        return [
            OpenGraphTags::EXTENSION_NAME,
            TwitterOpenGraphTags::EXTENSION_NAME,
            GoogleOpenGraphTags::EXTENSION_NAME,
            OwnerInformation::EXTENSION_NAME,
            SiteInformation::EXTENSION_NAME,
        ];
    }

    public function isStatic($extension)
    {
        static $extensions;
        if (empty($extensions)) {
            $extensions = $this->staticExtensions();
        }
        return in_array($extension, $extensions);
    }

    public function activated()
    {
        static $extensions;
        if (empty($extensions)) {
            $extensions = array_unique(array_merge((array)AppOptionHelper::get('activated_extensions', []), $this->staticExtensions()));
        }
        return $extensions;
    }

    public function isActivated($extension)
    {
        return in_array($extension, $this->activated());
    }
}