<?php
	$columns;
	$data;
	App::uses('Admin', 'Admin.Lib');

?>
<table class="table table-striped">
	<thead>
		<tr>
		<?php foreach($columns as $c): ?>
			<th><?php echo is_array($c) ? $c['header'] : $c; ?></th>
		<?php endforeach;
		if(!empty($actions))
		{
			echo '<th>'.__('Actions').'</th>';
		}
		 ?>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data as $d): $d = $d[$model]; ?>
		<tr>
		<?php foreach($columns as $cName => $c):		 ?>
			<th><?php 
			if(!empty($d[$cName]))
			{ 
				if(is_array($c) && !empty($c['action']))
				{
					$url = $actions[$c['action']]['url'];
					$field = empty($actions[$c['action']]['field'])?'id':$actions[$c['action']]['field'];
					if(is_array($url))
					{
						$url = array_merge($url, array($d[$field]));
					}
					else
					{
						$url .= '/'.$d[$field];
					}

					if(!empty($actions[$c['action']]['require']))
					{
						$args = null;
						if(is_array($actions[$c['action']]['require']))
						{
							$cap = $actions[$c['action']]['require'][0];
							if(count($actions[$c['action']]['require']) > 1){
								$args = $d[$actions[$c['action']]['require'][1]];
							}
							
						}
						else
						{
							$cap = $actions[$c['action']]['require'];
						}
						if(!Admin::hasCapability($cap, $args))
						{
							echo $d[$cName];
						}
						else
						{
							echo $this->Html->link($d[$cName], $url);
						}
					}
					else
					{
						echo $this->Html->link($d[$cName], $url);
					}
				}
				else
				{
					echo $d[$cName];
				}
			} ?></th>
		<?php endforeach;

		if(!empty($actions))
		{
			echo '<td class="admin-table-actions">';
			$separator = '';
			if(!empty($actions['separator']))
			{
				$separator = $actions['separator'];
			}
			$actionStrings = array();
			foreach($actions as $id => $action)
			{
				if($id =='separator')
				{
					continue;
				}
				if(!empty($action['require']))
				{
					$args = null;
					if(is_array($action['require']))
					{
						$cap = $action['require'][0];
						if(count($action['require']) > 1){
							$args = $d[$action['require'][1]];
						}
						
					}
					else
					{
						$cap = $action['require'];
					}
					if(!Admin::hasCapability($cap, $args))
					{
						continue;
					}
				}
				$url = $action['url'];
				$field = empty($action['field'])?'id':$action['field'];
				if(is_array($url))
				{
					$url = array_merge($url, array($d[$field]));
				}
				else
				{
					$url .= '/'.$d[$field];
				}
				if(!empty($action['options']['title']))
				{
					$action['options']['data-toggle'] = "tooltip";
				}
				$actionStrings[] = ' '.$this->Html->link(empty($action['label'])?'':$action['label'], $url, empty($action['options'])?array():$action['options']);
			}
			echo implode($separator, $actionStrings);
			echo '</td>';
		}

		 ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>