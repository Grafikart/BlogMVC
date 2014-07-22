<?php

/**
 * This component aggregates random formatter and proxies their functionality.
 *
 * Clumsiest component ever.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class DataFormatter
{
    /**
     * List of formats supported by this formatter.
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $supportedFormats = array('xml', 'json', 'rss');
    /**
     * Escape mode for single quotes escaping.
     *
     * @type int
     * @since 0.1.0
     */
    const ESCAPE_SINGLE_QUOTES = 1;
    /**
     * Escape mode for double quotes escaping.
     *
     * @type int
     * @since 0.1.0
     */
    const ESCAPE_DOUBLE_QUOTES = 2;
    /**
     * Escape mode for all quotes escaping. Equals to
     * {@link ESCAPE_SINGLE_QUOTES} | {@link ESCAPE_DOUBLE_QUOTES}.
     *
     * @type int
     * @since 0.1.0
     */
    const ESCAPE_QUOTES = 3; //self::ESCAPE_DOUBLE_QUOTES | self::ESCAPE_SINGLE_QUOTES;
    /**
     * Cached CMarkdown instance.
     *
     * @type \CMarkdown
     * @since 0.1.0
     */
    protected static $markdownFormatter;
    /**
     * Cached ModelFormatter instance.
     *
     * @type \ModelFormatter
     * @since 0.1.0
     */
    protected static $modelFormatter;
    /**
     * Cached RssFormatter instance.
     *
     * @type \RssFormatter
     * @since 0.1.0
     */
    protected static $rssFormatter;
    /**
     * Checks if provided format is known and data may be safely formatted
     * using it.
     * 
     * @param string $format Format to be checked.
     *
     * @return boolean True if format is in supported formats list, false
     * otherwise.
     * @since 0.1.0
     */
    public function knownFormat($format)
    {
        return in_array($format, $this->supportedFormats, true);
    }

    /**
     * Yii required component method.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
    }

    /**
     * Formats data as string representation of PHP 5.3-compliant array.
     * 
     * @param array   $data            Data to be formatted,
     * @param boolean $preserveIndexes Whether to preserve or not numerical
     * array indexes.
     * @param int     $indent          Number of spaces,
     *
     * @return string
     * @since 0.1.0
     */
    public function renderArray(array $data, $preserveIndexes=false, $indent=0)
    {
        $q = '\'';
        $curIndent = str_repeat(' ', $indent);
        $nextIndent = str_repeat(' ', $indent + 4);
        $s = $curIndent.'array('.PHP_EOL;
        foreach ($data as $key => $item) {
            $s .= $nextIndent;
            if (is_string($item)) {
                $item = $q.$this->escape($item).$q;
            } else if (is_array($item)) {
                $item = $this->renderArray(
                    $item,
                    $preserveIndexes,
                    $indent + 4
                );
            } else if (is_object($item)) {
                $item = $this->renderArray(
                    get_object_vars($item),
                    $preserveIndexes,
                    $indent + 4
                );
            } else if (is_bool($item)) {
                $item = $item?'true':'false';
            }
            if (is_string($key)) {
                $key = $q.$key.$q;
            }
            if (!is_int($key) || $preserveIndexes) {
                $s .= $key.' => '.trim($item).','.PHP_EOL;
            } else {
                $s .= trim($item).','.PHP_EOL;
            }
        }
        $s .= $curIndent.')';
        return $s;
    }
    /**
     * Renders markdown-formatted text.
     * 
     * @param string $text Markdown text.
     *
     * @return string Rendered text.
     * @since 0.1.0
     */
    public function renderMarkdown($text)
    {
        return $this->getMarkdownFormatter()->transform($text);
    }

    /**
     * Retrieves reusable markdown formatter.
     *
     * @return \CMarkdown
     * @since 0.1.0
     */
    public function getMarkdownFormatter()
    {
        if (!isset(static::$markdownFormatter)) {
            static::$markdownFormatter = new \CMarkdown;
        }
        return static::$markdownFormatter;
    }

    /**
     * Retrieves RSS formatter.
     *
     * @return \RssFormatter
     * @since 0.1.0
     */
    public function getRssFormatter()
    {
        if (!isset(static::$rssFormatter)) {
            static::$rssFormatter = new \RssFormatter;
        }
        return static::$rssFormatter;
    }

    /**
     * Retrieves model formatter.
     *
     * @return ModelFormatter
     * @since 0.1.0
     */
    public function getModelFormatter()
    {
        if (!isset(static::$modelFormatter)) {
            static::$modelFormatter = new \ModelFormatter;
        }
        return static::$modelFormatter;
    }

    /**
     * Simple string escaper.
     *
     * @param string $text Text to be escaped.
     * @param int $mode One of self::ESCAPE_* constants.
     * @return string Escaped text.
     * @since 0.1.0
     */
    public function escape($text, $mode=self::ESCAPE_SINGLE_QUOTES)
    {
        $rules = array(
            'subs' => array('\\'),
            'repls' => array('\\\\'),
        );
        $text = str_replace('\\', '\\\\', $text);
        if ($mode & self::ESCAPE_SINGLE_QUOTES) {
            $rules['subs'][] = '\'';
            $rules['repls'][] = '\\\'';
        }
        if ($mode & self::ESCAPE_DOUBLE_QUOTES) {
            $rules['subs'][] = '"';
            $rules['repls'][] = '\\"';
        }
        return str_replace($rules['subs'], $rules['repls'], $text);
    }

    /**
     * Creates slug from provided text.
     *
     * @param string  $text     Text to slugify.
     * @param boolean $translit Whether to transliterate slug to ASCII or not.
     * This will completely erase russian characters, so probably it better to
     * be kept off.
     *
     * @return string Resulting slug.
     * @since 0.1.0
     */
    public function slugify($text, $translit=false)
    {
        $text = trim(mb_strtolower($text, 'UTF-8'));
        if ($translit) {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        }
        $rules = array(
            'pats' => array(
                '#^[^\w-]+|[^\w-]+$#u',
                '#\s+—\s+|\s+\-+\s+#',
                '#[^\w-]+#u'
            ),
            'reps' => array('', '---', '-'),
        );
        $slug = preg_replace($rules['pats'], $rules['reps'], $text);
        \Yii::trace('Generated slug ['.$slug.'] from text ['.$text.']');
        return $slug;
    }

    /**
     * Converts slug to text.
     *
     * @param string $slug       Slug to be processed.
     * @param bool   $capitalize Whether to capitalize or not every word in the
     * text.
     *
     * @return string Text.
     * @since 0.1.0
     */
    public static function deslugify($slug, $capitalize=false)
    {
        $rules = array(
            'pats' => array('#\-{3,}#u', '#\-+#u'),
            'reps' => array(' — ', ' '),
        );
        $text = preg_replace($rules['pats'], $rules['reps'], $slug);
        if ($capitalize) {
            $text = mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
        }
        \Yii::trace('Converted slug ['.$slug.'] to text ['.$text.']');
        return $text;
    }

    /**
     * Redormats datetime values. Currently supports only `interval` format
     * which outputs '... ago' text.
     *
     * @param string|\DateTime $date   Date to be converted.
     * @param string           $format Format that date should be converted to.
     *
     * @throws \BadMethodCallException Thrown in case of unknown format.
     *
     * @return string Formatted date.
     * @since 0.1.0
     */
    public static function formatDateTime($date, $format='timeAgo')
    {
        /** @type \DateFormatter $formatter */
        $formatter = \Yii::app()->dateFormatter;
        switch ($format) {
            case 'timeAgo':
                return $formatter->formatAsTimeAgo($date);
            case 'plain':
                return $formatter->formatDateTime($date);
            case 'dateOnly':
                return $formatter->formatDateTime($date, 'medium', null);
            case 'timeOnly':
                return $formatter->formatDateTime($date, null, 'medium');
            default:
                throw new \BadMethodCallException('Unknown format '.$format);
        }
    }

    /**
     * Creates textual representation of provided models using specified format.
     *
     * @param \CModel[] $models Array of models that should be converted.
     * @param string    $format Format models have to be converted to.
     *
     * @return string Resulting formatted document.
     * @since 0.1.0
     */
    public function formatModels(array $models, $format)
    {
        if (!$this->knownFormat($format)) {
            throw new \BadMethodCallException('Unknown format supplied');
        }
        if ($format === 'rss') {
            $formatter = $this->getRssFormatter();
            return $formatter->format($models);
        } else {
            $formatter = $this->getModelFormatter();
            return $formatter->format($models, $format);
        }
    }

    /**
     * Formats single model to provided format.
     *
     * @param \CModel $model  Model to be formatted.
     * @param string  $format
     *
     * @return string
     * @since 0.1.0
     */
    public function formatModel(\CModel $model, $format)
    {
        if (!$this->knownFormat($format)) {
            throw new \BadMethodCallException('Unknown format supplied');
        }
        if ($format === 'rss') {
            throw new \InvalidArgumentException(
                'RSS format isn\'t supported for posts'
            );
        } else {
            $formatter = $this->getModelFormatter();
            return $formatter->format($model, $format);
        }
    }
}
