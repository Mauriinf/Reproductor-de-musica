<?php
include 'config.php';
  include 'includes/db_con.php';

	if ( !empty($_POST)) {

		$tituloError = null;
		$archivoError = null;
		$imagenError = null;
		$generoError = null;
		$interpreteError = null;

		$titulo = $_POST['titulo'];
		//$imagen = $_POST['imagen'];
		//$archivo = $_POST['archivo'];
		$genero = $_POST['genero'];
		$interprete = $_POST['interprete'];

		$valid = true;
		if (empty($titulo)) {
			$tituloError = 'Por favor, ingrese titulo';
			$valid = false;
		}
		$extension = end(explode(".", $_FILES['archivo']['name']));
		if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {

			if($extension=="wav" || $extension=="WAV" || $extension=="MP3" || $extension=="mp3")
			{
				
				if($extension=="wav" || $extension=="WAV")
				{
					
			    $tipo=".wav";
				}
			  else {
			    $tipo=".mp3";
			  }
		    
			}
		  else {
		    $tipo="";

		  }

			if($tipo!=""){
				$time =microtime(true);
				$micro_time=sprintf("%06d",($time - floor($time)) * 1000000);
				$date=new DateTime( date('Y-m-d H:i:s.'.$micro_time,$time) );
				$archivo = $date->format("Ymd-His-u").$tipo;
				$arch = "musicas/".$archivo;

				copy($_FILES['archivo']['tmp_name'], $arch);
				print("El archivo $archivo se guardo correctamente");

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
				print("El archivo $imagen se guardo correctamente");

			}
			else{
				$imagenError =  "El formato no es el apropiado";
				$valid = false;
			}
			
		}
		else{
			$imagenError =  "A ocurrido un error intente nuevamente";
			$valid = false;
		}


		if (empty($genero)) {
			$generoError = 'Por favor, ingrese genero';
			$valid = false;
		}
		if (empty($interprete)) {
			$interpreteError = 'Por favor, ingrese interprete';
			$valid = false;
		}

		if ($valid) {

			$stmt = $enlace->prepare("INSERT INTO canciones (titulo,imagen, archivo, idgenero, idinterprete) VALUES(?,?,?,?,?)");
			$stmt->bind_param('sssii',$titulo,$imagen,$archivo,$genero,$interprete);
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
    <div class="container" >

    			<div class="span10 offset1">
    				<div class="row">
    					<br><br>
		    			<h2>Crear Cancion</h2>
		    		</div>

	    			<form class="form-horizontal" action="CrearMusica.php" method="post"  enctype="multipart/form-data">
					  <div class="control-group <?php echo !empty($tituloError)?'error':'';?>">
					    <label class="control-label">Titulo</label>
					    <div class="controls">
					      	<input name="titulo" type="text"  placeholder="Titulo de la cancion" value="<?php echo !empty($titulo)?$titulo:'';?>">
					      	<?php if (!empty($tituloError)): ?>
					      		<span class="help-inline"><?php echo $tituloError;?></span>
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
					  <div class="control-group <?php echo !empty($archivoError)?'error':'';?>">
					    <label class="control-label">Musica</label>
					    <div class="controls">
									<input name="archivo" type="file" >
					      	<?php if (!empty($archivoError)): ?>
					      		<span class="help-inline"><?php echo $archivoError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($generoError)?'error':'';?>">
					    <label class="control-label"><a href="CrearGenero.php">Genero Nuevo</a></label>
					    <div class="controls">
					      	<select  name="genero">
										<?php
										 include 'config.php';
               							include 'includes/db_con.php';
										 $consulta = 'SELECT * FROM genero';
					  					   $resultado = mysqli_query($enlace,$consulta) or die('Algo anda mal: ' . mysqli_error());    
					  	 				    while($row = mysqli_fetch_array($resultado)){
														echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
											 }
											 
										?>
					      	</select>
					      	<?php if (!empty($generoError)): ?>
					      		<span class="help-inline"><?php echo $generoError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

						<div class="control-group <?php echo !empty($interpreteError)?'error':'';?>">
					    <label class="control-label"><a href="CrearInterprete.php">Interprete Nuevo</a></label>
					    <div class="controls">
					      	<select  name="interprete">
										
										<?php
										 include 'config.php';
               							include 'includes/db_con.php';
										 $consulta = 'SELECT * FROM interprete';
					  					   $resultado = mysqli_query($enlace,$consulta) or die('Algo anda mal: ' . mysqli_error());    
					  	 				    while($row = mysqli_fetch_array($resultado)){
														echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
											 }
											 
										?>
					      	</select>
					      	<?php if (!empty($interpreteError)): ?>
					      		<span class="help-inline"><?php echo $interpreteError;?></span>
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
