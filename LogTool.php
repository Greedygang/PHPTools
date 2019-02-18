<?php
/**
 * Log工具类
 * 说明：定义了4种级别的日志，相同级别的日志在相同子目录
 * (1) 日志文件命名格式：文件名_日期.log
 * (2) 日志内容格式：日期时间\t内容
 */
class LogTool
{
    /*定义日志级别*/
    const LOG_LEVEL_DEBUG = 0;
    const LOG_LEVEL_WARN  = 1;
    const LOG_LEVEL_ERROR = 2;
    const LOG_LEVEL_INFO  = 3;

    private static $log_level = array(
        LOG_LEVEL_DEBUG => 'debug',
        LOG_LEVEL_WARN  => 'warn',
        LOG_LEVEL_ERROR => 'error',
        LOG_LEVEL_INFO  => 'info',
    );

    // TODO + 使用时修改日志目录
    private static $log_path = './log_path';

    public static function debugLog($name, $message) {
        self::writeLog(LOG_LEVEL_DEBUG, $name, $message);
    }

    public static function warnLog($name, $message) {
        self::writeLog(LOG_LEVEL_WARN, $name, $message);
    }

    public static function errorLog($name, $message) {
        self::writeLog(LOG_LEVEL_ERROR, $name, $message);
    }

    public static function infoLog($name, $message) {
        self::writeLog(LOG_LEVEL_INFO, $name, $message);
    }

    private static function writeLog($level, $name, $message) {
        // 当前日期
        $date = date('Ymd');
        // 文件命名格式
        $file_name = $name.'_'.$date.'log';
        // 文件完整路径
        $file_path = $log_path.'/'.$log_level[$level];
        if (!is_dir($file_path)) {
            // 创建子目录
            mkdir($file_path, 0777, true);
        }
        
        file_put_contents($file_path.'/'.$file_name, date('Y-m-d H:i:s')."\t".$message."\n", FILE_APPEND|LOCK_EX);
    }
}