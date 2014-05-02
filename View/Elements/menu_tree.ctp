<?php
App::uses('Admin', 'Admin.Lib');

$here = $this->request->here;
function printNode($Html, $node, $here)
{
	$menu = $node['Menu'];
	$url = array(
		'controller' => 'menus',
		'action' => 'edit',
		'admin' => true,
		'plugin' => 'admin',
		$menu['id']
		);
	$jstreeData = '{"selected":'.($Html->url($url) == $here? 'true' : 'false').'}';
	echo '<li data-jstree=\''.$jstreeData.'\' '.
	'data-menu-url="'.$Html->url($url).'" '.
	'data-menu-id="'.$menu['id'].'">'.$menu['title'];
	echo '<ul>';
	foreach($node['children'] as $child)
	{
		printNode($Html, $child, $here);
	}
	echo '</ul>';
	echo '</li>';
}

if(Admin::hasCapability('admin.menus.list'))
{
	$Menus = $this->requestAction(array('controller' => 'menus', 'action' => 'list' , 'plugin' => 'admin', 'admin' => true), array());




?>
<div id="jstree">
	<ul>
	<?php printNode($this->Html, $Menus[0], $here); ?>
	</ul>
</div>

<script type="text/javascript">

var canCreateNode = <?php echo Admin::hasCapability('admin.menu.create_menu')?'true':'false'; ?>;
var canDeleteNode = <?php echo Admin::hasCapability('admin.menu.delete')?'true':'false'; ?>;
var canEditNode = <?php echo Admin::hasCapability('admin.menu.edit')?'true':'false'; ?>;

jQuery(function ($) { 
	$('#jstree').jstree(
	{
		core : {
	      check_callback :  function (operation, node, node_parent, node_position, more) {
	            // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node' or 'copy_node'
	            // in case of 'rename_node' node_position is filled with the new node name
	            if((operation === 'rename_node'
	            	|| operation === 'move_node') && canEditNode)
	            {
	            	return true;
	            }
	            if(operation === 'create_node' && canCreateNode)
	            {
	            	return true;
	            }
	            if(operation === 'delete_node' && canDeleteNode)
	            {
	            	{
	            		return true;
	            	}
	            }
	            return false;
	        }
	    },
	    types : {
			"#" : {
			  max_children : 1, 
			  max_depth : 3, 
			  valid_children : ["root"]
			},
		    root : {
		      icon : "/static/3.0.0/assets/images/tree_icon.png",
		      valid_children : ["default"]
		    }
		},
		state:{
			filter:function(data) {
				data.core.selected = undefined;
				return data;
			}
		},
		contextmenu: {
			select_node:false,
			items:function (node) {
				var tree = $("#jstree").jstree(true);
				ret = {}
				if(canCreateNode)
				{
					ret.create = {
						label:"Nouvelle Page",
						action:function(ev){ 
							createMenu(tree,node)
						},
	                	separator_after: true
					};
				}
				if(canEditNode)
				{
					ret.rename = {
	                	separator_before: true,
						label:"Renommer",
						action:function(ev){ tree.edit(node); }
					};
				}
				if(canDeleteNode)
				{
					ret.delete = {
						label:"Supprimer",
						action:function(ev){ deleteMenu(tree,node); }
					};
				}
	        	return ret;
	        }
		},
	    plugins : [ "types" , "dnd" , "contextmenu" , "state"]
	}); 

	$('#jstree').on('move_node.jstree',function(ev, data){

		$('#jstree').jstree(true).disable_node(data.node);
		$('#jstree').addClass('loading');

		var oldPosition = $('#'+data.node.id).parent().children().index('#'+data.node.id);
		var id = data.node.data.menuId;
		var delta = data.position - oldPosition;
		var old_parent_id = $('#'+data.old_parent).attr('data-menu-id');
		var parent_id = $('#'+data.parent).attr('data-menu-id');
		var url = '<?php echo $this->Html->url(array('controller' => 'menus', 'action' => 'move'), true); ?>';

		if(delta > 0)
		{
			delta -= 1;
		}
		else
		{
			delta -= 1;
		}

		$.ajax({
			type 	: 'POST',
			dataType: 'json',
			url 	: url,
			data 	: {
				"data[old_parent_id]" : old_parent_id,
				"data[position]" : data.position,
				"data[Menu][parent_id]": parent_id,
				"data[Menu][id]"    : id
			},
			context:data,
			error: function(){
				
				$('#jstree').removeClass('loading');
				adminConnexionLost();
			},
			success: function(data)
			{
				if(data.error)
				{
					adminConnexionLost();
				}
				$('#jstree').removeClass('loading');
				$('#jstree').jstree(true).enable_node(this.node);
			}
		});
	}); 

	$('#jstree').on('activate_node.jstree',function(ev, data){
		var url = $('#'+data.node.id).attr('data-menu-url');

		adminSelectNode(data.node);
		adminLoadLayoutContent({
			url     : url, 
			title   : data.node.text, 
			callback: 'adminSelectNode', 
			context :  data.node
		});
		//window.location = url;
	});



	function deleteMenu(tree, node)
	{
		if(node.children.length)
		{
			alert("Ce menu ne peut pas être supprimer car il contient d'autres menus.");
			return;
		}
		if(!confirm("Êtes-vous sûr?"))
		{
			return;
		}
		tree.disable_node(node);
		$('#jstree').addClass('loading');

		var url = '<?php echo $this->Html->url(array('controller' => 'menus', 'action' => 'delete'), true); ?>';
		$.ajax({
			type 	: 'GET',
			dataType: 'json',
			url 	: url+'/'+node.data.menuId,
			context:{tree:tree, node:node},
			error: function(){

				$('#jstree').removeClass('loading');
				adminConnexionLost();
			},
			success: function(data)
			{
				$('#jstree').removeClass('loading');
				if(data.error)
				{
					adminConnexionLost();
					return;
				}
				this.tree.delete_node(this.node);
				adminLoadLayoutContent(AdminBaseUrl);

			}
		});
	}

	function createMenu(tree, node)
	{
		window.location = AdminBaseUrl+'menus/create_menu/'+node.data.menuId;
		//adminDialog(AdminBaseUrl+'menus/create_page/'+node.data.menuId+'/');
	}

});
</script>
<?php

}

