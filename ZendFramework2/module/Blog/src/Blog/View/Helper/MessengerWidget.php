<?php

namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\FlashMessenger;
use Zend\View\Model\ViewModel;

class MessengerWidget extends AbstractHelper
{
    /** @var \Zend\View\Helper\FlashMessenger $flashMessenger */
    private $flashMessenger;

    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $view = new ViewModel(array(
            'success' => $this->flashMessenger->getSuccessMessages(),
            'errors' => $this->flashMessenger->getErrorMessages(),
            'infos' => $this->flashMessenger->getInfoMessages(),
        ));
        $view->setTemplate('widget/messenger');

        return $this->getView()->render($view);
    }
}
