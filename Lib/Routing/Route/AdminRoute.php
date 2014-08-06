<?php

class AdminRoute extends CakeRoute {
 
    function parse($url) {
        //return false;//exit(debug(parent::parse($url)));
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
            if(empty($menu))
            {
                throw new NotFoundException('Aucune page d\'accueil n\'a été trouvée');
            }
        }
        else
        {
            $menu = $Menu->findBySlug($params['slug']);
        }
        
	    if(empty($menu))
        {
            return false;
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
        if(empty($view))
        {
            if(Configure::read('debug') == 2)
            {
                throw new NotFoundException(__('Le controller '.$menu['Menu']['controller'].' n\'a pas défini de vue. Ajouter la variable public $adminViews.'));
            }
            throw new NotFoundException(__('Page introuvable'));
        }
        $menu['Menu']['custom_fields'] = json_decode($menu['Menu']['custom_fields'], true);
        Configure::write('Admin.Menu',$menu['Menu']);
        $params['controller'] =  $view['frontend']['url']['controller'];
        $params['action'] =  $view['frontend']['url']['action'];
        $params['plugin'] =  $view['frontend']['url']['plugin'];
        if($menu['Menu']['args'] !== '')
        {
            $params['pass'] = isset($params['pass']) ? $params['pass'] : array();
            $params['pass'] = array_merge((array)$menu['Menu']['args'],$params['pass']);
        }
        return $params;
    }
    
    function match($url)
    {
        if(isset($url['admin']) && $url['admin'] === true)
        {
            if(isset($url['plugin']) && strtolower($url['plugin']) == 'admin')
            {
                unset($url['plugin']);
                unset($url['admin']);
                $controller = isset($url['controller']) ? $url['controller'].'/' : '';
                $action = isset($url['action']) ? $url['action'].'/' : '';
                unset($url['controller']);
                unset($url['action']);
                return '/admin/'.$controller.$action.implode('/', array_values($url));
            }
        }
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