<?php

foreach($menus as $menu)
{
	$menu = $menu['Menu'];
	echo '<div>'.$this->Html->link($menu['title'], '/'.$menu['slug']).'</div>';
}