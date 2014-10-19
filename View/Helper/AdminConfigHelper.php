<?php

class AdminConfigHelper extends AppHelper {

/**
 * The name of the helper
 *
 * @var string
 */
	public $name = 'AdminConfig';
	public $helpers = array('Admin.AdminForm');

	private $_group = null;
	private $_display = null;
	private $_groupValues = array();


    private $_initiated = false;
    public function init()
    {
        if($this->_initiated)
        {
            return;
        }
        $this->_initiated = true;
	?>
<script type="text/javascript">
	jQuery(function($){
		$('.admin-config-modal').on('click', '.btn-primary', function(e){
			$(this).parent().parent().parent().parent().parent().parent().find('form').submit();
		});


		$('.admin-config-modal form').on('submit', function(e){
			e.preventDefault();
        	var postData = $(this).serializeArray();
			$.ajax(
			{
	            url:$(this).attr('action'),
	            type: "POST",
	            dataType:'json',
	            data : postData,
	            context:{
	            	item:$(this).parent()
	            },
	            success:function(data)
	            {
	            	console.log(data);
	            	this.item.modal('hide');
	            }
	        });
		});

		$('form.admin-config-form').on('submit', function(e){
			e.preventDefault();
        	var postData = $(this).serializeArray();
	        $(this).html('Sauvegarde en cours...');
			$.ajax(
			{
	            url:$(this).attr('action'),
	            type: "POST",
	            dataType:'json',
	            data : postData,
	            context:{
	            	item:$(this)
	            },
	            success:function(data)
	            {
	            	console.log(data);
	            	this.item.html('Sauvegardé avec succés');
	            }
	        });
		});


	});
</script>

	<?php

	}

	public function group($group, $options = array())
	{
		$options = array_merge(array('display' => 'modal'), (array)$options);
		$this->init();
		$this->_display = $options['display'];
		$this->_group = $group;
		$this->_groupValues = $this->requestAction('/admin/config/get/'.$group);

		if($this->_display  == 'modal')
		{
			return '<div class="admin-config-modal modal fade admin-config-modal-'.$group.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">'.
			$this->AdminForm->create('Config', array('url' => '/admin/config/save')).
				  '<div class="modal-dialog modal-lg">'.
				    '<div class="modal-content">'.
				    '<div class="modal-header">'.
			            '<button type="button" class="close" data-dismiss="modal">×</button>'.
			            '<h3>Options Avancées</h3>'.
			        '</div>'.
			        '<div class="modal-body form-horizontal">'.
			$this->AdminForm->input('_group', array('value' => $this->_group, 'type'=>'hidden'));
		}
		return $this->AdminForm->create('Config', array('url' => '/admin/config/save', 'class'=>'admin-config-form')).$this->AdminForm->input('_group', array('value' => $this->_group, 'type'=>'hidden'));
	}

	public function modalButton($group, $class = "btn btn-primary")
	{
		return '<button class="'.$class.'" data-toggle="modal" data-target=".admin-config-modal-'.$group.'">Options avancées</button>';
	}


	public function input($name, $options = array())
	{
		if(empty($options['value']) && !empty($this->_groupValues[$name]))
		{
			$options['value'] = $this->_groupValues[$name];
		}
		if($options['type'] == 'menu')
		{
			return $this->inputMenu($name, $options);
		}
		return $this->AdminForm->input($name, $options);
	} 
	public function inputMenu($name, $options = array())
	{
		$options = array_merge(array(), $options);
		$options['type'] = 'select';
		ob_start();

		$list = $this->requestAction('menus/getGeneratedTreeList');
		$options['options'] = $list;
		echo $this->AdminForm->input($name, $options);

		return ob_get_clean();
	}
	public function end()
	{
		if($this->_display  == 'modal')
		{
			return '</div><div class="modal-footer">'.
	          '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'.
	          '<button type="button" class="btn btn-primary">Sauvegarder</button>'.
	        '</div></div></div>'.$this->AdminForm->end().'</div>';
	    }
	    return $this->AdminForm->end('Sauvegarder');
	}
}
