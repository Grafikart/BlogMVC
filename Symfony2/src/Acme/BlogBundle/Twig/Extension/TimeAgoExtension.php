<?php

namespace Acme\BlogBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Made from this gist : https://gist.github.com/henrikbjorn/1432795
 */
class TimeAgoExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Constructor
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time_ago', array($this, 'timeAgoFilter')),
        );
    }

    /**
     * @param \DateTime $date
     *
     * @return string
     */
    public function timeAgoFilter(\DateTime $date)
    {
        $diff = date_create()->diff($date);
        $seconds = $diff->days * 86400 + $diff->h * 3600 + $diff->i * 60 + $diff->s;

        $format = $this->translator->transChoice(join('|', array(
            '[0,60[Just now',
            '|[60,120[%i minute ago',
            '|[120,3600[%i minutes ago',
            '|[3600,7200[%h hour ago',
            '|[3600,86400[%h hours ago',
            '|[86400,172800[%h day ago',
            '|[86400,31556926[%d days ago',
            '|[31556926,63113852[%y year ago',
            '|[63113852,+Inf[%d years ago',
        )), $seconds);

        return $diff->format($format);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Acme_BlogBundle_TimeAgo';
    }
}
