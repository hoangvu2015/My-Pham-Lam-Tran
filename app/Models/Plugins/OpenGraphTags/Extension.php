<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-19
 * Time: 15:32
 */

namespace Antoree\Models\Plugins\OpenGraphTags;

use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Themes\Extension as BaseExtension;
use Illuminate\Support\Facades\Request;

class OgImage
{
    public $url;
    public $secureUrl;
    public $type; // mime type
    public $width;
    public $height;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function render()
    {
        $output = PHP_EOL . t_metaProperty('og:image', $this->url);
        if (!empty($this->secureUrl)) {
            $output .= PHP_EOL . t_metaProperty('og:image:secure_url', $this->secureUrl);
        }
        if (!empty($this->type)) {
            $output .= PHP_EOL . t_metaProperty('og:image:type', $this->type);
        }
        if (!empty($this->width)) {
            $output .= PHP_EOL . t_metaProperty('og:image:width', $this->width);
        }
        if (!empty($this->height)) {
            $output .= PHP_EOL . t_metaProperty('og:image:height', $this->height);
        }
        return $output;
    }
}

class OgVideo
{
    public $url;
    public $secureUrl;
    public $type; // mime type
    public $width;
    public $height;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function render()
    {
        $output = t_metaProperty('og:video', $this->url);
        if (!empty($this->secureUrl)) {
            $output .= t_metaProperty('og:video:secure_url', $this->secureUrl);
        }
        if (!empty($this->type)) {
            $output .= t_metaProperty('og:video:type', $this->type);
        }
        if (!empty($this->width)) {
            $output .= t_metaProperty('og:video:width', $this->width);
        }
        if (!empty($this->height)) {
            $output .= t_metaProperty('og:video:height', $this->height);
        }
        return $output;
    }
}

class OgAudio
{
    public $url;
    public $secureUrl;
    public $type; // mime type

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function render()
    {
        $output = t_metaProperty('og:audio', $this->url);
        if (!empty($this->secureUrl)) {
            $output .= t_metaProperty('og:audio:secure_url', $this->secureUrl);
        }
        if (!empty($this->type)) {
            $output .= t_metaProperty('og:audio:type', $this->type);
        }
        return $output;
    }
}

class Extension extends BaseExtension
{
    const EXTENSION_NAME = 'open_graph_tags';
    const EXTENSION_DISPLAY_NAME = 'Open Graph Tags';
    const EXTENSION_DESCRIPTION = 'Set up Open Graph Tags';
//    const EXTENSION_EDITABLE = true;

    protected $ogTitle; // site name

    /**
     * website, music, video, article, book, profile
     *
     * @var
     */
    protected $ogType; // website

    protected $ogUrl; // current URL

    protected $ogImage; // site image

    protected $ogAudio;

    protected $ogVideo;

    protected $ogSiteName; // site name

    protected $ogDescription; // site description

    /**
     * a, an, the, '', auto
     *
     * @var
     */
    protected $ogDeterminer;

    protected $ogLocale; // current locale

    protected $ogLocaleAlternate; // supported locales

    public function __construct()
    {
        parent::__construct();

        $this->ogType = 'website';
        $this->ogUrl = Request::url();
        $this->ogTitle = appName();
        $this->ogDescription = appDescription();
        $this->ogImage = appLogo();
        $this->ogSiteName = appName();
        $this->ogLocale = fullCurrentLocale();
        $this->ogLocaleAlternate = allFullSupportedLocaleCodes();
    }

    public function register()
    {
        enqueue_theme_header(new CallableObject([$this, 'render']));
    }

    public function render()
    {
//        dd($a);
        $data = [
            'og:type' => $this->ogType,
            'og:title' => $this->ogTitle,
            'og:description' => $this->ogDescription,
            'og:url' => $this->ogUrl,
            'og:site_name' => $this->ogSiteName,
            'og:image' => $this->ogImage,
            'og:locale' => $this->ogLocale,
            'og:locale:alternate' => $this->ogLocaleAlternate,
        ];

        $data = content_filter('open_graph_tags_before_render', $data);

        return $this->parseCollection($data);
    }

    /**
     * @param array $data
     * @return string
     */
    protected function parseCollection(array $data)
    {
        $output = '<!-- ' . $this::EXTENSION_DISPLAY_NAME . ' -->';
        foreach ($data as $property => $item) {
            $output .= $this->parseItem($property, $item);
        }
        return $output;
    }

    /**
     * @param string $property
     * @param string|array $item
     * @return string
     */
    protected function parseItem($property, $item)
    {
        $is_array = is_array($item);
        switch ($property) {
            case 'og:image':
                if ($is_array) {
                    return $this->parseOgImages($item);
                }
                break;
            case 'og:locale:alternate':
                if ($is_array) {
                    return $this->parseContents($property, $item);
                }
                break;
            default:
                break;
        }
        return PHP_EOL . t_metaProperty($property, $item);
    }

    #region Parse Image
    protected function parseOgImages(array $images)
    {
        $output = '';
        foreach ($images as $image) {
            $output .= $this->parseOgImage($image);
        }
        return $output;
    }

    /**
     * @param string|OgImage $image
     * @return string
     */
    protected function parseOgImage($image)
    {
        return is_a($image, OgImage::class) ? $image->render() : PHP_EOL . t_metaProperty('og:image', $image);
    }

    #endregion

    /**
     * @param string $property
     * @param array $contents
     * @return string
     */
    protected function parseContents($property, array $contents)
    {
        $output = '';
        foreach ($contents as $content) {
            $output .= PHP_EOL . t_metaProperty($property, $content);
        }
        return $output;
    }
}