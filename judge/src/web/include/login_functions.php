<?php

	function pwGen($password,$md5ed=False)
	{
		if (!$md5ed) $password=md5($password);
		$salt = sha1(rand());
		$salt = substr($salt, 0, 4);
		$hash = base64_encode( sha1($password . $salt, true) . $salt ); 
		return $hash; 
	}
	
	function isOldPW($password)
	{
		for ($i=strlen($password)-1;$i>=0;$i--)
		{
			$c = $password[$i];
			if ('0'<=$c && $c<='9') continue;
			if ('a'<=$c && $c<='f') continue;
			if ('A'<=$c && $c<='F') continue;
			return False;
		}
		return True;
	}

	function pwCheck($password,$saved)
	{
		if (isOldPW($saved)) {
			$mpw = md5($password);
			if ($mpw==$saved) return True;
			else return False;
		}
		$svd=base64_decode($saved);
		$salt=substr($svd,20);
		$hash = base64_encode( sha1(md5($password) . $salt, true) . $salt );
		if (strcmp($hash,$saved)==0) return True;
		else return False;
	}

	function check_login($user_id,$password,$pdo,$ip){
		session_destroy();
		session_start();
		$sql=$pdo->prepare("INSERT INTO `loginlog` VALUES(?,?,?,NOW())");
		$sql->execute(array($user_id,'web',$ip));
		
		$sql=$pdo->prepare("SELECT `user_id`,`password` FROM `users` WHERE `user_id`=?");
		$sql->execute(array($user_id));
		$result=$sql->fetchAll();
		if ($result && pwCheck($password,$result[0]['password'])) {
			$user_id=$result[0]['user_id'];
			return $user_id;
		}
		return false; 
	}
?>
