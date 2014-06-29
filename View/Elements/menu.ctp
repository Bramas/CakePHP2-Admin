<?php
if(!isset($parent_id))
{
	$parent_id = 0;
}
if(!isset($depth))
{
	$depth = 1;
}
if(!isset($id))
{
	$id = '';
}
if(!isset($class))
{
	$class = 'nav';
}
$Menus = $this->requestAction('/menus/getList/'.$parent_id.'/'.$depth);


function renderTree(&$View, $tree, $depth, $id = null, $class = 'nav') {

	if ($depth < 0) {
		return;
	}
	$result = '<ul class="'.$class.'" id="'.$id.'">';

	foreach($tree as $node)
	{
		$url = $View->Html->url('/'.$node['Menu']['slug']);
		$linkclass = (strtolower($View->request->here) == strtolower($url) ? 'active' : '');
		$options = array('class' => $linkclass);
		$result .= '<li>' . $View->Html->link($node['Menu']['title'], '/'.$node['Menu']['slug'], $options);
		if (!empty($node['children'])) {
			$result .=  renderTree($View, $node['children'], $depth - 1, '', 'nav-submenu');
		}
		$result .= '</li>';
	}

  return $result."</ul>";
}
echo renderTree($this, $Menus, 1, $id, $class);

