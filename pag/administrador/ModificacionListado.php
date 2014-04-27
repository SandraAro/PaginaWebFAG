<?php 
include ('../php/seguridad.php');
?>
<link rel="stylesheet" type="text/css" href="../css/foundation.css">
<link rel="stylesheet" type="text/css" href="../css/foundation.min.css">
<link rel="stylesheet" type="text/css" href="../css/normalize.css">
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<script type="text/javascript" src="../js/foundation.min.js">
</script><script type="text/javascript" src="../js/jquery.js">
</script><script type="text/javascript" src="../js/modernizr.js"></script>
    
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fundación Amigos Del Gesto</title>

    
    <meta name="description" content="Documentation and reference library for ZURB Foundation. JavaScript, CSS, components, grid and more." />
    
    <meta name="author" content="ZURB, inc. ZURB network also includes zurb.com" />
    <meta name="copyright" content="ZURB, inc. Copyright (c) 2013" />

    <link rel="stylesheet" href="../assets/css/templates/foundation.css" />
    <script src="../assets/js/modernizr.js"></script>
  </head>
  <body>
    

 <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <!-- Title Area -->
      <li class="name">
        <h1>
          <a href="../index.php">
            <img alt="" src="../img/amigos8.png"></img></a></li>
          </a>
        </h1>
      </li>
      <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
    </ul>
 
  <section class="top-bar-section">
      <!-- Right Nav Section -->
      <ul class="right">
       <li> <a href="#"><?php echo "Bienvenido: "; echo $_SESSION['user'];  ?></a></li>
	   <li><a href="../php/salir.php">Cerrar Sesión</a></li>
      </ul>
    </section>
  </nav>
  
  <nav class="top-bar" data-topbar>
    <section class="top-bar-section">
      <!-- Right Nav Section -->
      <ul class="left">
        <li class="divider"></li>
        <li class="has-dropdown">
          <a href="#">Inscripciones</a>
          <ul class="dropdown">
              <li><a href="adminIns.php" >Gestión Inscripción</a></li>
			  <li><a href="listarPersonas.php" >Listado de Personas</a></li>
          </ul>
        </li>
        <li class="divider"></li>
          <li class="has-dropdown">
          <a href="#">Reportes</a>
          <ul class="dropdown">
       <li class="has-dropdown">
              <a href="#" class="">Certificados</a>
              <ul class="dropdown">
                 <li class="has-dropdown">
		              <a href="#" class=""> Imprimir Certificados</a>
        		      <ul class="dropdown">
                		<li><a href="nuevoPDF/fpdf17/CertificadosAsistencia.php">Todos certificado</a></li>
		                <li><a href="certificadosindividuales.php">Certificado Individual</a></li>
		              </ul>
        	    </li>
                <li><a href="ModificacionListado.php">Modificar certificado</a></li>
              </ul>
            </li>
           <li><a href="nuevoPDF/fpdf17/ListadoA.php">Lista de inscritos</a></li>
       <li><a href="nuevoPDF/fpdf17/ListadoP.php">Ponentes</a></li>  
          </ul>
        </li>
    <li class="divider"></li>
    <li class="has-dropdown">
          <a href="#">Imágenes</a>
          <ul class="dropdown">
           <li><a href="adminevento.php?lugar=header">Header</a></li>
		   <li><a href="adminevento.php?lugar=slider">Slider</a></li>  
		   <li><a href="adminevento.php?lugar=certificado">Certificado</a></li>
          </ul>
        </li>
    <li class="divider"></li>
    <li class="has-dropdown">
    <a href="#">Términos y condiciones</a> 
      <ul class="dropdown">
           <li><a href="adminevento.php?lugar=banco">Bancos</a></li>
       <li><a href="adminevento.php?lugar=evento">Evento</a></li>
       <li><a href="adminevento.php?lugar=ponente">Ponentes</a></li>  
       <li><a href="adminevento.php?lugar=tema">Temas</a></li>  
       <li><a href="adminevento.php?lugar=dirigido">Público</a></li>  
       <li><a href="adminevento.php?lugar=fecha">Fechas</a></li>
	   <li><a href="adminevento.php?lugar=historial">Historial</a></li> 
          </ul></li>
        <li class="divider"></li>
    <li class="divider"></li>
        <li><a href="guardarUsuario.php">Usuario</a></li>
      </ul>
    </section>
  </nav>
 
</div><br>   


<div class="row">
 
 <div class="large-12 columns">
      <br>
  <div class="large-12 columns">


<div class="row">
 
 <div class="large-12 columns">

</div>

<div class="row">
  <div style="margin-top:20px;" class="large-12 columns">
    <div class="row">
      <!-- Content -->
	   <div class="large-12 columns">    
      <div class="row">
        <div class="large-12 columns">
		 
       		<h1><b>Listado de Inscripciones</h1> 
		    </div>
      </div>
	  </div>
    <!-- Three-up Content Blocks -->
 
<div class="large-12 columns"> 
    <div class="row">	
      <div class="panel">

