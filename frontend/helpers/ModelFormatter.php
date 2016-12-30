<?php
namespace frontend\helpers;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Emaildomain;

class ModelFormatter
{
    /**
     * Format the value for html output with tel tags resolved
     * @param string $value
     * @return string The formatted value
     */
    public static function formatwithHtmlTelTags(Emaildomain $domain,$value) {
        $html  = nl2br(Html::encode($value));

        $html = preg_replace_callback(
            '/tel:([-0-9+ \/]*)/',
            function ($match) use($domain) {

              return '<a href="tel:'.$domain->normalizeTel($match[1]).'">'.$match[1].'</a>';
            },
            $html
        );

        $html = preg_replace_callback(
            '/tel-([a-z]*):([-0-9+ \/]*)/',
            function ($match) use($domain) {

              return '<a href="tel:'.$domain->normalizeTel($match[2]).'">'.$match[1].':'.$match[2].'</a>';
            },
            $html
        );
        return $html;
    }
}
