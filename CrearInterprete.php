<?php

include 'config.php';
  include 'includes/db_con.php';

	if ( !empty($_POST)) {

		$nombreError = null;
		$imagenError = null;

		$nombre = $_POST['nombre'];


		$valid = true;
		if (empty($nombre)) {
			$nombreError = 'Por favor, ingrese nombre';
			$valid = false;
		}
		$tipo="";
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

				$archivoError =  "El formato no es el apropiado";
				$valid = false;
			}
			
		}
		else{
			
			$archivoError =  "A ocurrido un error intente nuevamente";
			$valid = false;
		}



		if ($valid) {
			
			$stmt = $enlace->prepare("INSERT INTO interprete (nombre,imagen) values(?, ?)");
			$stmt->bind_param('ss',$nombre,$imagen);
			if ($stmt->execute()){
				 
					echo '<script>alert("Registrado exitosamente.")</script> ';
					echo "<script>location.href='index.php'</script>";
				} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
		}
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link   href="assest/jquery.dataTables.min.css" rel="stylesheet">

    <script src="assest/jquery-3.1.1.min.js"></script>
    <script src="assest/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body background="cabe.jpg">
		<?php include_once("includes/header.php"); ?>
    <div class="container">

    			<div class="span10 offset1">
    				<div class="row">
    					<br><br>
		    			<h3>Crear nuevo Interprete</h3>
		    		</div>

	    			<form class="form-horizontal" action="CrearInterprete.php" method="post"  enctype="multipart/form-data">
					  <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
					    <label class="control-label">Nombre</label>
					    <div class="controls">
					      	<input name="nombre" type="text"  placeholder="Nombre del interprete" value="<?php echo !empty($nombre)?$nombre:'';?>">
					      	<?php if (!empty($nombreError)): ?>
					      		<span class="help-inline"><?php echo $nombreError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($imagenError)?'error':'';?>">
					    <label class="control-label">Imagen o Foto</label>
					    <div class="controls">
					      	<input name="imagen" type="file" >
					      	<?php if (!empty($imagenError)): ?>
					      		<span class="help-inline"><?php echo $imagenError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Registrar</button>
						  <a class="btn" href="index.php">Retornar</a>
						</div>
					</form>
				</div>

    </div>
  </body>
</html>
