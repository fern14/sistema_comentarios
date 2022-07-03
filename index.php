<?php 

try {
	$pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "root");
} catch(PDOException $e) {
	echo "ERRO ".$e->getMessage();
	exit;
}

if (isset($_POST['nome']) && empty($_POST['nome']) == false) {
	$nome = $_POST['nome'];
	$mensagem = $_POST['mensagem'];

	$sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
	$sql->bindValue(":nome", $nome);
	$sql->bindValue(":msg", $mensagem);
	$sql->execute();
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projeto Comentarios</title>
</head>
<body>
	<style type="text/css">
		body {font-family: Arial;}
		.mensagens {padding: 25px 15px;}
		fieldset {margin-bottom: 25px;}
		.enviar {padding: 10px 15px;font-size: 14px;font-family: Arial;} 
		.enviar:hover {cursor: pointer;}
		.excluir {padding: 10px 15px;background: blueviolet;color: white;display: inline-block;border-radius: 4px;text-decoration: none;font-weight: 500;}
	</style>

	<fieldset>
		<form method="POST">
			Nome: <br/>
			<input type="text" name="nome"><br/><br/>
			Mensagem: <br/>
			<textarea name="mensagem"></textarea><br/><br/>

			<input class="enviar" type="submit" value="Enviar Mensagem" name="">	
		</form>
	</fieldset>

<?php
	$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
	$sql = $pdo->query($sql);
	if ($sql->rowCount() > 0){
		foreach ($sql->fetchAll() as $mensagem):
			?>
			<div class="mensagens">
				<strong><?= $mensagem['nome'] ?></strong> <span><?= $mensagem['data_msg'] ?></span>
				<p><?= $mensagem['msg'] ?></p>
				<a class="excluir" href="excluir.php?id=<?=$mensagem['id']; ?>">Excluir</a>
				<hr>
			</div>
			<?php
		endforeach;
	} else {
		echo "Não há mensagens";
	}
?>
</body>
</html>