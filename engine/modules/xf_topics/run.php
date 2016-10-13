<?php

/*====================================================
Author: RooTM
------------------------------------------------------
Web-site: http://weboss.net/
=====================================================*/

if (!defined('DATALIFEENGINE')) {
    die("Hacking attempt!");
}

/*================================================================*/
   $config['db']['host'] = 'localhost'; // Сервер MySQL
   $config['db']['username'] = 'probizforum'; // Имя пользователя
   $config['db']['password'] = '3fvsxc1hmda3RFSDZV'; // Пароль
   $config['db']['dbname'] = 'probizforum'; // Имя базы данных
/*=================================================================*/

/*====================================================================================*/
   $max_topics = 10; // Максимальное количество тем
/*------------------------------------------------------------------------------------*/
   $max_topic_name = 50; // Максимальная длина названия темы
/*------------------------------------------------------------------------------------*/
   $encode_urls = 'yes'; // Кодировать URL? yes - да; no - нет
/*-------------------------------------------------------------------------------------*/
   $friendly_urls = 'yes'; // На форуме используются ЧПУ-ссылки? yes - да; no - нет
/*-------------------------------------------------------------------------------------*/
   $forum_url = 'http://forum.ws/'; // Ссылка на ваш форум
/*=====================================================================================*/

$is_change = false;

if ($config['allow_cache'] != "yes") {$config['allow_cache'] = "yes";$is_change = true;}

$xf_topics = dle_cache("xf_topics", $config['skin']);

if ($xf_topics === false) {

function encode_url($url,$encode_urls) {
if ($encode_urls == 'yes') return '/engine/go.php?url='.rawurlencode(base64_encode($url));
   else return $url;
}

    $tpl = new dle_template();
    $tpl->dir = ENGINE_DIR . '/modules/xf_topics/';
    define('TEMPLATE_DIR', $tpl->dir);

mysql_connect($config['db']['host'], $config['db']['username'], $config['db']['password']);
mysql_select_db($config['db']['dbname']);

$sql = "SELECT thread.thread_id, thread.node_id, thread.title, thread.reply_count, thread.last_post_date, thread.last_post_id, thread.last_post_user_id, thread.last_post_username, node.node_id, node.title AS forum_name FROM xf_thread as thread, xf_node as node WHERE node.node_id=thread.node_id ORDER BY thread.last_post_date DESC LIMIT 0, " . $max_topics;

   $sql = mysql_query($sql);
    
  while ($row = mysql_fetch_assoc($sql)){

if($friendly_urls == 'yes'){
 $topic_link = $forum_url.'posts/'.$row['last_post_id'].'/';
 $forum_link = $forum_url.'forums/'.urlencode($row['forum_name']).'.'.$row['node_id'].'/';
 $user_link = $forum_url.'members/'.urlencode($row['last_post_username']).'.'.$row['last_post_user_id'].'/';
    }else{
 $topic_link = $forum_url.'index.php?posts/'.$row['last_post_id'].'/';
 $forum_link = $forum_url.'index.php?forums/'.urlencode($row['forum_title']).'.'.$row['node_id'].'/';
 $user_link = $forum_url.'index.php?members/'.urlencode($row['last_post_username']).'.'.$row['last_post_user_id'].'/';
}

if( dle_strlen( $row['title'], $config['charset'] ) > $max_topic_name ) $topic_name = dle_substr( $row['title'], 0, $max_topic_name, $config['charset'] ) . " ...";
		else $topic_name = $row['title'];

        $tpl->load_template('topic.tpl');

        $tpl->set( '{user_name}', $row['last_post_username'] );
        $tpl->set( '{user_link}', encode_url($user_link,$encode_urls) );
        
        $tpl->set( '{topic_name}', $topic_name );
        $tpl->set( '{topic_link}', encode_url($topic_link,$encode_urls) );

        $tpl->set( '{forum_name}', $row['forum_name'] );
        $tpl->set( '{forum_link}', encode_url($forum_link,$encode_urls) );
        
        $tpl->set( '{reply_count}', $row['reply_count'] );

     $tpl->compile('topic');

     $xf_topics .= $tpl->result['topic'];

     $tpl->global_clear();

  }

$tpl->load_template ( 'box.tpl' );

$tpl->set ( '{xf_topics}', $xf_topics );

$tpl->set ( '{copyright}', '<div align="right" style="font-size: 9px; padding-right: 3px;">Copyright &copy; WEBoss.Net</div>' );

$tpl->compile ( 'box' );

$xf_topics = $tpl->result['box'];

$tpl->global_clear ();

    create_cache("xf_topics", $xf_topics, $config['skin']);
    
}

echo  $xf_topics;

if ($is_change) $config['allow_cache'] = false;

?>
