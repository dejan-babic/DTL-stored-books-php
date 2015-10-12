<?php

	namespace DTL;

	final class AutoLoader {

		private static $instance;
		private $paths;
		private $extensions;

		public function __construct () {
			$this->setPaths();
			$this->setExtensions();
			$this->registerLoader();
		}

		public static function init () {

			if (null === static::$instance) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		public function load ($class) {

			foreach ($this->paths as $path) {
				foreach ($this->extensions as $extension) {
					$filePath = $path.DIRECTORY_SEPARATOR.$class.$extension;
					$filePath = $this->prepareFilePath($filePath);
					if(file_exists($filePath)) {
						/** @noinspection PhpIncludeInspection */
						require_once($filePath);
						return;
					}
				}
			}

		}

		private function setPaths () {
			$this->paths = $this->appendModulesToPath();
		}

		private function setExtensions () {
			//TODO [DB] store and get values from a config manager
			$this->extensions = MODULE_EXTENSIONS;
		}

		private function registerLoader () {
			spl_autoload_register(array($this, 'load'));
		}

		private function appendModulesToPath () {

			$s = DIRECTORY_SEPARATOR;
			//TODO [DB] store and get values from a config manager
			foreach (MODULES_PATH as $mp) {
				foreach (MODULES as $module) {
					set_include_path(get_include_path().PATH_SEPARATOR.APP_PATH.$s.$mp.$s.$module);
				}
			}

			return explode(PATH_SEPARATOR, get_include_path());

		}

		private function prepareFilePath ($filePath) {

			$filePath = str_replace(__NAMESPACE__, '', $filePath);
			$filePath = str_replace("\\", '', $filePath);
			return $filePath;

		}

	}