<?php

class AdminRoute extends CakeRoute {
 
    function parse($url) {
        //explode('/', $url)
        $url = explode('/', $url);
        if(count($url) > 1)
        {
            $params = array(
                'slug' => $url[1]
            );
            $params['pass'] = array_slice($url, 2);
        }
        else
        {
            $url = array('pass' => array());
        }
       

        App::uses('Menu','Admin.Model');
        $Menu = new Menu();

        if(empty($params['slug']))
        {
            $menu = $Menu->findByDefault(1);
        }
        else
        {
            $menu = $Menu->findBySlug($params['slug']);
        }
        
	    if(empty($menu))
        {
            $params['controller']=$params['slug'];
            if(!empty($params['pass']) && count($params['pass']))
            {
                $params['action']=$params['pass'][0];
                unset($params['pass'][0]);
                $params['pass']=array_values($params['pass']);
            }
            return $params;
        }
        
        App::uses('Admin', 'Admin.Lib');
        $view = Admin::getAdminView($menu);
        Configure::write('Admin.Menu',$menu['Menu']);
        $params['controller'] =  $view['frontend']['url']['controller'];
        $params['action'] =  $view['frontend']['url']['action'];
        $params['plugin'] =  $view['frontend']['url']['plugin'];
        if($menu['Menu']['args'] !== '')
        {
            $params['pass'] = isset($params['pass'])?$params['pass']:array();
            $params['pass'] = array_merge((array)$menu['Menu']['args'],$params['pass']);
        }
        return $params;
    }
    
    function match($url)
    {
        if(isset($url['default']))
        {
            if($url['default'])
            { 
                return '/';
            }
            unset($url['default']);
        }
        if(!empty($url['slug']))
        {
            return $url['slug'];
        }
        
        return parent::match($url);
    }
 
}