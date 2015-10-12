<?php

	namespace DTL;

	use Doctrine\MongoDB\Connection;
	use Doctrine\ODM\MongoDB\Configuration;
	use Doctrine\ODM\MongoDB\DocumentManager;
	use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

	class MongoDocumentManager {

		protected $username = 'devtech';
		protected $password = 'devtech';
		protected $dbHost = 'ds033734.mongolab.com';
		protected $dbPort = '33734';
		protected $dbName = 'dtl-stored-books';
		protected $dm;

		function __construct () {
			$url = $this->composeServerURL();
			$connection = new Connection($url);
			$config = new Configuration();
			$config->setProxyDir(__DIR__ . '/Proxies');
			$config->setProxyNamespace('Proxies');
			$config->setHydratorDir(__DIR__ . '/Hydrators');
			$config->setHydratorNamespace('Hydrators');
			$config->setDefaultDB($this->dbName);
			$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/modules/dtlModels'));

			AnnotationDriver::registerAnnotationClasses();

			$this->dm = DocumentManager::create($connection, $config);

		}

		private function composeServerURL () {
			$url = "mongodb://{$this->username}:{$this->password}@{$this->dbHost}:{$this->dbPort}/{$this->dbName}";
			return $url;
		}

		public function getInstance () {
			return $this->dm;
		}

		public function persist ($book) {
			$this->dm->persist($book);
		}

		public function flush () {
			$this->dm->flush();
		}

	}