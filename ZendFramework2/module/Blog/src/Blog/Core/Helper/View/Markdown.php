<?php
/**
 * Blog
 */
namespace Blog\Core\Helper\View;

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
