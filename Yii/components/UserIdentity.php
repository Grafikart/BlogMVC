<?php

/**
 * Simple authrntication class. Validates user login and password.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class UserIdentity extends CUserIdentity
{
    /**
     * ID of the current ser's database record.
     * 
     * @var int
     * @since 0.1.0
     */
    protected $id;
    /**
     * Tries to authenticate user using user-provided username and password.
     * 
     * @return bool True on success, false otherwise.
     * @since 0.1.0
     */
    public function authenticate()
    {
        $record = User::model()->findByAttributes(
            array('username' => $this->username)
        );
        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($record->password !== sha1($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->id = (int)$record->id;
            $this->setState('username', $this->username);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode === self::ERROR_NONE;
    }
    /**
     * Returns current user ID.
     * 
     * @return int Database ID for current user.
     * @since 0.1.0
     */
    public function getId() {
        return $this->id;
    }
}
