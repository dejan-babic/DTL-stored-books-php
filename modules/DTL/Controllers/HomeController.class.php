<?php

	namespace DTL;

	class HomeController implements IController {

		protected $dataManager;

		public function __construct ($dc) {
			$this->dataManager = $dc[DC_DTL_DOCUMENT_MANAGER_KEY];
		}

		public function index () {
			$b = new Book('final', array('DB'));
			$dm = $this->dataManager;
			$dm->persist($b);
			$dm->flush();
		}

		public function help () {
			// TODO: Implement help() method.
		}

		public function all () {
			// TODO: Implement all() method.
		}

		public function get () {
			// TODO: Implement get() method.
		}

		public function set () {
			// TODO: Implement set() method.
		}

		public function update () {
			// TODO: Implement update() method.
		}

	}