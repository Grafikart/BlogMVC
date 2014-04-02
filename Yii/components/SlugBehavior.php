<?php

/**
 * This behavior allows models to work with 
 *
 * $method ActiveRecordLayer getOwner() Returns behavior owner.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class SlugBehavior extends CActiveRecordBehavior
{
    /**
     * Creates slug from provided text.
     * 
     * @param string $text Text to be converted to slug.
     * @param int $maxLength Maximum length for slug.
     * @return string Slug.
     * @since 0.1.0
     */
    public function createSlug($text, $maxLength=50)
    {
        $slug = mb_strtolower(preg_replace(
            array('#(:?^\W+|\W+$)#u', '#\W+#u'),
            array('', '-'),
            $text
        ), 'UTF-8');
        return mb_substr($slug, 0, $maxLength, 'UTF-8');
    }
    /**
     * Finds unused slug
     * 
     * @todo Even though current application intented to be small, a slug race
     * is possible. Ensure you're using transactions where required.
     * @todo I believe that max slug could be fetched easily by itself.
     * 
     * @param string $slug Slug that requires unification.
     * @return string Uniqified slug.
     * @since 0.1.0
     */
    public function uniqifySlug($slug)
    {
        $token = 'behavior.slug.uniqify'.get_class($this->getOwner()).'Slug';
        $db = Yii::app()->db;
        Yii::beginProfile($token);
        if (!$this->slugExists($slug)) {
            return $slug;
        }
        $slugs = $db->createCommand()
                    ->select('slug')
                    ->from($this->getOwner()->tableName())
                    ->where('slug REGEXP :regexp', array(
                        ':regexp' => $slug.'-%d+'
                  ))->queryAll();
        $max = 0;
        $slugLength = strlen($slug);
        foreach ($slugs as $foundSlug) {
            $number = (int)substr($foundSlug['slug'], $slugLength + 1);
            if ($number > $max) {
                $max = $number;
            }
        }
        $uniqueSlug = $slug.'-'.($max + 1);
        Yii::endProfile($token);
        return $uniqueSlug;
    }
    /**
     * Checks slug existence.
     * 
     * @param string $slug Slug to be checked.
     * @return boolean True if exists, false otherwise.
     * @since 0.1.0
     */
    public function slugExists($slug)
    {
        $token = 'behavior.slug.exists'.get_class($this->getOwner()).'Slug';
        Yii::beginProfile($token);
        $db = Yii::app()->db;
        $exists = (bool) $db->createCommand()
                            ->select('slug')
                            ->from($this->getOwner()->tableName())
                            ->where('slug = :slug', array(':slug' => $slug))
                            ->queryScalar();
        Yii::endProfile($token);
        return $exists;
    }
    /**
     * Creates uniqified slug from provided text.
     *
     * @param string $text Base for slug generation.
     * @return string Generated slug.
     * @since 0.1.0
     */
    public function generateSlug($text)
    {
        $text = trim($text);
        if (strlen($text) === 0) {
            return '';
        }
        $slug = $this->createSlug($text);
        return $this->uniqifySlug($slug);
    }
}
