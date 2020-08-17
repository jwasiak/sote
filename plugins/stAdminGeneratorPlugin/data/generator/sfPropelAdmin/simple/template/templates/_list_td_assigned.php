<?php if ($through_class = $this->getParameterValue('list.build_options.through_class')): ?>
<?php $class = $this->getClassName() ?>
<?php $through_column = $this->getParameterValue('list.build_options.through_column') ?>
<?php $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column) ?>
<?php $related_column = stPropelManyToMany::getRelatedColumn($class, $through_class, $through_column) ?>
<?php $column = stPropelManyToMany::getColumn($class, $through_class, $through_column) ?>
[?php
    $c = new Criteria();
    $c->add(<?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>, <?php echo $this->getForwardParameterBy('list.build_options.related_id') ?>);
    $assigned = $<?php echo $this->getSingularName() ?>->count<?php echo $through_class ?>s<?php if ($through_column) echo 'RelatedBy' . sfInflector::camelize($through_column) ?>($c);
?]
<td class="column_assigned">[?php if ($assigned) echo image_tag('/images/backend/beta/icons/16x16/tick.png'); else echo '&nbsp;'; ?]</td>
<?php endif; ?>