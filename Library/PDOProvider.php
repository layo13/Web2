<?php

namespace Library;

class PDOProvider {

	private static $dbname = 'web2';
	private static $host = 'localhost';
	private static $user = 'root';
	private static $password = '';
	private static $instance = NULL;

	/**
	 * 
	 * @return \PDO Connexion
	 */
	public static function getInstance() {
        if (strpos(dirname(__FILE__), "Applications")) {
            self::$password = 'root';
        }

		if (self::$instance == NULL) {
			try {
				self::$instance = new \PDO('mysql:dbname=' . self::$dbname . ';host=' . self::$host, self::$user, self::$password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
			} catch (\PDOException $e) {
				echo 'Connexion echouee : ' . $e->getMessage();
			}
		}
		self::$instance->query("SET CHARACTER SET utf8");
		return self::$instance;
	}

}
