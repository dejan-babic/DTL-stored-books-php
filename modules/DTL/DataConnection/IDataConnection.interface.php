<?php

	namespace DTL;

	interface IDataConnection {
		public function __construct($dc);
		public function composeServerUrl();
	}