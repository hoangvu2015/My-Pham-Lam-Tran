<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-09
 * Time: 14:30
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialSharing;

use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;
use Antoree\Models\Themes\LmsThemeFacade;
use Illuminate\Support\Facades\Request;

class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'social_sharing';
    const WIDGET_DISPLAY_NAME = 'Social Sharing';
    const THEME_NAME = Theme::NAME;

    private $currentUrl;
    private $enableCount;
    private $style;
    private $allowedStyles = [
        SharingButton::STYLE_INLINE,
        SharingButton::STYLE_LIST_GROUP,
        SharingButton::STYLE_LIST_NORMAL
    ];
    private $shareButtons = [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'google' => 'Google+',
        'digg' => 'Digg',
        'linkedin' => 'LinkedIn',
        'reddit' => 'Reddit',
        'pinterest' => 'Pinterest',
        'stumbleupon' => 'StumbleUpon',
        'email' => 'Email',
        'documentPrint' => 'Print',
        'tumblr' => 'Tumblr',
        'vk' => 'Vkontakte',
    ];
    private $shareButtonClasses = [
        'facebook' => SharingFacebook::class,
        'twitter' => SharingTwitter::class,
        'google' => SharingGooglePlus::class,
        'digg' => SharingDigg::class,
        'linkedin' => SharingLinkedIn::class,
        'reddit' => SharingReddit::class,
        'pinterest' => SharingPinterest::class,
        'stumbleupon' => SharingStumbleUpon::class,
        'email' => SharingEmail::class,
        'documentPrint' => SharingDocumentPrint::class,
        'tumblr' => SharingTumblr::class,
        'vk' => SharingVkontakte::class,
    ];
    private $maxButtons = 4;
    private $enableShareButtons = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->currentUrl = urlencode(Request::fullUrl());
    }

    public function shareSubject()
    {
        static $shareSubject;
        if (empty($shareSubject)) {
            $shareSubject = urlencode(html_entity_decode(theme_title()));
        }
        return $shareSubject;
    }

    public function shareContent()
    {
        static $shareContent;
        if (empty($shareContent)) {
            $shareContent = urlencode(html_entity_decode(theme_description()));
        }
        return $shareContent;
    }

    protected function __init()
    {
        parent::__init();

        $sharing = $this->getProperty('sharing');
        $this->enableShareButtons = empty($sharing) ? [] : $sharing;
        $maxButtons = $this->getProperty('max_buttons');
        $this->maxButtons = empty($maxButtons) ? 4 : intval($maxButtons);
        $this->enableCount = $this->getProperty('enable_count') == 1;
        $style = $this->getProperty('style');
        $this->style = !in_array($style, $this->allowedStyles) ? 'inline' : $style;
    }

    public function register()
    {
        $script = '<script>
                ' . cdataOpen() . '
                function enableOpenSharing($openSharing) {
                    $openSharing.off(\'click\').on(\'click\',function(e){
                        e.preventDefault();
                        var dataHref = jQuery(this).attr(\'data-href\');
                        if(dataHref == \'#print\') {
                            window.print();
                        }
                        else {
                            window.open(dataHref, \'' . trans('social_sharing.share_this') . '\', \'width=600,height=480\');
                        }
                        return false;
                    });
                }
                jQuery(document).ready(function () {
                    enableOpenSharing(jQuery(\'.widget-social-sharing a.open-sharing\'));
                });
                ' . cdataClose() . '
            </script>';
        enqueue_theme_footer($script, $this::WIDGET_NAME);

        $hiddenButtons = $this->getHidingButtons();
        if (count($hiddenButtons) > 0) {
            $content = $this->getTemplateRender([
                'html_id' => $this->getHtmlId() . '-more',
                'name' => $this->name,
                'buttons' => $hiddenButtons,
                'has_hidden_buttons' => false,
            ], false, LmsThemeFacade::widget($this::WIDGET_NAME, 'render_' . $this->style));
            $content = str_replace(PHP_EOL, '', str_replace("'", "\'", $content));

            $extraScript = '<script>
                ' . cdataOpen() . '
                jQuery(document).ready(function () {
                    var widgetShareMore = jQuery(\'#' . $this->getHtmlId() . ' .share-more\');
                    widgetShareMore.popover({
                        container: \'body\',
                        placement: \'auto top\',
                        html: true,
                        trigger: \'focus\',
                        content: \'' . $content . '\'
                    }).off(\'click\').on(\'click\', function (e) {
                        e.preventDefault();
                        widgetShareMore.popover(\'toggle\');
                        return false;
                    }).on(\'shown.bs.popover\', function(){
                        console.log(\'enable\');
                        enableOpenSharing(jQuery(\'#' . $this->getHtmlId() . '-more a.open-sharing\'));
                    });
                });
                ' . cdataClose() . '
            </script>';
            enqueue_theme_footer($extraScript, $this::WIDGET_NAME . '_' . $this->getId());
        }
    }

    public function getMaxButtons()
    {
        return $this->maxButtons;
    }

    public function getEnableCount()
    {
        return $this->enableCount;
    }

    public function getAllowedStyles()
    {
        return $this->allowedStyles;
    }

    public function getStyle()
    {
        return $this->style;
    }

    public function getSharingButtonsForAdmin()
    {
        $buttons = [];
        foreach ($this->enableShareButtons as $button) {
            if (isset($this->shareButtons[$button])) {
                $buttons[$button] = [];
                $buttons[$button]['name'] = $this->shareButtons[$button];
                $buttons[$button]['active'] = true;
            }
        }
        foreach ($this->shareButtons as $key => $name) {
            if (!in_array($key, $this->enableShareButtons)) {
                $buttons[$key] = [];
                $buttons[$key]['name'] = $name;
                $buttons[$key]['active'] = false;
            }
        }

        return $buttons;
    }

    public function getHidingButtons()
    {
        $buttons = [];
        foreach (array_splice($this->enableShareButtons, $this->maxButtons) as $buttonName) {
            $buttonClass = $this->shareButtonClasses[$buttonName];
            $buttonInstance = new $buttonClass();
            $buttons[] = $buttonInstance->render($this->style,
                false, $this->currentUrl, $this->shareSubject(), $this->shareContent());
        }
        return $buttons;
    }

    public function getSharingButtons()
    {
        $buttons = [];
        $i = 0;
        foreach ($this->enableShareButtons as $buttonName) {
            if ($i == $this->maxButtons) break;

            $buttonClass = $this->shareButtonClasses[$buttonName];
            $buttonInstance = new $buttonClass();
            $buttons[] = $buttonInstance->render($this->style,
                $this->enableCount, $this->currentUrl, $this->shareSubject(), $this->shareContent());

            ++$i;
        }
        return $buttons;
    }

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'buttons' => $buttons = $this->getSharingButtons(),
            'has_hidden_buttons' => count($this->enableShareButtons) > $this->maxButtons,
        ], false, LmsThemeFacade::widget($this::WIDGET_NAME, 'render_' . $this->style));
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'sharing', 'max_buttons', 'enable_count', 'style'
        ]);
    }

    public function validationRules()
    {
        return array_merge(parent::validationRules(), [
            'sharing' => 'required|array|in:' . implode(',', array_keys($this->shareButtons)),
            'max_buttons' => 'required|integer|min:1',
            'enable_count' => 'sometimes|in:1',
            'style' => 'required|in:' . implode(',', $this->allowedStyles),
        ]);
    }
}