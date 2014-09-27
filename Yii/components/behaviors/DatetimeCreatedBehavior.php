<?php

/**
 * Adds support for automatic `created` field setting.
 *
 * @method CActiveRecord|ActiveRecordLayer getOwner() Returns owner model.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class DatetimeCreatedBehavior extends \CActiveRecordBehavior
{
    /**
     * Automatically sets `created` field to `NOW()` SQL function result if
     * owner is new model.
     *
     * @param CModelEvent $event Passed event instance.
     *
     * @return void
     * @since 0.1.0
     */
    public function beforeSave($event)
    {
        if ($this->getOwner()->getIsNewRecord()) {
            $dt = new \DateTime();
            $this->getOwner()->created = $dt->format(\DateTime::ISO8601);
        }
    }
}
