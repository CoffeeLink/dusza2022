<?php
return array(
    'db_user'=> 'duszagfq_web_user',
    'db_password'=> 'Kortefa345',
    'db_name'=> 'duszagfq_blog_engine',
    'db_host'=> '188.6.112.177:5482',
    'jwt_secret'=> 'AMOGUS',
    'base_url' => 'http://' . $_SERVER['HTTP_HOST'] . (($_SERVER['HTTP_HOST'] == '79.139.62.213') ? '/~duszagfq' : ''),
    'permission_levels' => array(
        'EDITOR' => 1,
        'MODERATOR' => 2,
        'WEBMASTER' => 3,
    ),
);