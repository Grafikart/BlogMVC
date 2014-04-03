<?php

/**
 * Adds support for automatic `created` field setting.
 *
 * @method CActiveRecord|ActiveRecordLayer getOwner() Returns owner model.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class DatetimeCreatedBehavior extends CActiveRecordBehavior
{
    /**
     * Automatically sets `created` field to `NOW()` SQL function result if
     * owner is new model.
     *
     * @param CModelEvent $event Event to keep strict standards happy about
     * method signature.
     * @since 0.1.0
     */
    public function beforeSave($event)
    {
        if ($this->getOwner()->getIsNewRecord()) {
            $this->getOwner()->created = new CDbExpression('NOW()');
        }
    }
} 