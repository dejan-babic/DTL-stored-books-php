<?php

	namespace DTL;

	class HomeController implements IController {

		public function index () {
			$dm = new MongoDocumentManager();
			$book = new Book('TEST', array('Dejan Babic'));
			$dm->persist($book);
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