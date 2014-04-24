<?php
/**
 * An ActiveRecord interlayer which provides some nice-and-easy interface to
 * cache localized attribute labels and perform complex operations in single
 * method call.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
abstract class ActiveRecordLayer extends \CActiveRecord
{
    /**
     * Cache for attribute labels to prevent running l10n processing every
     * time {@link attributeLabels()} is called.
     * 
     * @var string[] List of attribute labels.
     * @since 0.1.0
     */
    protected $cachedAttributeLabels;
    /**
     * A wrapper around {@link getAttributeLabels()} (original
     * {@link CModel::attributeLabels()} substitute). Allows caching attribute
     * labels to prevent running l10n processing every call.
     *
     * @return string[] List of attribute labels.
     * @since 0.1.0
     */
    public function attributeLabels()
    {
        if (!isset($this->cachedAttributeLabels)) {
            $this->cachedAttributeLabels = array();
            foreach ($this->getAttributeLabels() as $attribute => $l18nKey) {
                $this->cachedAttributeLabels[$attribute] = \Yii::t(
                    'forms-labels',
                    $l18nKey
                );
            }
        }
        return $this->cachedAttributeLabels;
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
     *
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
     * Returns array of default values for attributes in :attribute_name =>
     * :default_value form.
     *
     * @return array List of default attribute values.
     * @since 0.1.0
     */
    public function attributeDefaults()
    {
        return array();
    }

    /**
     * Resets all attributes with default values from
     * {@link attributeDefaults()} method. Those attributes which were not
     * listed in {@link attributeDefaults()} will be set to null.
     *
     * @param array $attributes Optional array of attributes for instant
     * setting.
     *
     * @return void
     * @since 0.1.0
     */
    public function resetAttributes(array $attributes=null)
    {
        $defaults = $this->attributeDefaults();
        $safeAttributes = $this->getSafeAttributeNames();
        if ($attributes !== null) {
            $defaults = array_merge($defaults, $attributes);
        }
        foreach (array_keys($defaults) as $attribute) {
            if (!in_array($attribute, $safeAttributes, true)) {
                unset($defaults[$attribute]);
            }
        }
        foreach ($safeAttributes as $attribute) {
            if (!isset($defaults[$attribute])) {
                $defaults[$attribute] = null;
            }
        }
        $this->setAttributes($attributes);
    }
    /**
     * Sets provided attributes and instatly tries to save.
     * 
     * @param array $attributes List of attributes to be saved.
     *
     * @return boolean Return value of {@link save()}
     * @since 0.1.0
     */
    public function setAndSave(array $attributes)
    {
        $this->resetAttributes($attributes);
        return $this->save();
    }
    /**
     * Sets provided attributes, validates model and returns validation
     * result.
     * 
     * @param array $attributes List of attributes to be set.
     *
     * @return boolean True on successful validation, false otherwise.
     * @since 0.1.0
     */
    public function setAndValidate(array $attributes)
    {
        $this->resetAttributes($attributes);
        return $this->validate();
    }
}
