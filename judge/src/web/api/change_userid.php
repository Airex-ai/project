<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 18-9-10
 * Time: 上午10:01
 */
	session_start();
	$ON_ADMIN_PAGE="Yap";
	require_once("../include/setting_oj.inc.php");
	require_once("../include/login_functions.php");
	require_once("../include/user_check_functions.php");

	if(!isset($_SESSION['SessionAuth']) || !isset($_POST['pageauth'])) {
		exit("Auth Failed");
	}
	if($_SESSION['SessionAuth'] != $_POST['pageauth']) {
		echo "Auth failed";
		exit(0);
	}

	// Make a standalone privilege to manage password? weird.
	if (!havePrivilege("SUPERUSER") && !isset($_POST["old_id"]) && !isset($_POST["new_id"])) {
        echo "Auth failed";
        exit("403");
	}

    $old_id=trim($_POST['old_id']);
	$new_id=$_POST['new_id'];


	if (get_magic_quotes_gpc ()) {
        $old_id= stripslashes ($old_id);
        $new_id= stripslashes ($new_id);
	}

    $sql=$pdo->prepare("	SELECT *  from `users` WHERE `user_id`=?");
    $sql->execute(array($old_id));
    $result = $sql->fetchAll();
    if(count($result)){
        try{
            $sql=$pdo->prepare("	UPDATE `mail` SET `to_user`=? WHERE `to_user`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `news` SET `user_id`=? WHERE `user_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `privilege` SET `user_id`=? WHERE `user_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `reply` SET `author_id`=? WHERE `author_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `solution` SET `user_id`=? WHERE `user_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `topic` SET `author_id`=? WHERE `author_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `users` SET `user_id`=? WHERE `user_id`=?");
            $sql->execute(array($new_id,$old_id));
            $sql=$pdo->prepare("	UPDATE `team_user` SET `user_id`=? WHERE `user_id`=?");
            $sql->execute(array($new_id,$old_id));

            echo "<script language='javascript'>\n";
            echo "alert('success');\n";
            echo "history.go(-1);\n";
            echo "</script>";
        }
        catch (PDOException $e)
        {
            echo "<script language='javascript'>\n";
            echo "alert({$e->getMessage()});\n";
            echo "history.go(-1);\n";
            echo "</script>";
        }
    }
    else{
        echo "<script language='javascript'>\n";
        echo "alert('No such user');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
?>
