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
}
 