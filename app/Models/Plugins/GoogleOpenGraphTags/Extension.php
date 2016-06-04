<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-19
 * Time: 15:32
 */

namespace Antoree\Models\Plugins\GoogleOpenGraphTags;

use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Themes\Extension as BaseExtension;
use Illuminate\Support\Facades\Request;

class Extension extends BaseExtension
{
    const EXTENSION_NAME = 'google_open_graph_tags';
    const EXTENSION_DISPLAY_NAME = 'Google Open Graph Tags';
    const EXTENSION_DESCRIPTION = 'Set up Google Open Graph Tags';

    protected $ogTitle; // site name

    protected $ogImage; // site image

    protected $ogDescription; // site description


    public function __construct()
    {
        parent::__construct();

        $this->ogTitle = appName();
        $this->ogDescription = appDescription();
        $this->ogImage = appLogo();
    }

    public function register()
    {
        enqueue_theme_header(new CallableObject([$this, 'render']));
    }

    public function render()
    {
        $data = [
            'og:title' => $this->ogTitle,
            'og:description' => $this->ogDescription,
            'og:image' => $this->ogImage,
        ];

        $data = content_filter('open_graph_tags_before_render', $data);

        return $this->parseCollection($this->convertToGoogle($data));
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
            case 'image':
                if ($is_array) {
                    return $this->parseOgImages($item);
                }
                break;
            default:
                break;
        }
        return PHP_EOL . t_metaItemProp($property, $item);
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
        return PHP_EOL . t_metaItemProp('image', $image);
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
            $output .= PHP_EOL . t_metaItemProp($property, $content);
        }
        return $output;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function convertToGoogle($data)
    {
        //Because default content filter is only for Facebook Open Graph
        //Convert from FB to Google
        if(isset($data['fb:app_id'])) {
            unset($data['fb:app_id']);
        }

        $data['name'] = $data['og:title'];
        unset($data['og:title']);

        $data['description'] = $data['og:description'];
        unset($data['og:description']);

        $data['image'] = $data['og:image'];
        unset($data['og:image']);

        return $data;
    }
}