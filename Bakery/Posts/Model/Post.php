<?php

class Post extends AppModel
{

	
public $actsAs = array(
       'Upload.Upload' => array(
       'fields'=>array(
       		'featured_image' => 'files/:basename')
       )
    );
}