<?php
	$cn=mysql_connect("localhost","root","")  or die("Error en conexion");
	mysql_select_db("evento")  or die("Error en base de datos : ".mysql_error());	
	$setFilter_query="select * from inscripcion join asistente on (Identificacion=idAsistente and Aprobado=1) order by idAsistente;";
	$setFilter=mysql_query($setFilter_query) or die("Error en query setFilter_query 0-2 : ".mysql_error());
	    $cantidad ="select COUNT(*) from inscripcion join asistente on (Identificacion=idAsistente and Aprobado=1) order by idAsistente;";
    $resultado = mysql_query($cantidad); 
    $total = mysql_result($resultado, 0, 0);  
    $registros_por_pagina = 10;//Cantidad de registros que se mostraran por pagina 
    $total_paginas = ceil($total / $registros_por_pagina);//Numero total de paginas 
    $pagina = intval($_GET['p']);//Pagina actual 
    $reg = intval($_GET['r']);//Pagina actual 
    if ($pagina < 1 || $pagina > $total_paginas) $pagina = 1; 
    $offset = ($pagina - 1) * $registros_por_pagina;//posicion 
    $limite = " LIMIT $offset, $registros_por_pagina";//sentencia SQL que limita los registros 
	$setFilter_query="select * from inscripcion join asistente on (Identificacion=idAsistente and Aprobado=1) order by idAsistente;";
	$setFilter=mysql_query($setFilter_query) or die("Error en query setFilter_query 0-2 : ".mysql_error());
	// tabla de inscripciones
     echo '<table width="100%" border="2" cellpadding="0" >
	       <tr>
	          <td><h6><b>Nombre</h6></td>
	          <td><h6><b>Cédula</h6></td>
	          <td><h6><b>Email</h6></td>
	          <td><h6><b>Lugar de origen</h6></td>
	          <td><h6><b>Ocupación</h6></td>
	          <td><h6><b>Fecha Inscripción</h6></td>
	          <td><h6><b>Status</h6></td>
	          <td></td>
	        </tr>';      
	        $cont=1;
	         while ($Filter_row=mysql_fetch_assoc($setFilter)){
			  if ( ($cont>$reg)&& ($cont<= ($reg+ $registros_por_pagina)) ){
	        	echo "<tr>
		          <td>".htmlentities($Filter_row['Nombre'])."</td>
		          <td>".htmlentities($Filter_row['idAsistente'])."</td>
		          <td>".htmlentities($Filter_row['Email'])."</td> 
		          <td>".htmlentities($Filter_row['Residencia'])."</td> 
		          <td>".htmlentities($Filter_row['Profesion'])."</td>
		          <td>".htmlentities($Filter_row['FechaInscripcion'])."</td> 
  		          <td>".htmlentities("Aprobado")."</td> 
		          <td> <a href=\"ModificacionIndividual.php?valor=".htmlentities($Filter_row['Nombre'])."&valor2=".htmlentities($Filter_row['idAsistente'])."\"> Modificar Certificado </a> </td> 
	              </tr>";
				  			  }
			  $cont++;
	    	}
	      echo "</table>";
		          $display_pages=10;//Numero de links para paginas que se mostraran 
  
            echo "<a title='Inicio' id='paginado' href='?p=1&r=1'> << Inicio </a> ";//Inicio 
            if ($pagina>1) echo "</a><a title='Anterior' id='paginado' href='?p=".($pagina-1)."&r=".($reg-$registros_por_pagina)."'> << Anterior </a> "; //Anterior 
  
            for ($i = $pagina; $i <= $total_paginas && $i <= ($pagina+$display_pages); $i++) { 
              if ($i == $pagina) { 
              echo "<strong id='paginado'>$i  </strong> "; 
              } 
              else { 
              echo "</a><a title='pagina $i' id='paginado' href='?p=$i&r=".($pagina*$registros_por_pagina)."'>$i</a>  "; 
              } 
            } 
  
            if (($pagina+$display_pages)< $total_paginas) echo "...";

            if ($pagina<$total_paginas) echo "<a title='Siguiente' id='paginado' href='?p=".($pagina+1)."&r=".($reg+$registros_por_pagina)."'> Siguiente >>  ";//Siguiente 
            echo "<a title='Ultimo' id='paginado' href='?p=$total_paginas&r=".($total-$registros_por_pagina)."'> Ultimo >> </a>";//Ultima pagina 



	// tabla
	mysql_close($cn);

?>


    <div id="contenido_ajax">
        
    </div>
	  </div>    
    </div>
  </div>
</div><!-- Footer -->

<footer class="row">
  <div class="large-12 columns">
    <hr>
    <div class="row">
      <div class="large-6 columns">
        <p>© Copyright Amigos Del Gesto. 2014</p>
      </div>
      <div class="large-6 columns">
        <ul class="inline-list right">
        </ul>
      </div>
    </div>
  </div>
</footer>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/templates/foundation.js"></script>
    <script>
      $(document).foundation();

      var doc = document.documentElement;
      doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
	
	  <script>
  document.write('<script src=js/vendor/' +
  ('__proto__' in {} ? 'zepto' : 'jquery') +
  '.js><\/script>')
  </script>
  <script src="../js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
  </body>
</html>
