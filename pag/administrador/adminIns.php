<?php 
include ('../php/seguridad.php');
?>
<link rel="stylesheet" type="text/css" href="../css/foundation.css">
<link rel="stylesheet" type="text/css" href="../css/foundation.min.css">
<link rel="stylesheet" type="text/css" href="../css/normalize.css">
<script type="text/javascript" src="../js/foundation.min.js">
</script><script type="text/javascript" src="../js/jquery.js">
</script><script type="text/javascript" src="../js/modernizr.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-otro.css" title="win2k-cold-1">
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/calendar-es.js"></script>
<script type="text/javascript" src="../js/calendarsetup.js"></script>
    
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

    <!-- cambia el status de la inscripcion --> 
    <script language="JavaScript" type="text/javascript">
    //paginacion
    var dirPag=0;//direccion de la paginacion. -1 izquierad,0 nueva,1 derecha
    var last_opc=-1;//ultima opcion elegida (por defecto -1 : ninguna)

    /*CAMBIAR EL ESTADO*/
      //idS: id status, el td
      //idA: id Asistente
      //idE: id Evento 
      function setStatusIncs(idS,idA){ 

      var parametros = {"idA" : idA};      
      $.post( 
             "setStatusIncs.php",
             parametros,
             function (respuesta) {
                if(respuesta=='OK'){
                  if($("#status"+idS).html().toString()=="No Aprobado"){
                    $("#status"+idS).html('Aprobado');
                  }
                  else {
                        $("#status"+idS).html('No Aprobado');
                    }
				 alert("Status Modificado"); 	
                }
              }
          );              
      };

      /*CAMBIAR el filtrado*/
      function setFiltrado(OPC){ 
      var copy_opc=OPC;
      //si se usa la paginacion, OPC es igual a last_opc
      if(OPC=='<' || OPC=='>')//page control
         OPC=last_opc;
      else{//opciones de filtrado
        if(OPC<=2)//TODOS-NO APROBADOS-APROBADOS
          document.getElementById("page_controls").style.visibility="visible";
        else//ESTADISTICAS-CONFIGURACION
          document.getElementById("page_controls").style.visibility="hidden";
      }
      if(OPC!=last_opc)
        dirPag=0;//0 para iniciar desde el primer id
      if(copy_opc=='<')
          dirPag=-1;//-1 para seguir con el anterior id de la ultima vez (en misma OPC)
      if(copy_opc=='>')
          dirPag=1;//1 para seguir con el siguiente id de la ultima vez (en misma OPC)

      var parametros = {"OPC" : OPC,"PAG":dirPag};       
      $.post( 
             "setFiltrado.php",
             parametros,
             function (respuesta) {
                  $('.estados').remove();
                  $("#contenido_ajax").html(respuesta);
                  last_opc=OPC;
              }
          );
      };

      function setConfiguracion(){ 
      var parametros = {"FI" :$("#fecha1_mod").val(),"FF" :$("#fecha2_mod").val(),"cupos":$("#cupos").val() };
      var s = new Date($("#fecha1_mod").val().replace(/\//g,'-').replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
      var d = new Date($("#fecha2_mod").val().replace(/\//g,'-').replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
      //fecha 1 > fecha 2
      if(s - d > 0)
      {
        alert("Fecha Inicial debe ser menor o igual a Fecha Final");
        return;
      }
        $.post( 
               "setConfiguracion.php",
               parametros,
               function (respuesta) {
                  if(respuesta=='OK'){
                    alert("Se han Guardado los Cambios realizados");
                  }
                }
        );
      };
    </script>
    <!-- cambia el status de la inscripcion -->
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
 

        <a onClick="setFiltrado(2)" class="small radius button">Todos</a>
        <a onClick="setFiltrado(0)" class="small radius button">No Aprobados</a>
        <a onClick="setFiltrado(1)" class="small radius button">Aprobados</a>
        <a onClick="setFiltrado(3)" class="small radius button">Estadísticas</a>
        <a onClick="setFiltrado(4)" class="small radius button">Configuraciones</a>
        <br>
        <div id="page_controls" style="visibility:hidden">
          <a onClick="setFiltrado('<')" > << Anterior </a>
          -
          <a onClick="setFiltrado('>')" > Siguiente >> </a>
        </div>
		<br>
    <div id="contenido_ajax" >
        
    </div>

</div><!-- Footer -->

<footer class="row">
  <div class="large-12 columns">
    <hr>
    <div class="row">
      <div class="large-6 columns">
        <p>© Copyright Amigos Del Gesto. 2014</p>
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
