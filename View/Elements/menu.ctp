<?php
if(!isset($parent_id))
{
	$parent_id = 0;
}
if(!isset($depth))
{
	$depth = 1;
}
$Menus = $this->requestAction('/menus/getList/'.$parent_id.'/'.$depth);



function renderTree($tree, $depth) {
	if ($depth < 0) {
		return;
	}
	$result = '<ul>';

	foreach($tree as $node)
	{
		$result .= '<li>' . $node['Menu']['title'];
		if (!empty($node['children'])) {
			$result .=  renderTree($node['children'], $depth - 1);
		}
		$result .= '</li>';
	}

  return $result."</ul>";
}
echo renderTree($Menus, 1);

