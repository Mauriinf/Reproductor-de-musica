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

		$tituloError = null;
		$archivoError = null;
		$imagenError = null;
		$generoError = null;
		$interpreteError = null;

		$titulo = $_POST['titulo'];
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
		

			}
			else{
				$archivoError =  "El formato no es el apropiado";
				$valid = false;
			}
			
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
		
			


		if (empty($genero)) {
			$generoError = 'Por favor, ingrese genero';
			$valid = false;
		}
		if (empty($interprete)) {
			$interpreteError = 'Por favor, ingrese interprete';
			$valid = false;
		}

		if ($valid) {
			

			if( $_FILES['archivo']['name'] &&  $_FILES['imagen']['name']){
				$stmt = $enlace->prepare(" UPDATE canciones  set titulo = ?, archivo = ?, imagen = ?, idgenero = ?, idinterprete = ?  WHERE id = ?");
				$stmt->bind_param('sssiii', $titulo,$archivo,$imagen,$genero,$interprete, $_GET['id']);
				if($stmt->execute()){
					echo '<script>alert("Actualizado exitosamente.")</script> ';
					echo "<script>location.href='index.php'</script>";
				}
					

			}else{
				if( $_FILES['archivo']['name'] ){
					$stmt = $enlace->prepare("UPDATE canciones  set titulo = ?, archivo = ?, idgenero = ?, idinterprete = ?  WHERE id = ?");
					$stmt->bind_param('ssiii', $titulo,$archivo,$genero,$interprete, $_GET['id']);
					if($stmt->execute()){
						echo '<script>alert("Actualizado exitosamente.")</script> ';
						echo "<script>location.href='index.php'</script>";
					}
					
				}else{
					if( $_FILES['imagen']['name'] ){
						$stmt = $enlace->prepare("UPDATE canciones  set titulo = ?, imagen = ?, idgenero = ?, idinterprete = ?  WHERE id = ?");
						$stmt->bind_param('ssiii', $titulo,$imagen,$genero,$interprete, $_GET['id']);
						if($stmt->execute()){
							echo '<script>alert("Actualizado exitosamente.")</script> ';
							echo "<script>location.href='index.php'</script>";
						}

						
					}else{
						$stmt = $enlace->prepare("UPDATE canciones  set titulo = ?, idgenero = ?, idinterprete = ?  WHERE id = ?");
						$stmt->bind_param('siii', $titulo,$genero,$interprete, $_GET['id']);
						if($stmt->execute()){
							echo '<script>alert("Actualizado exitosamente.")</script> ';
							echo "<script>location.href='index.php'</script>";
						}
						
					}
				}
				
			}

		
			
			
		}
	} else {
		
		$query = "select * from canciones where id = '$id'";
		$rs = mysqli_query($enlace,$query) or die('Credenciales incorrectas: ' . mysqli_error($enlace));
				

		if(mysqli_num_rows($rs)>=1){
			
				$datos = $rs->fetch_row();
				$titulo = $datos[1];
				$archivo = $datos[2];
				$imagen = $datos[3];
				$genero = $datos[4];
				$interprete = $datos[5];
				

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
    			<h3>Mofificar datos de musica</h3>
    		</div>

			<form class="form-horizontal" action="ModificarCanciones.php?id=<?php echo $id?>" method="post"   enctype="multipart/form-data">
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
					<label class="control-label">Archivo</label>
					<div class="controls">
							<input name="archivo" type="file" placeholder="Correo Electrónico">
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
				  <button type="submit" class="btn btn-warning">Modificar</button>
				  <a class="btn" href="index.php">Retornar</a>
				</div>
			</form>
		</div>
    </div>
  </body>
</html>
