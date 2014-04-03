<?php

/**
 * Another BlogMVC application - Yii interlayer which allows automatic
 * translating of additional HTTP error messages.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class HttpException extends CHttpException
{
    /**
     * Constructor with translation support.
     * 
     * @param int $status HTTP error status.
     * @param string $message Optional error message. Will be translated if
     * provided.
     * @param int $code Error code.
     * @since 0.1.0
     */
    public function __construct($status, $message=null, $code=0) {
        if ($message !== null) {
            $message = Yii::t('http-errors', $message);
        }
        parent::__construct($status, $message, $code);
    }
}
