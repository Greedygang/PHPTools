<?php
/**
 * 配置文件
 */
return array(
    /*数据库配置项*/
    'DB' => array(
        'default' => array(
            'driver'      => 'mysql',
            'host'        => '10.142.98.226',
            'port'        => '2216',
            'username'    => 'activity',
            'password'    => '37ae6d774815ec45',
            'charset'     => 'utf8mb4',
            'database'    => 'activity',
            'persistent'  => false,
            'unix_socket' => '',
            'options'     => array(),
        ),
    ),

    /*redis配置项*/
    'REDIS' => array(
        'master' => array(
            'host'       => '10.208.50.51',
            'port'       => 1309,
            'timeout'    => 10,
            'auth'       => '732038ea78f86345',
            'database'   => 0,
            'persistent' => false,
            'reconnect'  => 20,
        ),
        'slave' => array(
            'host'       => '10.208.50.50',
            'port'       => 1309,
            'timeout'    => 10,
            'auth'       => '732038ea78f86345',
            'database'   => 0,
            'persistent' => false,
            'reconnect'  => 20,
        ),
    ),
);