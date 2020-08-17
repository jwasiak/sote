<?php

/**
 * Subclass for representing a row from the 'st_slide_banner' table.
 *
 * 
 *
 * @package plugins.stSlideBannerPlugin.lib.model
 */ 
class SlideBanner extends BaseSlideBanner
{
   public function genImagePath($image, $system_dir = false)
   {
      $path =  "/picture/" . $this->getLanguage()->getOriginalLanguage() . '/' . $this->id . '-' . $image;

      if ($system_dir)
      {
         return sfConfig::get('sf_upload_dir').$path;
      }

      return $path;
   }

   public function getImagePath($system_dir = false)
   {
      $path = 'uploads'.$this->getImage();

      if ($system_dir)
      {
         return sfConfig::get('sf_web_dir').'/'.$path;
      }

      return $path;
   }

   public function getImageSmallPath($system_dir = false)
   {
      $path = 'uploads'.$this->getImageSmall();

      if ($system_dir)
      {
         return sfConfig::get('sf_web_dir').'/'.$path;
      }

      return $path;
   }

   public function removeImage()
   {
      $path = $this->getImagePath(true);

      if (is_file($path))
      {
         unlink($path);
      }

      $this->setImage(null);
   }

   public function removeImageSmall()
   {
      $path = $this->getImageSmallPath(true);

      if (is_file($path))
      {
         unlink($path);
      }

      $this->setImageSmall(null);
   }

   public function moveUp()
   {
      $c = new Criteria();
      //$c->add(SlideBannerPeer::ID, $this->getId());

      $c->add(SlideBannerPeer::RANK, $this->getRank(), Criteria::LESS_THAN);

      $c->addDescendingOrderByColumn(SlideBannerPeer::RANK);

      $previous = SlideBannerPeer::doSelectOne($c);

      if ($previous)
      {
         $rank = $this->getRank();

         $this->setRank($previous->getRank());

         $previous->setRank($rank);

         $previous->save();

         $this->save();
      }
   }

   public function moveDown()
   {
      $c = new Criteria();

      $c->add(SlideBannerPeer::RANK, $this->getRank(), Criteria::GREATER_THAN);

      $c->addAscendingOrderByColumn(SlideBannerPeer::RANK);

      $next = SlideBannerPeer::doSelectOne($c);

      if ($next)
      {
         $rank = $this->getRank();

         $this->setRank($next->getRank());

         $next->setRank($rank);

         $next->save();

         $this->save();
      }
   }  

   public function save($con = null)
   {
      if ($this->isNew())
      {
         $c = new Criteria(); 
         $banners = SlideBannerPeer::doSelect($c);  
                
         foreach ($banners as $banner) {
             $banner->setRank($banner->getRank()+1);
             $banner->save();
         } 
          
         $max_rank = SlideBannerPeer::doSelectMaxRank($this->getId());
         $this->setRank(1);
      }
      
      if ($this->isNew())
      {
         $this->setOptCulture($this->getLanguage()->getOriginalLanguage());
      }

      $ret = parent::save($con);
      SlideBannerPeer::clearCache();
      
      return $ret;
   } 

   public function delete($con = null)
   {
      $rank = $this->getRank();

      $group_id = $this->getId();

      $ret = parent::delete($con);
      
      $this->removeImage();
      $this->removeImageSmall();
      SlideBannerPeer::clearCache();

      return $ret;
   }

   public function hasAbsoluteLink()
   {
      return $this->link[0] != '/';
   }
   
   public function hasAbsoluteButtonLink()
   {
      return $this->button_link[0] != '/';
   }      
}
