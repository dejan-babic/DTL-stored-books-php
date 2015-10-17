<?php

	namespace DTL;

	use InvalidArgumentException;
	use ReflectionClass;

	class ApiController implements IApiController {

		const DEFAULT_CONTROLLER = __NAMESPACE__."\\"."HomeController";
		const DEFAULT_ACTION     = "index";

		protected $controller    = self::DEFAULT_CONTROLLER;
		protected $action        = self::DEFAULT_ACTION;
		protected $params        = array();
		protected $basePath      = "/";
		protected $dc;

		public function __construct($dc = null, array $options = array()) {
			$this->dc = $dc;
		}

		protected function parseUri() {
			$path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
			//$path = preg_replace('/[^a-zA-Z0-9]/', "", $path);
			if (strpos($path, $this->basePath) === 0) {
				$path = substr($path, strlen($this->basePath));
			}

			@list($controller, $action, $params) = explode("/", $path, 3);

			if (!empty($controller)) {
				$this->setController($controller);
			}
			if (!empty($action)) {
				$this->setAction($action);
			}
			if (!empty($params)) {
				$this->setParams(explode("/", $params));
			}
		}

		public function setController ($controller) {
			$controller = __NAMESPACE__ . '\\' . ucfirst(strtolower($controller)) . "Controller";
			if (!class_exists($controller)) {
				throw new InvalidArgumentException(
					"The action controller '$controller' has not been defined.");
			}
			$this->controller = $controller;
			return $this;
		}

		public function setAction ($action) {
			$reflector = new ReflectionClass($this->controller);
			if (!$reflector->hasMethod($action)) {
				throw new InvalidArgumentException(
					"The controller action '$action' has been not defined.");
			}
			$this->action = $action;
			return $this;
		}

		public function setParams (array $params) {
			$this->params = $params;
			return $this;
		}

		public function run () {
			call_user_func_array(array(new $this->controller($this->dc), $this->action), array($this->params));
		}
	}