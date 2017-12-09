<?php
if($type == "top") echo $this->menus->get_menu('top', 0, "nav nav-tabs");
elseif($type == "side") echo $this->menus->get_menu('side', 0, "nav nav-pills nav-stacked");