<?php
/**
 * 配置文件读取类
 * 说明：
 * (1) 加载配置文件,缓存加载过的配置
 */
class Configurator
{
    // 保存配置文件
    private static $config;
    // 缓存配置信息
    private static $conf = [];
    // 缓存子配置信息
    private static $subconf = [];

    public static function loadFile() {
        // TODO + 使用实际的配置文件路径
        $configure_file = dirname(__FILE__).'/configure.inc.php';
        // 判断配置文件是否存在
        if (is_file($configure_file)) {
            self::$config = include $configure_file;
        } else {
            throw new \Exception("找不到配置文件", 1);
        }
    }

    /**
     * 获取配置信息
     * @param  string $key
     */
    public static function getConfig($key, $subkey = false) {
        // 加载配置文件
        self::loadFile();
        if (isset(self::$config[$key])) {
            if ($subkey === false) {
                return self::$config[$key];
            } elseif (isset(self::$config[$key][$subkey])) {
                return self::$config[$key][$subkey];
            } else {
                throw new \Exception("缺少配置项{$subkey}", 1);
            }
        } else {
            throw new \Exception("缺少配置项{$key}", 1);
        }
    }
}