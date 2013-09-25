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
class Gravatar extends AbstractHelper
{
    public function __invoke($mail, $size = 100)
    {
        return 'http://1.gravatar.com/avatar/' . md5($mail) . '?s=' . $size;
    }

}
