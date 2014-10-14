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
    protected $cachedAttrLabels;
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
        if (!isset($this->cachedAttrLabels)) {
            $this->cachedAttrLabels = array();
            foreach ($this->getAttributeLabels() as $attribute => $l18nKey) {
                $this->cachedAttrLabels[$attribute] = \Yii::t(
                    'forms-labels',
                    $l18nKey
                );
            }
        }
        return $this->cachedAttrLabels;
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
    public static function model($className = null)
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
    public function resetAttributes(array $attributes = null)
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

    /**
     * Returns array of public attributes that may be shown in API call.
     *
     * @return array Attributes.
     * @since 0.1.0
     */
    public function getPublicAttributes()
    {
        return array_merge(
            $this->getAttributes(),
            $this->getRelatedAttributes()
        );
    }

    /**
     * Returns all loaded related attributes.
     *
     * @return array
     * @since 0.1.0
     */
    public function getRelatedAttributes()
    {
        $attrs = array();
        $relations = $this->relations();
        foreach (array_keys($relations) as $key) {
            if ($this->hasRelated($key)) {
                $related = $this->getRelated($key);
                if (is_array($related)) {
                    $attrs[$key] = array();
                    foreach ($related as $model) {
                        /** @type \CModel $model */
                        if (method_exists($model, 'getPublicAttributes')) {
                            $attrs[$key][] = $model->getPublicAttributes();
                        } elseif ($related instanceof \CModel) {
                            $attrs[$key][] = $model->getAttributes();
                        } else {
                            $attrs[$key][] = $model;
                        }
                    }
                } else {
                    /** @type \CModel $related */
                    if (method_exists($related, 'getPublicAttributes')) {
                        $attrs[$key] = $related->getPublicAttributes();
                    } elseif ($related instanceof \CModel) {
                        $attrs[$key] = $related->getAttributes();
                    } else {
                        $attrs[$key] = $related;
                    }
                }
            }
        }
        return $attrs;
    }
}
