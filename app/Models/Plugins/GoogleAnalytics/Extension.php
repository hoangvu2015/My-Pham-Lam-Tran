<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-19
 * Time: 09:48
 */

namespace Antoree\Models\Plugins\GoogleAnalytics;

use Antoree\Models\Themes\Extension as BaseExtension;

class Extension extends BaseExtension
{
    const EXTENSION_NAME = 'google_analytics';
    const EXTENSION_DISPLAY_NAME = 'Google Analytics';
    const EXTENSION_DESCRIPTION = 'Set up Google Analytics';
    const EXTENSION_EDITABLE = true;

    public $web_property_id;
    public $async_script;

    public function gaScript()
    {
        return '<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

ga(\'create\', \'' . $this->web_property_id . '\', \'auto\');
ga(\'send\', \'pageview\');
</script>
<!-- End Google Analytics -->';
    }

    public function asyncGaScript()
    {
        return '<!-- Google Analytics -->
<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga(\'create\', \'' . $this->web_property_id . '\', \'auto\');
ga(\'send\', \'pageview\');
</script>
<script async src=\'//www.google-analytics.com/analytics.js\'></script>
<!-- End Google Analytics -->';
    }

    public function register()
    {
        enqueue_theme_footer($this->async_script ? $this->asyncGaScript() : $this->gaScript(), $this::EXTENSION_NAME);
    }

    protected function __init()
    {
        parent::__init();

        $this->web_property_id = empty($this->data['web_property_id']) ? 'UA-0000000-0' : $this->data['web_property_id'];
        $this->async_script = !empty($this->data['async_script']) && $this->data['async_script'] == 1;
    }

    protected function __initAdminViewParams()
    {
        $this->setViewParams([
            'web_property_id' => $this->web_property_id,
            'async_script' => $this->async_script,
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'web_property_id',
            'async_script'
        ]);
    }

    public function validationRules()
    {
        $validationRules = parent::validationRules();
        return array_merge($validationRules, [
            'web_property_id' => 'required',
        ]);
    }
}