<?php
const LOG_FILE = __DIR__ . '/error.log';

class Database
{
    private static $instance = null;
    private $conn;
    private $logFile = LOG_FILE;

    private function __clone() {}

    public function __wakeup() {}

    private function __construct()
    {
        if (!$this->checkInternetConnection()) {
            self::logError('Không có kết nối Internet.');
            $this->redirectToOfflinePage();
        }

        try {
            require_once 'config.php';
            if (!defined('DB_HOST') || !defined('DB_NAME') || !defined('DB_USERNAME') || !defined('DB_PASSWORD')) {
                throw new Exception('Cấu hình cơ sở dữ liệu không hợp lệ.');
            }

            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            self::logError('Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage());
            $this->redirectWithError();
        } catch (Exception $e) {
            self::logError('Lỗi cấu hình cơ sở dữ liệu: ' . $e->getMessage());
            $this->redirectWithError();
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setLogFile($path)
    {
        $this->logFile = $path;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }

    public static function logError($message)
    {
        $logFile = self::$instance ? self::$instance->logFile : LOG_FILE;
        $logMessage = '[' . date('s:i:H d-m-Y' ) . '] ' . $message . "\n";
        error_log($logMessage, 3, $logFile);

        if (defined('DEBUG') && DEBUG) {
            echo htmlspecialchars($logMessage);
        }
    }

    public function execute($query, $params = array())
    {
        try {
            if (is_null($this->conn)) {
                throw new Exception('Không có kết nối PDO.');
            }

            $stmt = $this->conn->prepare($query);
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $stmt->bindValue(':' . $key, $value);
                }
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            self::logError('Lỗi truy vấn: ' . $e->getMessage());
            return null;
        } catch (Exception $e) {
            self::logError('Lỗi thực thi câu lệnh: ' . $e->getMessage());
            return null;
        }
    }

    public function fetch($query, $params = array())
    {
        $stmt = $this->execute($query, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }

    public function fetchAll($query, $params = array())
    {
        $stmt = $this->execute($query, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    private function checkInternetConnection()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        } else {
            return false;
        }
    }

    private function redirectWithError()
    {
        header('Location: ?url=404');
        exit;
    }

    private function redirectToOfflinePage()
    {
        header('Location: ?url=offline');
        exit;
    }
}
?>
