<?php
	class connection{
		protected $con;
		
		public function __construct()
		{
			$this->con = new mysqli("localhost", "root", "", "fullstack");

			if ($this->con->connect_errno) {
				die("Failed: " . $this->con->connect_error);
			}
		}
	}
?>