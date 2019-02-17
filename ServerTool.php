<?php
/**
 * Server工具类
 */
class ServerTool
{
    /**
     * 获取客户端IP
     */
    public static function getClientIp() {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $client_ip = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $client_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // 获取X-Forwarded-For中第一个非unknown的有效IP
            $ip_arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ip_arr as $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown') {
                    $client_ip = $ip;
                    break;
                }
            }
        } else {
            $client_ip = '0.0.0.0';
        }

        return $client_ip;
    }

    /**
     * 返回json格式的字符串
     * @param  integer  $errcode
     * @param  string   $msg
     * @param  boolean  $data
     * @return string
     */
    public static function sendJsonResponse($errcode, $msg, $data = false) {
        $response_json = array(
            'errcode' => $errcode,
            'msg' => $msg,
        );
        if ($data !== false) {
            $response_json['data'] = $data;
        }

        echo json_encode($response_json);
        die();
    }
}