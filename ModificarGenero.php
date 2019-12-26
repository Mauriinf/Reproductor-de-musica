<?php
include 'config.php';
  include 'includes/db_con.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( null==$id ) {
		header("Location: index.php");
	}

	if ( !empty($_POST)) {

		$nombreError = null;
		$imagenError = null;

		$nombre = $_POST['nombre'];

		$valid = true;
		if (empty($nombre)) {
			$nombreError = 'Por favor, ingrese nombre';
			$valid = false;
		}

		
		$exten = end(explode(".", $_FILES['imagen']['name']));
		if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			if($exten=="jpg" || $exten=="JPG" || $exten=="png" || $exten=="PNG")
			{
				if($exten=="png" || $exten=="PNG")
				{
					
			    $tipo=".png";
				}
			  else {
			    $tipo=".jpg";
			  }
		    
			}
		  else {
		    $tipo="";

		  }

			if($tipo!=""){
				$time =microtime(true);
				$micro_time=sprintf("%06d",($time - floor($time)) * 1000000);
				$date=new DateTime( date('Y-m-d H:i:s.'.$micro_time,$time) );
				$imagen = $date->format("Ymd-His-u").$tipo;
				$img="imagenes/".$imagen;
				copy($_FILES['imagen']['tmp_name'], $img);
			

			}
			else{
				$imagenError =  "El formato no es el apropiado";
				$valid = false;
			}
			
		}
		
			


		

		if ($valid) {
			

			if( $_FILES['imagen']['name']){
				$stmt = $enlace->prepare(" UPDATE genero  set nombre = ?, imagen = ? WHERE id = ?");
				$stmt->bind_param('ssi', $nombre,$imagen, $_GET['id']);
				if($stmt->execute()){
					echo '<script>alert("Actualizado exitosamente.")</script> ';
					echo "<script>location.href='index.php'</script>";
				}
					

			}else{
				$stmt = $enlace->prepare("UPDATE genero  set nombre = ? WHERE id = ?");
						$stmt->bind_param('si', $nombre, $_GET['id']);
						if($stmt->execute()){
							echo '<script>alert("Actualizado exitosamente.")</script> ';
							echo "<script>location.href='index.php'</script>";
						}
				
			}

		
			
			
		}
	} else {
		
		$query = "select * from genero where id = '$id'";
		$rs = mysqli_query($enlace,$query) or die('Credenciales incorrectas: ' . mysqli_error($enlace));
				

		if(mysqli_num_rows($rs)>=1){
			
				$datos = $rs->fetch_row();
				$nombre = $datos[1];
				$imagen = $datos[2];
				

		}
		
	}
?>


<!DOCTYPE html>
<html lang="en">
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
    			<h3>Mofificar datos de genero</h3>
    		</div>

			<form class="form-horizontal" action="ModificarGenero.php?id=<?php echo $id?>" method="post"   enctype="multipart/form-data">
				<div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
					<label class="control-label">Nombre</label>
					<div class="controls">
							<input name="nombre" type="text"  placeholder="Titulo de la cancion" value="<?php echo !empty($nombre)?$nombre:'';?>">
							<?php if (!empty($nombreError)): ?>
								<span class="help-inline"><?php echo $nombreError;?></span>
							<?php endif; ?>
					</div>
				</div>
				<div class="control-group <?php echo !empty($imagenError)?'error':'';?>">
					    <label class="control-label">Imagen</label>
					    <div class="controls">
									<input name="imagen" type="file" >
					      	<?php if (!empty($imagenError)): ?>
					      		<span class="help-inline"><?php echo $imagenError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
			
			  <div class="form-actions">
				  <button type="submit" class="btn btn-warning">Modificar</button>
				  <a class="btn" href="index.php">Retornar</a>
				</div>
			</form>
		</div>
    </div>
  </body>
</html>
