<?php 

foreach($Posts as $post)
{
	echo $this->Static->image($post['Post']['featured_image'].'_100x100');
}
debug($type);
debug($Posts);