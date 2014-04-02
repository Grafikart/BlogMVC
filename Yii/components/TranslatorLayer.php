<?php

/**
 * A simple interface that allows calling Yii::t() nonstatically, thus
 * allowing using it in twig templates. Normally you wouldn't see it in
 * templates because i've used it once or twice. Since Yii uses lazyload, it
 * shouldn't generate any useless overhead.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class TranslatorLayer
{
    /**
     * Dummy initializer.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init() {}
    /**
     * Translates provided <var>$message</var> using <b>templates</b>
     * category.
     * 
     * @param string $message Message itself. BlogMVC\Yii translates
     * everything and uses tokens instead of real messages.
     * @param string[] $params Additional params to replace {item}-formatted
     * placeholders.
     * @return string Translated text.
     * @since 0.1.0
     */
    public function t(
        $message,
        $params=array()
    ) {
        return Yii::t('templates', $message, $params);
    }
}
