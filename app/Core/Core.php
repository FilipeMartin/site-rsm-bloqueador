<?php
namespace Core;

class Core {

	public function run(){
		
		$url = '/';
		if(!empty($_GET['url'])){
			$url .= $_GET['url'];
		}

		$params = array();

		if(!empty($url) && $url != '/'){
			$url = explode('/', $url);
			array_shift($url);

			$currentController = $url[0].'Controller';
			array_shift($url);

			if(!empty($url[0])){
				$currentAction = $url[0];
				array_shift($url);
			} else{
				$currentAction = 'index';
			}

			if(count($url) > 0){
				$params = $url;
			}

		} else{
			$currentController = 'HomeController';
			$currentAction = 'index';
		}

		$currentController = $this->convert($currentController, "Class");
		$currentAction = $this->convert($currentAction, "Method");

		if($currentController == "ApiController"){
			$currentController = '\Controllers\\'.$currentController;
			$controller = new $currentController();
			$controller->run();
			exit;
		}

		if(!file_exists('../app/Controllers/'.$currentController.'.php') || !method_exists('\Controllers\\'.$currentController, $currentAction) || method_exists('\Core\Controller', $currentAction)){

			$currentController = 'NotFoundController';
			$currentAction = 'index';
		}

		$currentController = '\Controllers\\'.$currentController;
		$controller = new $currentController();

		call_user_func_array(array($controller, $currentAction), array($params));
	}

	private function convert(string $value, string $type): string {

		if(strpos($value, "_")){
			$value = str_replace("_", " ", $value);
			$value = ucwords($value);
			$value = str_replace(" ", "", $value);

			if($type == "Method"){
				$value = lcfirst($value);
			}

		} else if($type == "Class"){
			$value = ucfirst($value);
		}

		return $value;
	}
}