<?php

/**
 * Description of DataFormatter
 *
 * @todo Decide finally if properties should static or not.
 * 
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class DataFormatter
{
    /**
     * List of formats supported by this formatter.
     * 
     * @var string[]
     * @since 0.1.0
     */
    protected static $supportedFormats = array('xml', 'json', 'rss');
    protected $markdownFormatter;
    /**
     * Checks if provided format is known and data may be safely formatted
     * using it.
     * 
     * @param type $format
     * @return boolean True if format is in supported formats list, false
     * otherwise.
     * @since 0.1.0
     */
    public static function knownFormat($format) {
        return in_array($format, self::$supportedFormats, true);
    }
    public function init(){}
    public function formatArray(array $data, $format)
    {
        if ($format === 'rss') {
            return $this->createPostsRss($data);
        }
        if ($format === 'php') {
            return $this->formatPhpArray($data);
        }
        $temp = array();
        foreach ($data as $model) {
            $temp[] = $model->getAttributes();
        }
        
    }
    public function createPostsRss(array $posts)
    {
        
            if (!($data[0] instanceof Post)) {
                throw new \BadMethodCallException();
            }
    }
    /**
     * 
     * @todo refactor it
     * 
     * @param array $data
     * @param type $indent
     * @return string
     */
    public function formatPhpArray(array $data, $indent=4, $preserveIndexes=false)
    {
        $q = '\'';
        $s = 'array('.PHP_EOL;
        foreach ($data as $key => $item) {
            $s .= str_repeat(' ', $indent);
            if (is_string($item)) {
                $item = $q.$item.$q;
            } else if (is_array($item)) {
                $item = $this->formatPhpArray($item, $indent + 4);
            } else if(is_bool($item)) {
                $item = ($item)?'true':'false';
            }
            if (is_string($key)) {
                $key = $q.$key.$q;
            }
            if (!is_int($key) || $preserveIndexes) {
                $s .= $key.' => '.$item.','.PHP_EOL;
            } else {
                $s .= $item.','.PHP_EOL;
            }
        }
        $s .= str_repeat(' ', $indent - 4).')';
        return $s;
    }
    public function formatModel(CModel $model, $format)
    {
        $attrs = $model->attributes();
    }
    /**
     * 
     * @todo
     * 
     * @param type $text
     * @param type $format
     * @return type
     * @throws NotImplementedException
     */
    public function formatText($text, $format='markdown')
    {
        if ($format !== 'markdown') {
            throw new NotImplementedException();
        }
        return $this->getMarkdownFormatter()->transform($text);
    }
    public function getMarkdownFormatter()
    {
        if (!isset($this->markdownFormatter)) {
            $this->markdownFormatter = new CMarkdown;
        }
        return $this->markdownFormatter;
    }
    public function generateSlug($text)
    {
        $text = trim($text);
        $slug = mb_strtolower(preg_replace('[\s\r\n\]+', '', $text), 'UTF-8');
        Yii::trace('Generated slug '.$slug.' from '.$text);
        return $slug;
    }
    const ESCAPE_SINGLE_QUOTES = 1;
    public function escape($text, $mode=self::ESCAPE_SINGLE_QUOTES)
    {
        $text = str_replace('\\', '\\\\', $text);
        $text = str_replace('\'', '\\\'', $text);
        return $text;
    }
}
