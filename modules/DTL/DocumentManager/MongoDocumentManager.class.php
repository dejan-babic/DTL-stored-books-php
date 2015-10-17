<?php

	namespace DTL;

	use Doctrine\MongoDB\Connection;
	use Doctrine\ODM\MongoDB\Configuration;
	use Doctrine\ODM\MongoDB\DocumentManager;
	use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

	class MongoDocumentManager {

		private $configuration;
		private $connection;
		private $odmConfiguration;
		private $annotationDriver;
		private $documentManager;
		private $dm;

		public function __construct ($dc) {

			$this->configuration = $dc[DC_CONFIG_KEY];
			$this->connection = $dc[DC_ODM_CONNECTION_KEY];
			$this->odmConfiguration = $dc[DC_ODM_CONFIGURATION_KEY];
			$this->annotationDriver = $dc[DC_ODM_ANNOTATION_DRIVER_KEY];
			$this->documentManager = $dc[DC_ODM_DOCUMENT_MANAGER_KEY];

			$this->configure();
			$this->registerAnnotations();
			$this->createDocumentManager();
		}

		private function configure () {

			/** @var Configuration $oc */
			$oc = $this->odmConfiguration;
			/** @var AnnotationDriver $ad */
			$ad = $this->annotationDriver;

			$oc->setProxyDir(__DIR__ . '/Proxies');
			$oc->setProxyNamespace('Proxies');
			$oc->setHydratorDir(__DIR__ . '/Hydrators');
			$oc->setHydratorNamespace('Hydrators');
			//TODO [DB] get value from config
			$oc->setDefaultDB('dtl-stored-books');
			$oc->setMetadataDriverImpl($ad::create(__DIR__ . '/modules/Models'));
		}

		private function registerAnnotations () {

			/** @var AnnotationDriver $ad */
			$ad = $this->annotationDriver;
			$ad::registerAnnotationClasses();
		}

		private function createDocumentManager () {

			/** @var DocumentManager $dm */
			$dm =$this->documentManager;
			/** @var Connection $connection */
			$connection = $this->connection;
			/** @var Configuration $configuration */
			$configuration = $this->odmConfiguration;

			$this->dm = $dm::create($connection, $configuration);
		}

		//TODO [DB] make wrappers for calls
		public function persist ($item) {
			$this->dm->persist($item);
		}

		public function flush () {
			$this->dm->flush();
		}
	}