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
abstract class ActiveRecordLayer extends CActiveRecord
{
    /**
     * Cache for attribute labels to prevent running l10n processing every
     * time {@link attributeLabels()} is called.
     * 
     * @var string[] List of attribute labels.
     * @since 0.1.0
     */
    protected $_cachedAttributeLabels;
    /**
     * A wrapper around {@link getAttributeLabels()} (original
     * {@link CModel::attributeLabels()} substitute). Allows caching attribute
     * labels to prevent running l10n processing every call.
     * 
     * @since 0.1.0
     */
    public function attributeLabels() {
        if (!isset($this->_cachedAttributeLabels)) {
            $this->_cachedAttributeLabels = $this->getAttributeLabels();
        }
        return $this->_cachedAttributeLabels;
    }
    /**
     * Returns localized attribute labels for caching.
     * 
     * @return string[] Localized attribute labels.
     * @since 0.1.0
     */
    abstract protected function getAttributeLabels();
    /**
     * Standard Yii model getter with late static bindings support. PHP 5.2.x
     * support drops right here.
     * 
     * @param string $className Name of the class.
     * @return self Instance of current model.
     * @since 0.1.0
     */
    public static function model($className=null)
    {
        if ($className === null) {
            $className = get_called_class();
        }
        return parent::model($className);
    }
    /**
     * Sets provided attributes and instatly tries to save.
     * 
     * @param array List of attributes to be saved.
     * @return type
     * @since 0.1.0
     */
    public function setAndSave(array $attributes) {
        $this->setAttributes($attributes);
        return $this->save();
    }
    /**
     * Shared method to get total amount of records. Data is cached for one
     * hour.
     * 
     * @return int
     * @since 0.1.0
     */
    public function total()
    {
        $cacheKey = $this->tableName().'.amount.total';
        $data = Yii::app()->cache->get($cacheKey);
        if ($data === false) {
            $data = (int)Yii::app()->db->createCommand()
                            ->select('COUNT(id)')
                            ->from($this->tableName())
                            ->queryScalar();
            Yii::app()->cache->set($cacheKey, $data, 3600);
        }
        return $data;
    }
}
