<?php

/**
 * This behavior allows models to create unique slugs.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class SlugBehavior extends CActiveRecordBehavior
{
    /**
     * Retrieves set of restricted slugs.
     *
     * @return array
     * @since 0.1.0
     */
    public function getRestrictedSlugs()
    {
        if (method_exists($this->owner, 'getRestrictedSlugs')) {
            return $this->owner->getRestrictedSlugs();
        }
        return array(
            'admin',
            'category',
            'categories',
            'author',
            'authors',
            'login',
            'logout',
            'xml',
            'rss',
            'json',
            'html',
            'new',
            'save',
        );
    }
    /**
     * Creates slug from provided text.
     * 
     * @param string $text      Text to be converted to slug.
     * @param int    $maxLength Maximum length for slug.
     *
     * @return string Slug.
     * @since 0.1.0
     */
    public function createSlug($text, $maxLength = 50)
    {
        $slug = preg_replace(
            array('#(:?^\W+|\W+$)#u', '#\W+#u'),
            array('', '-'),
            $text
        );
        $slug = mb_strtolower($slug, 'UTF-8');
        return mb_substr($slug, 0, $maxLength, 'UTF-8');
    }
    /**
     * Finds unused slug
     *
     * @param string $slug Slug that requires unification.
     *
     * @return string Uniqified slug.
     * @since 0.1.0
     */
    public function uniqifySlug($slug)
    {
        \Yii::trace('Uniqifying slug ['.$slug.']');
        if (!is_string($slug) || strlen($slug) === 0) {
            $error = \Yii::t(
                'validation-errors',
                'slugBehavior.emptySlug'
            );
            $this->owner->addError('slug', $error);
            return false;
        } elseif (in_array($slug, $this->getRestrictedSlugs(), true)) {
            $error = \Yii::t(
                'validation-errors',
                'slugBehavior.restrictedSlug',
                array('{slug}' => $slug,)
            );
            $this->owner->addError('slug', $error);
            return false;
        }
        $token = 'behavior.slug.uniqify'.get_class($this->owner).'Slug';
        \Yii::beginProfile($token);
        /** @var CDbConnection $db */
        $db = \Yii::app()->db;
        if (!$this->slugExists($slug, $this->owner->getPrimaryKey())) {
            return $slug;
        }
        \Yii::trace('Searching for all slugs matching ['.$slug.']');
        $slugs = $db->createCommand()
            ->select('slug')
            ->from($this->owner->tableName())
            ->where(
                'slug LIKE :pattern',
                array(':pattern' => $slug.'-%',)
            )->queryAll();
        \Yii::trace('Found '.sizeof($slugs).' matching slugs');
        $max = 0;
        $slugLength = strlen($slug);
        foreach ($slugs as $foundSlug) {
            $number = (int)substr($foundSlug['slug'], $slugLength + 1);
            if ($number > $max) {
                $max = $number;
            }
        }
        $uniqueSlug = $slug.'-'.($max + 1);
        \Yii::endProfile($token);
        return $uniqueSlug;
    }
    /**
     * Checks slug existence.
     * 
     * @param string $slug Slug to be checked.
     * @param int    $id   Current entity ID.
     *
     * @return boolean True if exists, false otherwise.
     * @since 0.1.0
     */
    public function slugExists($slug, $id = 0)
    {
        $token = 'behavior.slug.exists'.get_class($this->owner).'Slug';
        \Yii::beginProfile($token);
        $id = (int)$id;
        /** @var CDbConnection $db */
        $db = \Yii::app()->db;
        $exists = (bool) $db->createCommand()
            ->select('slug')
            ->from($this->owner->tableName())
            ->where(
                'slug = :slug AND id != :id',
                array(':slug' => $slug, ':id' => $id,)
            )->queryScalar();
        if ($exists) {
            \Yii::trace('Found slug ['.$slug.']');
        } else {
            \Yii::trace('Slug ['.$slug.'] hasn\'t been found.');
        }
        \Yii::endProfile($token);
        return $exists;
    }

    /**
     * Validates slug.
     *
     * @param string $attribute Slug attribute name.
     *
     * @return void
     * @since 0.1.0
     */
    public function validateSlug($attribute)
    {
        /** @var \ActiveRecordLayer $owner */
        $owner = $this->owner;
        if ($this->slugExists($owner->$attribute, $owner->getPrimaryKey())) {
            $error = \Yii::t(
                'validation-errors',
                'slugBehavior.slugExists',
                array('{slug}' => $this->owner->$attribute,)
            );
            $this->owner->addError($attribute, $error);
        }
    }

    /**
     * Before save callback.
     *
     * @param \CModelEvent $event beforeValidate event.
     *
     * @return bool
     * @since 0.1.0
     */
    public function beforeSave($event)
    {
        if (isset($this->owner->slug)) {
            $this->owner->slug = $this->uniqifySlug($this->owner->slug);
            if (!$this->owner->slug) {
                $event->isValid = false;
            }
        }
        return true;
    }
}
