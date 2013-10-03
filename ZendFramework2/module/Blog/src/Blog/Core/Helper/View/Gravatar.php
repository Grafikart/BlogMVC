<?php
/**
 * Blog
 */
namespace Blog\Core\Helper\View;

use Zend\View\Helper\AbstractHelper;

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
