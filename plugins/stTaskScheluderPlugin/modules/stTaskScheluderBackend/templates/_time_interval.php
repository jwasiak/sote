<?php 

echo select_tag('task[time_interval]', options_for_select(TaskPeer::getTimeIntervals(), $task->getTimeInterval()));