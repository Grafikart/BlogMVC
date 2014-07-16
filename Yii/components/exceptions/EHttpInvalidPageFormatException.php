<?php
/**
 * This exception is thrown when bad page format is supplied.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class EHttpInvalidPageFormatException extends \EHttpException
{
    /**
     * Wraps parent constructor defining initial values.
     *
     * @param int      $status  HTTP status code.
     * @param string   $message Message translation key.
     * @param int      $code    I dunno!
     * @param string[] $tArgs   Array of additional translation arguments.
     *
     * @since 0.1.0
     */
    public function __construct(
        $status = 400,
        $message = 'badRequest.invalidPageFormat',
        $code = 0,
        $tArgs = array()
    ) {
        parent::__construct($status, $message, $code, $tArgs);
    }
}
 