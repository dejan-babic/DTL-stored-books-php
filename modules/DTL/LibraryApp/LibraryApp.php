<?php

	namespace DTL;

	use Doctrine\MongoDB\Connection;
	use Exception;
	use RuntimeException;
	use Doctrine\ODM\MongoDB\Configuration;
	use Doctrine\ODM\MongoDB\DocumentManager;
	use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
	use Jsv4;
	use Pimple\Container;

	class LibraryApp {

		private static $instance;
		private $configuration;
		private $configurationSchema;
		private $dependencyContainer;

		protected function __construct () {

			try {

				$this->loadConfiguration();
				$this->loadSchema();
				$this->validateConfiguration();
				$this->prepareDependencyContainer();
				$this->loadDependencies();
				$this->populateDependencyContainer();
				$this->startApiController();

			} catch (Exception $e) {
				print_r($e->getMessage());
			}
		}

		public static function run () {

			if (null === static::$instance) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		private function loadConfiguration () {

			$data = @file_get_contents('config.json');

			if (!$data) {
				throw new RuntimeException("The LibraryAPI configuration is not found");
			}

			$this->configuration = json_decode($data);
		}

		private function loadSchema () {

			$schema = @file_get_contents('schemas/config.schema.json');

			if (!$schema) {
				throw new RuntimeException("The LibraryAPI configuration schema is not found");
			}

			$this->configurationSchema = json_decode($schema);
		}

		private function validateConfiguration () {

			if (!Jsv4::isValid($this->configuration, $this->configurationSchema)) {
				throw new RuntimeException("The LibraryAPI configuration failed schema validation");
			}
		}

		private function prepareDependencyContainer () {

			$this->dependencyContainer = new Container();
			//TODO [DB] move out to separate func
			$this->dependencyContainer[DC_CONFIG_KEY] = function () {
				return $this->configuration;
			};
		}

		private function populateDependencyContainer () {

			$dc = $this->dependencyContainer;

			$dc[DC_CONNECTION_KEY] = function ($c) {
				return new MongoConnection($c);
			};

			$dc[DC_ODM_CONNECTION_KEY] = function ($c) {
				return new Connection($c[DC_CONNECTION_KEY]->composeServerUrl());
			};

			$dc[DC_ODM_CONFIGURATION_KEY] = function () {
				return new Configuration();
			};

			$dc[DC_ODM_ANNOTATION_DRIVER_KEY] = function () {
				return AnnotationDriver::class;
			};

			$dc[DC_ODM_DOCUMENT_MANAGER_KEY] = function () {
				return DocumentManager::class;
			};

			$dc[DC_DTL_DOCUMENT_MANAGER_KEY] = function ($c) {
				return new MongoDocumentManager($c);
			};
		}

		private function loadDependencies () {

			AutoLoader::init($this->dependencyContainer);
		}


		private function startApiController () {
			$apiController = new ApiController($this->dependencyContainer);
			$apiController->run();
		}

		private function __clone () {}

		/** @noinspection PhpUnusedPrivateMethodInspection */
		private function __wakeup () {}

	}