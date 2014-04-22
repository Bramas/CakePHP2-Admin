<?php
	$columns;
	$data;


?>
<table class="table table-striped">
	<thead>
		<tr>
		<?php foreach($columns as $c): ?>
			<th><?php echo $c ?></th>
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
			<th><?php if(!empty($d[$cName])) echo $d[$cName]; ?></th>
		<?php endforeach;

		if(!empty($actions))
		{
			echo '<td class="admin-table-actions">';
			foreach($actions as $action)
			{
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
				echo ' '.$this->Html->link(empty($action['label'])?'':$action['label'], $url, empty($action['options'])?array():$action['options']);
			}
			echo '</td>';
		}

		 ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php

debug($data);

?>