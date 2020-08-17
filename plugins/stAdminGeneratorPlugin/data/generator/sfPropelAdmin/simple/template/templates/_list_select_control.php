<div class="list_select_control">
[?php if ($<?php echo $this->getSingularName() ?>_action_select_options): ?]   
      <select name="<?php echo $this->getSingularName() ?>_action" style="width: 110px">
         <option value="">[?php echo __('Zaznaczone:', null, 'stAdminGeneratorPlugin') ?]</option>
[?php foreach($<?php echo $this->getSingularName() ?>_action_select_options as $group => $options): ?]
[?php if ($group != 'NONE'): ?]
[?php $i18n_group = __($group, null, 'stAdminGeneratorPlugin') ?]
<optgroup label="[?php echo $i18n_group ?]">
[?php endif; ?]
[?php foreach($options as $value => $option): ?]
[?php if (is_array($option)): ?]
         <option value="[?php echo $value ?]" data-category="[?php echo $group != 'NONE' ? $i18n_group : '' ?]" data-confirm="[?php echo isset($option['confirm']) ? $option['confirm'] : ''  ?]" data-ajax="[?php echo isset($option['ajax']) && $option['ajax'] ?]">[?php echo $option['name'] ?]</option>
[?php else: ?]
         <option value="[?php echo $value ?]" data-category="[?php echo $group != 'NONE' ? $i18n_group : '' ?]">[?php echo $option ?]</option>
[?php endif; ?]
[?php endforeach; ?]
[?php if ($group != 'NONE'): ?]
</optgroup>
[?php endif; ?]
[?php endforeach; ?]
      </select>
[?php endif; ?]
</div>