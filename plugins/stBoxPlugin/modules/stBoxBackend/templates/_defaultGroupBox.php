<?php
echo select_tag('box_group[default_group_box]', options_for_select($default_group_box,$box_group->getBoxGroup()));?>