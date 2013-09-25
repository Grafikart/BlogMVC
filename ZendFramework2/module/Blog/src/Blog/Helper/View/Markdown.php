<?php
/**
 * Blog
 */
namespace Blog\Helper\View;

use Zend\View\Helper\AbstractHelper;
use Zend\Paginator;
use Zend\View\Exception;
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
