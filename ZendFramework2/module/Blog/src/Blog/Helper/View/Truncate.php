<?php
/**
 * Blog
 */
namespace Blog\Helper\View;

use Zend\View\Helper\AbstractHelper;
use Zend\Paginator;
use Zend\View\Exception;

/**
 * View Helper
 */
class Truncate extends AbstractHelper
{
    public function __invoke($text, $limit = 100)
    {
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
