<?php
/**
 * curl工具类
 * 说明：
 * (1). CURLOPT_HTTPHEADER 值为一维数组格式
 * (2). CURLOPT_POSTFIELDS 值可以是字符串也可以是数组，如果是数组，
 *      则"Content-Type"头被自动设置成"multipart/form-data"，发送
 *      文件时，CURLOPT_POSTFIELDS必须为数组
 * (3). 发送文件时，文件名必须是文件完整路径，且需要使用"@"前缀
 * (4). 如果使用代理proxy，则需要设置代理相关的参数
 * 
 */
class CurlTool
{
    /**
     * http|https POST请求
     * @param  string  $url
     * @param  mixed   $params
     * @param  array   $header
     * @param  integer $timeout
     * @param  array   $extend
     * @return array
     */
    public static function httpPost($url, $params, $header = array(), $timeout = 300, $extend = array()) {
        // 开启会话
        $ch = curl_init();
        if (is_array($params)) {
            $params = http_build_query($params);
        }
        if (!empty($header)) {
            // 设置请求头(一维数组)
            // array('Content-Type:application/x-www-form-urlencoded;charset=utf-8', 'Content-Length:100') 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        // 请求的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 不返回响应头
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 发送POST请求
        curl_setopt($ch, CURLOPT_POST, 1);
        // POST请求体
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // 请求超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 请求结果保存到变量而不直接输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 允许请求的URL发生重定向
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // 允许重定向的次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        // 当发生重定向时，自动设置请求的Referer字段
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

        if (!empty($extend)) {
            self::curlExtend($ch, $extend);
        }

        // 执行会话返回结果
        $res = curl_exec($ch);
        // 获取会话详情
        $info = curl_getinfo($ch);
        // 获取错误信息
        $info['curl_error'] = curl_error($ch);
        // 获取错误码
        $info['curl_errno'] = curl_errno($ch);
        // 关闭会话
        curl_close($ch);

        return array($info, $res);
    }

    /**
     * http|https GET请求
     * @param  string  $url
     * @param  array   $params
     * @param  array   $header
     * @param  integer $timeout
     * @param  array   $extend
     * @return array
     */
    public static function httpGet($url, $params = array(), $header = array(), $timeout = 300, $extend = array()) {
        // 开启会话
        $ch = curl_init();
        if (!empty($params)) {
            // 将查询参数拼接到url后面
            $url .= "?".http_build_query($params);
        }
        if (!empty($header)) {
            // 设置请求头(一维数组)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        // 请求的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 不返回响应头
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 请求超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 请求结果保存到变量而不直接输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 允许请求的URL发生重定向
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // 允许重定向的次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        // 当发生重定向时，自动设置请求的Referer字段
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

        if (!empty($extend)) {
            self::curlExtend($ch, $extend);
        }

        // 执行会话返回结果
        $res = curl_exec($ch);
        // 获取会话详情
        $info = curl_getinfo($ch);
        // 获取错误信息
        $info['curl_error'] = curl_error($ch);
        // 获取错误码
        $info['curl_errno'] = curl_errno($ch);
        // 关闭会话
        curl_close($ch);

        return array($info, $res);
    }

    /**
     * 下载文件
     * @param  string  $url
     * @param  string  $save_path
     * @param  array   $header
     * @param  integer $timeout
     * @param  array   $extend
     * @return array
     */
    public static function fileDownload($url, $save_path, $header = array(), $timeout = 600, $extend = array()) {
        // 只读模式打开文件句柄
        $fp = fopen($save_path, 'w');
        // 开启会话
        $ch = curl_init();
        if (!empty($header)) {
            // 设置请求头
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        // 请求的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 不返回响应头
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 请求超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 设置文件的输出路径，默认是STDOUT(浏览器)
        curl_setopt($ch, CURLOPT_FILE, $fp);
        // 设置返回数据直接输出到指定的文件路径
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        // 允许请求的URL发生重定向
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // 允许重定向的次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        // 当发生重定向时，自动设置请求的Referer字段
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

        if (!empty($extend)) {
            self::curlExtend($ch, $extend);
        }

        // 执行会话
        curl_exec($ch);
        // 获取会话详情
        $info = curl_getinfo($ch);
        // 获取错误信息
        $info['curl_error'] = curl_error($ch);
        // 获取错误码
        $info['curl_errno'] = curl_errno($ch);
        // 关闭会话
        curl_close($ch);

        return $info;
    }

    /**
     * 文件发送
     * @param  string  $url
     * @param  string  $filename
     * @param  array   $header
     * @param  string  $default_name
     * @param  integer $timeout
     * @param  array   $extend
     * @return array
     */
    public static function fileSend($url, $filename, $header = array(), $default_name = 'file', $timeout = 600, $extend = array()) {
        // 开启会话
        $ch = curl_init();
        if (!empty($filename)) {
            // POST请求体
            $params = array(
                $default_name => '@'.$filename,
            );
        }
        if (!empty($header)) {
            // 设置请求头
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        // 请求的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 不返回响应头
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 发送POST请求
        curl_setopt($ch, CURLOPT_POST, 1);
        // 设置POST请求体
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // 请求超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 请求结果保存到变量而不直接输出到浏览器
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (!empty($extend)) {
            self::curlExtend($ch, $extend);
        }

        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $info['curl_error'] = curl_error($ch);
        $info['curl_errno'] = curl_errno($ch);

        return array($info, $res);
    }

    /**
     * https是否校验SSL证书
     * @param  source $ch
     * @param  array  $extend
     */
    private static function curlExtend($ch, $extend = array()) {
        if (!empty($extend['user_agent'])) {
            // 设置请求头中"User-Agent"字段的值
            curl_setopt($ch, CURLOPT_USERAGENT, $extend['user_agent']);
        }
        if (!empty($extend['ssl_verifypeer'])) {
            // 对等证书校验(Peer’s Certificate)
            // CURLOPT_SSL_VERIFYPEER = 1 开启校验SSL证书
            // CURLOPT_SSL_VERIFYPEER = 0 禁止校验SSL证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $extend['ssl_verifypeer']);
        }
        if (!empty($extend['ssl_verifyhost'])) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $extend['ssl_verifyhost']);
        }
        if (!empty($extend['ssl_capath'])) {
            // CA证书的存储路径
            curl_setopt($ch, CURLOPT_CAPATH, $extend['ssl_capath']);
        }
        if (!empty($extend['http_proxy'])) {
            // 开启http代理通道
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            // 设置代理服务器的IP和端口号，格式为"ip:port"
            curl_setopt($ch, CURLOPT_PROXY, $extend['http_proxy']);

            if (!empty($extend['proxy_userpwd'])) {
                // 设置代理服务器登录账号，格式为"user:password"
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $extend['proxy_userpwd']);
            }
        }
    }
}