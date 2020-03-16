<?php
require_once('setting_oj.inc.php');
global $memcache;
if ($OJ_MEMCACHE){
    $memcache = new Memcache;
    $memcache->connect($OJ_MEMSERVER,  $OJ_MEMPORT);
    if(isset($_GET['reset'])&&$_GET['reset']=='y'){
        $memcache->flush();
    }
}
function getCache($key) {
    global $memcache;
    return ($memcache) ? $memcache->get($key) : false;
}

function setCache($key, $object, $timeout = 60) {
    global $memcache;
    return ($memcache) ? $memcache->set($key,$object,MEMCACHE_COMPRESSED,$timeout) : false;
}

function mysql_query_cache($sql, $linkIdentifier = false,$timeout = 5){
    global $OJ_NAME,$OJ_MEMCACHE,$pdo;
    if (!($cache = getCache(md5($OJ_NAME.$_SERVER['HTTP_HOST']."mysql_query" . $sql)))) {
        $cache = false;
        $tmp=$pdo->prepare($sql);
        $tmp->execute();
        $cache=$tmp->fetchAll(PDO::FETCH_ASSOC);
        if (!setCache(md5($OJ_NAME.$_SERVER['HTTP_HOST']."mysql_query" . $sql), $cache, $timeout)) {
            if($OJ_MEMCACHE) {
                echo "memcache not start";
                exit(0);
            }
        }
    }
    return $cache;
}
?>