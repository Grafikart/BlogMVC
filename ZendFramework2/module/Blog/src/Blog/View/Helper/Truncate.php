<?php
/**
 * Blog
 */
namespace Blog\View\Helper;

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

        $truncAtSpace = true;
        $limit     -= strlen('');
        $stringLength = strlen($text);

        if ($stringLength <= $limit) {
            return $text;
        }

        if ($truncAtSpace && ($spacePosition = strrpos($text, ' ', $limit - $stringLength))) {
            $limit = $spacePosition;
        }

        return substr_replace($text, '', $limit) . '...';
    }
}
