<?php

/**
 * Just a thin interlayer with message-sending interface.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class WebUserLayer extends CWebUser
{
    /**
     * Puts new message into user's flash-based mailbox. <var>$message</var>
     * stands for internationalization message alias, while optional
     * <var>$data</var> array may hold arbitrary bits to format it.
     * 
     * @param string $message Message alias in i18n system.
     * @param array $data Arbitrary data to format message.
     * @return void
     * @since 0.1.0
     */
    public function sendMessage($message, $data=array())
    {
        $messages = $this->getFlash('user.messages', array());
        while(sizeof($message) >= 10) {
            array_shift($messages);
        }
        $messages[] = Yii::t('user.messages', $message, $data);
        $this->setFlash('user.messages', $messages);
    }
    /**
     * Fetches all previously stored user messages.
     * 
     * @return string[] List of messages.
     * @since 0.1.0
     */
    public function getMessages()
    {
        return $this->getFlash('user.messages', array());
    }
    /**
     * Getter for saved username.
     * 
     * @return string
     * @since 0.1.0
     */
    public function getUsername()
    {
        return $this->getState('username');
    }
}
