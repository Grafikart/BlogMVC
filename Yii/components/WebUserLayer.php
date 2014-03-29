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
     * URL or array(route) which points to login form.
     * 
     * @var string|array
     * @since 0.1.0
     */
    public $loginUrl = array('admin/login');
    /**
     * Key for storing user flash messages.
     * 
     * @var string
     * @since 0.1.0
     */
    public $messageKey = 'user.messages';
    /**
     * Prefix for data keys for flash storage.
     * 
     * @var string
     * @since 0.1.0
     */
    public $dataKeyPrefix = 'data.';
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
        $messages = $this->getFlash($this->messageKey, array());
        while(sizeof($messages) >= 10) {
            array_shift($messages);
        }
        $messages[] = Yii::t('user-messages', $message, $data);
        $this->setFlash($this->messageKey, $messages);
    }
    /**
     * Fetches all previously stored user messages.
     * 
     * @return string[] List of messages.
     * @since 0.1.0
     */
    public function getMessages($delete=true)
    {
        return $this->getFlash($this->messageKey, array(), $delete);
    }
    /**
     * Checks if user has any flash messages.
     * 
     * @return boolean True if there are any messages saved, false otherwise.
     * @since 0.1.0
     */
    public function hasMessages()
    {
        return $this->hasFlash($this->messageKey);
    }
    /**
     * Saves arbitrary user data. Designed to store model data between PRG
     * requests.
     * 
     * @param string $alias Name for the saved data.
     * @param mixed $data Data to be saved.
     * @return void
     * @since 0.1.0
     */
    public function saveData($alias, $data)
    {
        $this->setFlash($this->dataKeyPrefix.$alias, $data);
    }
    /**
     * Getter for saved data, simple wrapper around {@link getFlash()}.
     * 
     * @param string $alias Alias under which data should be stored.
     * @param boolean $delete Whether to delete or not data from flash storage
     * after retrieval.
     * @return mixed Stored data or null on failure.
     * @since 0.1.0
     */
    public function getData($alias, $delete=true)
    {
        return $this->getFlash($this->dataKeyPrefix.$alias, null, $delete);
    }
    /**
     * Tells if there is stored data under provided key.
     * 
     * @param string $alias Key for data to be saved under.
     * @return boolean True if such key exists in data flash storage, false
     * otherwise.
     * @since 0.1.0
     */
    public function hasData($alias)
    {
        return $this->hasFlash($this->dataKeyPrefix.$alias);
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
