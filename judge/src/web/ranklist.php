<?php 
	session_start();
	//Vars
	require_once('./include/setting_oj.inc.php');
	require_once('./include/memcache.php');
	require_once('./include/safe_func.inc.php');

	//Prepares
	$p=isset($_GET['p']) ? $_GET['p'] : 1;
	if($p<1){$p=1;}
	$front=intval(($p-1)*$PAGE_ITEMS);
	$keyword = isset($_GET["keyword"])? ($_GET["keyword"]."%") : false;
	if ($keyword) {
		$keyword = $pdo->quote($keyword);
		$keywordSQL = "WHERE user_id LIKE {$keyword}";
	} else {
		$keywordSQL = "";
	}

	if($OJ_MEMCACHE){
			$sql="select * from users {$keywordSQL} order by solved desc limit $front,$PAGE_ITEMS";
			$userList=mysql_query_cache($sql,false,60*60);
			$userCount=count($userList);
			$sql="select COUNT(*) as count from users {$keywordSQL}";
			$result = mysql_query_cache($sql);
			$totalCount=$result[0];
			$totalCount = $totalCount['count'];
	}
	else
	{
		$sql=$pdo->prepare("select * from users {$keywordSQL} order by solved desc limit $front,$PAGE_ITEMS");
		$sql->execute();
		$userList=$sql->fetchAll(PDO::FETCH_ASSOC);
		$userCount=count($userList);
		$sql=$pdo->prepare("select COUNT(*) as count from users {$keywordSQL}");
		$sql->execute();
		$totalCount=$sql->fetch(PDO::FETCH_ASSOC);
		$totalCount = $totalCount['count'];
	}
	$pageCnt = ceil((double)$totalCount / $PAGE_ITEMS);
	//Page Includes
	require("./pages/ranklist.php");
?>
