<?php

/**
 * Simple config editor that will replace selected keys in config.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class ConfigEditor extends \CComponent
{
    /**
     * Pattern that helps finding required line. Please note that if searched
     * entry is a multidimensional array, it would be better to read
     * necronomicon loudly than save result of this pattern.
     *
     * @type string
     * @since 0.1.0
     */
    protected $pattern
        = "~'%s'\s*=>\s*(?:'.*?(?<!\\\\)'|array\(.*\)|\[.*\]|true|false|null|\d+)~uis";

    /**
     *
     *
     * @param string $config
     * @param array $data
     *
     * @return string
     * @since 0.1.0
     */
    public function rewriteConfig($config, array $data)
    {
        foreach ($data as $key => $value) {
            $value = $this->escapeValue($value);
            $pattern = sprintf($this->pattern, $key);
            $replacement = "'$key' => $value";
            $config = preg_replace($pattern, $replacement, $config);
        }
        return $config;
    }

    /**
     * Escapes value so it can be safely written in config.
     *
     * @param mixed $value Value to be escaped.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function escapeValue($value)
    {
        if (is_numeric($value)) {
            return $value;
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif ($value === null) {
            return 'null';
        } elseif (is_string($value)) {
            return "'".str_replace("'", "\\'", $value)."'";
        } else {
            throw new \InvalidArgumentException('Unsupported type');
        }
    }
}
