<?php
/**
 * 数据库连接类
 */
class DBConnection {
    private $configure;

    public function __construct() {
        // 获取数据库配置项
        $this->configure = \Configurator::getConfig('DB', 'default');
    }

    public function getConnection() {
        $config = $this->configure;
        // Data Source Name
        $dsn = "mysql:host={$config['host']}; port={$config['port']}; dbname={$config['dbname']}; charset={$config['charset']}";
        $options = array(
            // 设置连接超时时间，单位秒
            PDO::ATTR_TIMEOUT => 3,
            // 设置错误模式
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // 关闭持久化连接
            PDO::ATTR_PERSISTENT  => false,
            // 设置mysql客户端想要的字符集，避免查询的数据乱码
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}",
        );

        try {
            $connetion = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            // TODO + log记录数据库连接错误信息
            return false;
        }

        return $connetion;
    }
}