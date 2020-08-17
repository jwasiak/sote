<?php

/**
 * Subclass for performing query and update operations on the 'app_category_image_tag' table.
 *
 * 
 *
 * @package plugins.appImageTagPlugin.lib.model
 */ 
class appCategoryImageTagPeer extends BaseappCategoryImageTagPeer
{
    protected static $tagPool = array();

    public static function retrieveByCategory(Category $category)
    {
        if (!isset(self::$tagPool[$category->getId()]) && !array_key_exists($category->getId(), self::$tagPool))
        {
            $tag = self::retrieveByPK($category->getId());

            if (null !== $tag)
            {
                $tag->setCategory($category);
                $tag->resetModified();
            }
            
            self::$tagPool[$category->getId()] = $tag;
        }

        return self::$tagPool[$category->getId()];
    }
}
