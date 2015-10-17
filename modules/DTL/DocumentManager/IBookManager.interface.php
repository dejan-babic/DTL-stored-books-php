<?php

	namespace DTL;

	interface IBookManager {
		public function getBook($id);
		public function getAllBooks();
		public function updateBook($id);
		public function updateAllBooks();
		public function deleteBook($id);
		public function deleteAllBooks($id);
		public function setBook();
	}