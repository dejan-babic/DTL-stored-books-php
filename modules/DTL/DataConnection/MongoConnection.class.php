<?php

	namespace DTL;

	class MongoConnection implements IDataConnection{

		private $mongoConfig;

		public function __construct ($dc) {

			$this->configuration = $dc[DC_CONFIG_KEY];
			$this->mongoConfig = $this->configuration->mongodb;
		}

		public function composeServerUrl () {

			$mc = $this->mongoConfig;
			$url = "mongodb://{$mc->username}:{$mc->password}@{$mc->host}:{$mc->port}/{$mc->database}";
			return $url;
		}
	}