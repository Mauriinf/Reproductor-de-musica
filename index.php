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
    		<div class="row">
          <br><br>
    			<h1>Mis Canciones</h1>
          <br>
    		</div>
  			<div class="row">
  				
  				<table border='0'style="font-size: 20px;">
  		             
            <thead> <tr >
        <th width='15%'>Titulo</th> 
        <th width='15%'>Imagen</th> 
       <th width='15%'>Genero</th> 
        <th width='15%'>Interprete</th> 
        <th width='15%'>Escuchar</th> 
        <th width='15%'>Acciones</th> 
        </tr> 
    </thead> 
  		              <tbody>
  		              <?php
  					   include 'config.php';
               include 'includes/db_con.php';
               $consulta = 'SELECT canciones.id, canciones.titulo, canciones.imagen as canimagen, canciones.archivo, genero.nombre as genero, genero.imagen as imggenero, interprete.nombre as interprete, interprete.imagen as imagen   FROM canciones, genero, interprete where canciones.idgenero = genero.id and canciones.idinterprete = interprete.id ';
  					   $resultado = mysqli_query($enlace,$consulta) or die('Algo anda mal: ' . mysqli_error());    
  	 				    while($row = mysqli_fetch_array($resultado)){
  						   		echo '<tr>';
  							   	echo '<td>'. $row['titulo'] . '</td>';
                    echo '<td><img src="imagenes/'. $row['canimagen'] . '" alt="" width="50" />  </td>';
  							   	echo '<td>'. $row['genero'] . '</td>';
  							   echo '<td>'. $row['interprete'] . '</td>';
                    echo '<td> <audio controls>  <source src="musicas/'. $row['archivo'] .'" type="audio/mpeg"> No jala la cancion. </audio> </td>';
  							   	echo '<td width=250>';
  							   	echo '&nbsp;';
  							   	echo '<a class="btn btn-warning" href="ModificarCanciones.php?id='.$row['id'].'">Modificar</a>';
  							   	echo '&nbsp;';
  							   	echo '<a class="btn btn-danger" href="EliminarCanciones.php?id='.$row['id'].'">Eliminar</a>';
  							   	echo '</td>';
  							   	echo '</tr>';
  					   }
  					   
  					  ?>
  				      </tbody>
  	            </table>
      	</div>

    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
      } );
    </script>

  </body>
</html>
