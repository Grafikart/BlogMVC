<?php

/**
 * An additional layer for injecting dev-friendly interface.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class ActiveRecordLayer extends CActiveRecord
{
    protected $_cachedAttributeLabels;
}
