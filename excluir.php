<?php 

require 'index.php';

$id = $_GET['id'];

if ($id) {
	$sql = $pdo->prepare("DELETE FROM mensagens WHERE id = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();
}

header('Location: index.php');
exit;



?>