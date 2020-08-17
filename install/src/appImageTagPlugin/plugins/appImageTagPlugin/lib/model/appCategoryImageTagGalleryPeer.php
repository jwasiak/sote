<?php

/**
 * Subclass for performing query and update operations on the 'app_category_image_tag_gallery' table.
 *
 * 
 *
 * @package plugins.appImageTagPlugin.lib.model
 */ 
class appCategoryImageTagGalleryPeer extends BaseappCategoryImageTagGalleryPeer
{
    protected static $tagPool = array();

    protected static $galleryPool = array();

    public static function getImagePath($category_id, $image, $system = false)
    {
        $path = self::getImageDir($category_id).'/'.$image;

        if ($system)
        {
            return sfConfig::get('sf_web_dir').$path;
        }

        return $path;
    }

    public static function getImageDir($category_id) 
    {
        return '/uploads/collections/'.$category_id;
    }

    public static function doSelectByCategory(Category $category)
    {
        if (!isset(self::$galleryPool[$category->getId()]) && !array_key_exists($category->getId(), self::$galleryPool))
        {
            $c = new Criteria();
            $c->addSelectColumn(self::ID);
            $c->addSelectColumn(self::IMAGE);
            $c->addSelectColumn(self::OPT_DESCRIPTION);
            $c->addSelectColumn(appCategoryImageTagGalleryI18nPeer::DESCRIPTION);
            $c->addSelectColumn(self::OPT_URL);
            $c->addSelectColumn(appCategoryImageTagGalleryI18nPeer::URL);
            $c->addSelectColumn(self::DESCRIPTION_COLOR);
            $c->addSelectColumn(self::TAGS);
            $c->add(self::CATEGORY_ID, $category->getId());
            $c->addAscendingOrderByColumn(self::POSITION);
            self::setHydrateMethod(array('appCategoryImageTagGalleryPeer', 'hydrateRs'));
            $rs = self::doSelectWithI18n($c);
            self::$galleryPool[$category->getId()] = self::hydrateGallery($rs, $category);
        }

        return self::$galleryPool[$category->getId()];
    }

    public static function doSelectImagesByCategory(Category $category)
    {
        if (!isset(self::$tagPool[$category->getId()]) && !array_key_exists($category->getId(), self::$tagPool))
        {
            $c = new Criteria();
            $c->addSelectColumn(self::ID);
            $c->addSelectColumn(self::IMAGE);
            $c->add(self::CATEGORY_ID, $category->getId());
            $c->addAscendingOrderByColumn(self::POSITION);
            $rs = self::doSelectRS($c);
            self::$tagPool[$category->getId()] = self::hydrateImages($rs, $category);
        }

        return self::$tagPool[$category->getId()];
    }

    protected static function hydrateGallery(ResultSet $rs, Category $category)
    {
        $results = array();

        while($rs->next())
        {
            list($id, $image, $opt_desc, $desc, $opt_url, $url, $color, $tags) = $rs->getRow();

            if (null === $image && null === $category->getSfAssetId())
            {
                continue;
            }

            $results[$id] = array(
                'image' => null !== $image ? self::getImagePath($category->getId(), $image) : '/'.$category->getOptImage(),
                'description' => null !== $desc ? $desc : $opt_desc,
                'color' => !$color ? 'white' : 'black', 
                'tags' => $tags ? unserialize($tags) : array(),
                'url' => null !== $url ? $url : $opt_url
            );
        }

        return $results;        
    }

    protected static function hydrateImages(ResultSet $rs, Category $category)
    {
        $results = array();

        while($rs->next())
        {
            list($id, $image) = $rs->getRow();

            if (null === $image && null === $category->getSfAssetId())
            {
                continue;
            }

            $results[$id] = null !== $image ? self::getImagePath($category->getId(), $image) : '/'.$category->getOptImage();
        }

        return $results;
    }

    public static function hydrateRs(ResultSet $rs)
    {
        return $rs;
    }
}
