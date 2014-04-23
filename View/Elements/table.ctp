<?php
	$columns;
	$data;

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
					echo $this->Html->link($d[$cName], $url);
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
			foreach($actions as $id => $action)
			{
				if($id =='separator')
				{
					echo $action;
					continue;
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
				echo ' '.$this->Html->link(empty($action['label'])?'':$action['label'], $url, empty($action['options'])?array():$action['options']);
			}
			echo '</td>';
		}

		 ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>