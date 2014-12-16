<?php

/*

ln -s ../Plugin/Admin/Bakery/Posts/View/Posts View/Posts
ln -s ../Plugin/Admin/Bakery/Posts/Controller/PostsController.php Controller/PostsController.php
ln -s ../Plugin/Admin/Bakery/Posts/Model/Posts Model/Post.php

ln -s ../Plugin/Admin/Bakery/Pages/View/Pages View/Pages
ln -s ../Plugin/Admin/Bakery/Pages/Controller/PagesController.php Controller/PagesController.php
ln -s ../Plugin/Admin/Bakery/Pages/Model/Pages Model/Page.php

on windows

mklink PostsController.php ..\Plugin\admin\Bakery\Posts\Controller\PostsController.php
mklink Post.php ..\Plugin\admin\Bakery\Posts\Model\Post.php
mklink Posts ..\Plugin\admin\Bakery\Posts\View\Posts

mklink PagesController.php ..\Plugin\admin\Bakery\Pages\Controller\PagesController.php
mklink Page.php ..\Plugin\admin\Bakery\Pages\Model\Page.php
mklink Pages ..\Plugin\admin\Bakery\Pages\View\Pages

*/

class BakeShell extends AppShell {

	private function mkpath($path)
	{
		if(file_exists($path)) return true;

		$this->mkpath(dirname($path));
		mkdir($path);
		$this->out("create: " .$path);
		return true;
	}
	private function copyToApp($controller, $filename)
	{
		$destination = APP.$filename;

		if(file_exists($destination))
		{
			$this->out('<warning>Warning: file already exists : '.$destination.'</warning>');
			return false;
		}

		$this->mkpath(dirname($destination));
		$this->out("copy: " .$controller.'/'.$filename);
		copy(APP.'Plugin/Admin/Bakery/'.$controller.'/'.$filename, $destination);
	}
	private function copyFolderToApp($controller, $path = '')
	{
		$dir = APP.'Plugin/Admin/Bakery/'.$controller.'/'.$path;
		if ($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false){
				if(substr($file, 0, 1) == '.')
				{
					continue;
				}
				if(is_dir($dir.$file))
				{
					$this->copyFolderToApp($controller, $path.$file.'/');
				}
				else
				{
					$this->copyToApp($controller, $path.$file);
				}
			}
			closedir($dh);
		}
	}
    public function main() {
        $this->out(__('Bienvenue dans la génération de contenu du plugin Admin.'));
		$this->hr();
		$rep = $this->in('Install Posts?', array('y', 'n'), 'y');
		if(strtolower($rep) == 'y')
		{
			$this->dispatchShell('schema create DbPost --plugin Admin');
			$this->hr();
			$rep = $this->in('Create Posts Controller, Model and Views?', array('y', 'n'), 'y');
        	if(strtolower($rep) == 'y')
			{	
				$this->copyFolderToApp('Posts');
			}
		}

		$this->hr();
		$rep = $this->in('Install Pages?', array('y', 'n'), 'y');
		if(strtolower($rep) == 'y')
		{
			$this->dispatchShell('schema create DbPage --plugin Admin');
			$this->hr();
			$rep = $this->in('Create Pages Controller, Model and Views?', array('y', 'n'), 'y');
        	if(strtolower($rep) == 'y')
			{	
				$this->copyFolderToApp('Pages');
			}
		}
		$this->hr();
        $this->out(__('Installation terminée.'));
    }
}