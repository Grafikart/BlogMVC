<?php

/**
 * Another BlogMVC application-Yii interlayer which allows automatic
 * translating of additional HTTP error messages.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class EHttpException extends \CHttpException
{
    /**
     * Constructor with translation support.
     * 
     * @param int      $status  HTTP error status.
     * @param string   $message Optional error message. Will be translated if
     * provided.
     * @param int      $code    Error code.
     * @param string[] $tArgs   Additional args for translation.
     *
     * @since 0.1.0
     */
    public function __construct($status, $message=null, $tArgs=array())
    {
        if ($message !== null) {
            $message = \Yii::t('http-errors', $message);
        }
        parent::__construct($status, $message, 0);
    }
}
