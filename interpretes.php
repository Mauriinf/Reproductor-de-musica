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

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
    		<div class="row">
          <br><br>
    			<h3>Interpretes</h3>
    		</div>
  			<div class="row">
  		

  				<table class="table table-striped" id="example">
  		              <thead>
  		                <tr>
  		                  <th>Nombre</th>
                        <th>Imagen</th>
  		                  <th>Acción</th>
  		                </tr>
  		              </thead>
  		              <tbody>
  		              <?php
  					   
  include 'config.php';
  include 'includes/db_con.php';
  					   $consulta = 'SELECT * FROM interprete';
               $resultado = mysqli_query($enlace,$consulta) or die('Algo anda mal: ' . mysqli_error());    
                while($row = mysqli_fetch_array($resultado)){
  						   		echo '<tr>';
  							   	echo '<td>'. $row['nombre'] . '</td>';
                    echo '<td><img src="imagenes/'. $row['imagen'] . '" alt="" width="50" />  </td>';
  							   
  							   	echo '<td width=250>';
  							   	echo '&nbsp;';
  							   	echo '<a class="btn btn-warning" href="ActualizarGenero.php?id='.$row['id'].'">Modificar</a>';
  							   	echo '&nbsp;';
  							   	echo '<a class="btn btn-danger" href="EliminarGenero.php?id='.$row['id'].'">Eliminar</a>';
  							   	echo '</td>';
  							   	echo '</tr>';
  					   }
  					   Database::disconnect();
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
