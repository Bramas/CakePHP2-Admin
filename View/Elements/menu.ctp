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

if(!function_exists('renderTree'))
{
	function renderTree(&$View, $tree, $depth, $id = null, $class = 'menu') {

		if ($depth < 0) {
			return;
		}
		$result = '<ul class="'.$class.'" id="'.$id.'">';

		foreach($tree as $node)
		{
			$node['Menu']['params'] = json_decode($node['Menu']['params'], true);
			$liClass = "";
			if(!empty($node['Menu']['params']['class']))
			{
				$liClass = $node['Menu']['params']['class'];
			}
			$url = $View->Html->url('/'.$node['Menu']['slug']);
			$linkclass = (strtolower($View->request->here) == strtolower($url) ? 'active' : '');
			$options = array('class' => $linkclass);
			$result .= '<li class="'.$liClass.'">' . $View->Html->link($node['Menu']['title'], '/'.$node['Menu']['slug'], $options);
			if (!empty($node['children'])) {
				$result .=  renderTree($View, $node['children'], $depth - 1, '', 'submenu');
			}
			$result .= '</li>';
		}

	  return $result."</ul>";
	}
}
echo renderTree($this, $Menus, 1, $id, $class);

