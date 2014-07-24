<?php

/**
 * Additional interlayer for all widgets that helps to keep indentation in
 * consistency and keep HTML output readable.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class WidgetLayer extends \CWidget
{
    /**
     * Constant for tabs indentation.
     *
     * @var int
     * @since 0.1.0
     */
    const INDENT_TABS = 1;
    /**
     * Constant for space indentation.
     *
     * @var int
     * @since 0.1.0
     */
    const INDENT_SPACES = 2;
    /**
     * Current indentation style.
     *
     * @var int Value of one of <b>self::INDENT_*</b> constants.
     * @since 0.1.0
     */
    public $indentStyle = self::INDENT_SPACES;
    /**
     *
     *
     * @var int Indentation char amount.
     * @since 0.1.0
     */
    public $currentIndent = 0;

    /**
     * Opens HTML tag.
     *
     * @param string   $tag    Tag to be echoed.
     * @param array    $opts   Tag HTML options.
     * @param null|int $indent Indentation char amount. Will be set
     * automatically if specified as null (default value).
     *
     * @return void
     * @since 0.1.0
     */
    public function openTag($tag, $opts=array(), $indent=null)
    {
        $this->e(\CHtml::openTag($tag, $opts), $indent);
        if ($indent === null) {
            if ($this->indentStyle === self::INDENT_TABS) {
                $this->currentIndent++;
            } else {
                $this->currentIndent += 4;
            }
        }
    }

    /**
     * Closes HTML tag.
     *
     * @param string   $tag    Tag to be echoed.
     * @param null|int $indent Indentation char amount. Will be set
     * automatically if specified as null (default value).
     *
     * @return void
     * @since 0.1.0
     */
    public function closeTag($tag, $indent=null)
    {
        if ($indent === null) {
            if ($this->indentStyle === self::INDENT_TABS) {
                $this->currentIndent--;
            } else {
                $this->currentIndent -= 4;
            }
        }
        $this->e(\CHtml::closeTag($tag), $indent);
    }

    /**
     * Outputs HTML tag.
     *
     * @param string   $tag      HTML tag to be echoed.
     * @param array    $opts     List of HTML options.
     * @param bool     $content  HTML tag content.
     * @param bool     $closeTag Whether tag should be closed (true) or if it is
     * self-closing.
     * @param null|int $indent   Indentation char amount. Will be set
     * automatically if specified as null (default value).
     *
     * @return void
     * @since 0.1.0
     */
    public function tag(
        $tag,
        $opts=array(),
        $content=false,
        $closeTag=true,
        $indent=null
    ) {
        if ($indent === null) {
            $indent = $this->currentIndent;
        }
        $this->e(\CHtml::tag($tag, $opts, $content, $closeTag), $indent);
    }

    /**
     * Echoes indented output.
     *
     * @param string   $text   Text to be echoed.
     * @param null|int $indent Indentation char amount. Will be set
     * automatically if specified as null (default value).
     *
     * @return void
     * @since 0.1.0
     */
    public function e($text, $indent=null)
    {
        if ($indent === null) {
            $indent = $this->currentIndent;
        }
        if ($indent > 0) {
            if ($this->indentStyle === self::INDENT_TABS) {
                echo str_repeat("\t", $indent);
            } else if ($this->indentStyle === self::INDENT_SPACES) {
                echo str_repeat(' ', $indent);
            }
        }
        echo $text;
        echo "\n";
    }
}
