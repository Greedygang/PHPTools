<?php
/**
 * Redis连接类
 */
class RedisConnection
{
    private $redis;
    private $configure;

    public function __construct() {
        // 获取数据库配置项
        $this->configure = \Configurator::getConfig('REDIS', 'master');
    }

    public function getConnection() {
        $config = $this->configure;
        try {
            $this->redis = new Redis();
            $this->redis->connect($config['host'], $config['port'], $config['timeout']);
        } catch (\Exception $e) {
            // TODO + log
            return false;
        }

        $this->redis->auth($config['auth']);
        $this->redis->select($config['database']);

        return $this->redis;
    }
}