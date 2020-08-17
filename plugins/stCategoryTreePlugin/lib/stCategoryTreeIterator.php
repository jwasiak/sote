<?php

class stCategoryTreeIterator implements Iterator
{

   protected $categories = null;
   protected $position = 0;
   protected $selected = null;
   protected $expanded = array();
   protected $parents = array();
   protected $currentDepth = 0;
   protected $hideRoot = false;
   protected $expandRoot = false;
   protected $expandAlways = false;

   public function __construct($categories, $expanded = array())
   {
      $config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

      $this->hideRoot = $config->get('hide_root');

      $this->expandRoot = $config->get('expand_root');

      $this->expandAlways = $config->get('expand_always');

      $this->categories = $categories;

      $this->position = 0;

      $this->expanded = $expanded;

      $this->selected = $expanded ? end($expanded) : null;
   }

   public function current()
   {
      $current = $this->categories[$this->position];

      $current['has_children'] = $this->hasChildren($current);

      if ($current['has_children'])
      {
         $this->currentDepth++;
      }

      $current['is_expanded'] = $this->isExpanded($current);

      $current['is_first'] = $this->isFirst($current);

      $current['is_last'] = $this->isLast($current);

      $current['is_hidden'] = $this->isHidden($current);

      $current['is_expanded'] = $this->isExpanded($current);

      $current['is_selected'] = $this->isSelected($current);

      $current['close_tag_count'] = $this->getCloseTagCount($current);

      return $current;
   }

   public function hasChildren($current)
   {
      $next = $this->position + 1;

      return isset($this->categories[$next]) && $this->categories[$next]['lft'] > $current['lft'] && $this->categories[$next]['rgt'] < $current['rgt'];
   }

   public function previous()
   {
      return $this->categories[$this->position - 1];
   }

   public function key()
   {
      return $this->position;
   }

   public function next()
   {
      $this->position++;
   }

   public function rewind()
   {
      $this->position = 0;
   }

   public function valid()
   {
      return isset($this->categories[$this->position]);
   }

   protected function isExpanded($current)
   {
      return isset($this->expanded[$current['id']]) || (!$this->expanded || $this->expandAlways) && $current['depth'] <= $this->expandRoot || $this->hideRoot && $current['depth'] == 0;
   }

   protected function isFirst($current)
   {
      $prev = $this->previous();

      return $this->position == 0 || $prev['depth'] < $current['depth'];
   }

   protected function isLast($current)
   {
      $is_last = true;

      $pos = $this->position + 1;

      while (isset($this->categories[$pos]) && $current['rgt'] > $this->categories[$pos]['rgt'])
      {
         $pos++;
      }

      if (isset($this->categories[$pos]) && $this->categories[$pos]['depth'] == $current['depth'])
      {
         $is_last = false;
      }

      return $is_last;
   }

   protected function getCloseTagCount($current)
   {
      $next = $this->position + 1;

      if (isset($this->categories[$next]) && $this->categories[$next]['depth'] <= $current['depth'])
      {
         $tmp = $current['depth'] - $this->categories[$next]['depth'];

         $this->currentDepth -= $tmp;

         return $tmp;
      }
      else
      {
         return $this->currentDepth - 1;
      }
   }

   protected function isHidden($current)
   {
      return $this->hideRoot && $current['is_root'];
   }

   protected function isSelected($current)
   {
      return $current['id'] == $this->selected;
   }

}