<?php
	include 'config.php';
  include 'includes/db_con.php';
	$id = 0;

	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( !empty($_POST)) {

		$id = $_POST['id'];

		$query = "DELETE FROM canciones  WHERE idgenero = $id";
		$rs = mysqli_query($enlace,$query) or die('Credenciales incorrectas: ' . mysqli_error($enlace));
		$query = "DELETE FROM genero  WHERE id = $id";
		$rs = mysqli_query($enlace,$query) or die('Credenciales incorrectas: ' . mysqli_error($enlace));
			echo '<script>alert("Eliminado exitosamente.")</script> ';
			echo "<script>location.href='index.php'</script>";

	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
		<?php include_once("includes/header.php"); ?>
    <div class="container">
		<div class="span10 offset1">
			<div class="row">
				<br><br>
    			<h3>Eliminar genero</h3>
    		</div>

			<form class="form-horizontal" action="EliminarGenero.php" method="post">
			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
			  <p class="alert alert-error">Esta seguro de eliminar el genero ?</p>
			  <div class="form-actions">
				  <button type="submit" class="btn btn-danger">Si</button>
				  <a class="btn" href="index.php">No</a>
				</div>
			</form>
		</div>
    </div>
  </body>
</html>
