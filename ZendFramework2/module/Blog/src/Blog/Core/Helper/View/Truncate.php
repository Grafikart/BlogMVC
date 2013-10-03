<?php
/**
 * Blog
 */
namespace Blog\Core\Helper\View;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class Truncate extends AbstractHelper
{
    public function __invoke($text, $limit = 100, $stripTags = true)
    {
        if ($stripTags) {
            $text = strip_tags($text);
        }

        $trunc_at_space = true;
        $limit     -= strlen('');
        $string_length  = strlen($text);

        if ($string_length <= $limit){
            return $text;
        }

        if ( $trunc_at_space && ($space_position = strrpos($text, ' ', $limit - $string_length)) ) {
            $limit = $space_position;
        }

        return substr_replace($text, '', $limit) . '...';
    }
}
