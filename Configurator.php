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
        $path = dirname(__FILE__).'/configure.inc.php';
        // 判断配置文件是否存在
        if (is_file($path)) {
            self::$config = include $path;
        } else {
            throw new \Exception("找不到配置文件", 1);
        }
    }

    /**
     * 获取配置信息
     * @param  string $key
     */
    public static function getConfig($key) {
        // 判断是否缓存配置信息
        if (isset(self::$conf[$key])) {
            return self::$conf[$key];
        } else {
            self::loadFile();
            if (isset(self::$config[$key])) {
                self::$conf[$key] = self::$config[$key];
                return self::$config[$key];
            } else {
                throw new \Exception("没有配置项", 1);
            }
        }
    }

    /**
     * 获取子配置信息
     * @param  string $key
     * @param  string $subkey
     */
    public static function getSubConfig($key, $subkey) {
        if (isset(self::$subconf[$key][$subkey])) {
            return self::$subconf[$key][$subkey];
        } else {
            self::loadFile();
            if (isset(self::$config[$key][$subkey])) {
                self::$subconf[$key][$subconf] = self::$config[$key][$subkey];
                return self::$config[$key][$subkey];
            } else {
                throw new \Exception("没有子配置项", 1);
            }
        }
    }
}