<?php

/**
 * This exception is designed to be thrown when end user attempts to access a
 * specific page on non-pageable resource (RSS, for example).
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class EHttpRestrictedPagingException extends \EHttpException
{
    /**
     * Simple wrapper around parent {@link parent::__construct()} method.
     *
     * @param int      $messageKey Translation key for message to be displayed.
     * @param string[] $tArgs      Additional translation args for message.
     *
     * @since 0.1.0
     */
    public function __construct($messageKey, $tArgs=array())
    {
        parent::__construct(400, $messageKey, 0, $tArgs);
    }
}
 