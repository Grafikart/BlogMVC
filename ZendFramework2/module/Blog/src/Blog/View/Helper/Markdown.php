<?php
/**
 * Blog
 */

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Michelf\Markdown as Md;

/**
 * View Helper
 */
class Markdown extends AbstractHelper
{
    public function __invoke($text)
    {
        return Md::defaultTransform($text);
    }
}
