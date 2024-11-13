<?php
class Database {
    private static $dbName = 'esp32_mc_db';    // Nama database
    private static $dbHost = 'localhost';      // Host default
    private static $dbUsername = 'root';       // Username default MySQL di XAMPP
    private static $dbUserPassword = ''; // Password untuk user root (ganti sesuai kebutuhan)
    private static $dbPort = '3306';             // Port MySQL yang digunakan, di sini adalah 8111
    
    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
        if (null == self::$cont) {
            try {
                // Menambahkan port ke dalam koneksi
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";port=" . self::$dbPort . ";dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
                self::$cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection Error: ' . $e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect() {
        self::$cont = null;
    }
}
