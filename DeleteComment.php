<?php
$page = "DeleteComment";
include "Header.php";

if(isset($_POST['id'])) { $id = $_POST['id']; } elseif(isset($_GET['id'])) { $id = $_GET['id']; } else { $id = 0; }
if(isset($_POST['back'])) { $back = $_POST['back']; } elseif(isset($_GET['back'])) { $back = $_GET['back']; } else { $back = 0; }

$database->database_query("DELETE FROM phps_profilecomments WHERE profilecomment_id=".$id);

if ($back) {
    header("Location: ".$url->url_create('profile',$back));
    die();
} else {
    header("Location: Home.php");
    die();
}

?>