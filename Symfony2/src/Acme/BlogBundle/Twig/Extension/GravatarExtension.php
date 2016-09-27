<?php

namespace Acme\BlogBundle\Twig\Extension;

/**
 * Class GravatarExtension
 * @package Acme\BlogBundle\Twig\Extension
 */
class GravatarExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('gravatar', array($this, 'gravatarFilter')),
        );
    }

    /**
     * @param string $mail
     *
     * @return string
     */
    public function gravatarFilter($mail)
    {
        return '//1.gravatar.com/avatar/' . md5($mail) . '?s=100';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Acme_BlogBundle_Gravatar';
    }
}
