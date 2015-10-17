<?php

	namespace DTL;

	final class AutoLoader {

		private static $instance;
		private $paths;
		private $extensions;
		private $components;
		private $dependencyContainer;
		private $autoLoaderConfiguration;

		protected function __construct ($dc) {

			$this->dependencyContainer = $dc;
			$this->prepareAutoLoaderConfig();
			$this->setPaths();
			$this->setComponents();
			$this->setExtensions();
			$this->registerLoader();
		}

		public static function init ($dc) {

			if (null === static::$instance) {
				static::$instance = new static($dc);
			}

			return static::$instance;
		}

		private function prepareAutoLoaderConfig () {

			$configuration = $this->dependencyContainer[DC_CONFIG_KEY];
			$this->autoLoaderConfiguration = $configuration->autoloader;
		}

		private function setPaths () {
			$this->paths = $this->autoLoaderConfiguration->paths;
		}

		private function setComponents () {
			$this->components = $this->autoLoaderConfiguration->components;
		}

		private function setExtensions () {
			$this->extensions = $this->autoLoaderConfiguration->extensions;
		}

		private function registerLoader () {
			spl_autoload_register(array($this, 'load'));
		}

		public function load ($class) {

			$class = $this->removeNameSpace($class);

			foreach ($this->paths as $path) {
				foreach ($this->components as $component) {
					foreach ($this->extensions as $extension) {
						$filePath = $path.DIRECTORY_SEPARATOR.$component.DIRECTORY_SEPARATOR.$class.$extension;
						if(file_exists($filePath)) {
							/** @noinspection PhpIncludeInspection */
							require_once($filePath);
							return;
						}
					}
				}
			}
		}

		private function removeNameSpace ($class) {

			$class = str_replace(__NAMESPACE__, '', $class);
			$class = str_replace("\\", '', $class);
			return $class;
		}
	}