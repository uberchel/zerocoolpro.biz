<?php

$config['db']['host'] = 'localhost';
$config['db']['port'] = '3306';
$config['db']['username'] = 'admin_fors';
$config['db']['password'] = 'vJzI8lu9ow';
$config['db']['dbname'] = 'admin_fb';

$config['debug'] = false;
$config['superAdmins'] = '1';

 $config['cache']['enabled'] = true;
$config['cache']['frontend'] = 'Core';
$config['cache']['frontendOptions'] = array(
    'caching'                   => true,
    'automatic_serialization'   => true,
    'lifetime'                  => 3600,
    'cache_id_prefix'           => 'xf_'
); 
$config['cache']['backend'] = 'Memcached';
$config['cache']['backendOptions'] = array(
    'backendOptions' => array(
        'compression' => false,
        'servers' => array(
            array(
                // your memcached server ip /address
                'host' => 'localhost',
                
                // memcached port
                'port' => 11211,
            )
        )
    )
); 
