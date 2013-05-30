
<!DOCTYPE html>
<html>
    <head>
        <LINK REL="SHORTCUT ICON" HREF="/ifisc/images/favicon.ico" />
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<title><?php echo $titulo; ?></title> 
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <!-- archivo de estilos css -->
        <link rel="stylesheet"  href="/ifisc/css/jquery.mobile-1.3.1.min.css">
        <link rel="stylesheet" href="/ifisc/css/jqm-style.css">
         <link rel="stylesheet" href="/ifisc/css/ifisc.css" />
        
		<!-- archivos javaScript usados js -->     
       <script src="/ifisc/js/jquery.js"></script>
       <script src="/ifisc/js/jq-theme.js"></script>
       <script src="/ifisc/js/jquery-1.7.2.min.js"></script>
        <script src="/ifisc/js/jquery.mobile-1.3.1.min.js"></script>
        <script type="text/javascript" src="/ifisc/js/tinymce/tinymce.min.js"></script>

		<!-- función para mostrar por consola que ha ocurrido un error al cargar
		un archivo javaScript -->
        <script>
            try {
                tinymce.init({
                //opeciones del editor de texto
                selector: "textarea.txteditable",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                    ]
                });
            } catch (error) {
                console.error("Your javascript has an error: " + error);
            }
        </script>
        <script>
        //script para cambiar de pagina a lo largo del archivo donde se incluya
            $("a[data-role=tab]").each(function () {
                var anchor = $(this);
                anchor.bind("click", function () {
                    $.mobile.changePage(anchor.attr("href"), {
                            transition: "none",
                            changeHash: false
                        });
                    return false;
                });
            });

            $("div[data-role=page]").bind("pagebeforeshow", function (e, data) {
                $.mobile.silentScroll(0);
                $.mobile.changePage.defaults.transition = 'slide';
            });
        </script>
    </head>
    <body> 
	<!-- menu -->
	<?php
		//funcion para buscar la direccion absoluta del archivo
		$path = $_SERVER['PHP_SELF']; 
		$temp = explode("/", $path); 
		$path_absoluto = "/"; 
		for($i=3;$i<count($temp);$i++) 
		$path_absoluto .= "../"; 
		//variable que indica la localizacion absoluta del muenu.
		$menu_location = $path_absoluto ."local/_menu.php";
       
        $leftmenu = $path_absoluto ."local/leftmenu.php";
        $rigthmenu = $path_absoluto ."local/rigthmenu.php"; 
        $loginform = $path_absoluto ."local/rigthlogin.php"; 
        include  $path_absoluto ."model/common/load_alert.php";
		//comprobamos si la pagina tiene menú
        if ($show_menu === true) {
            //se renderiza el html del menu
            include $menu_location; 

        }		
	?>

		<div data-role="page" class="jqm-demos jqm-demos-index" <?php
        //si la variable de id para la página está seteada
       
        if (isset($page_id)) {
            echo 'id="'.$page_id.'"';
        }
        ?>
        >
        <?php 
        if (count($_SESSION) > 0) {
            //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                $show_menu = true;
                include $rigthmenu; 
                
            }else{
                $show_menu = false;
                include $loginform;
            }
        }else{
            $show_menu = false;
            include $loginform;
        }
            include $leftmenu;  

         ?>
          <div data-role="header" class="jqm-header"  data-position="fixed">
               <!-- <a href="/ifisc/index.php" data-ajax="false" data-icon="home" data-transition="fade" >Inicio</a>-->
        <h1 class="jqm-logo"><a href="/ifisc/index.php"><img src="/ifisc/images/jquery-logo.png" alt="Creando el desarrollo"></a></h1>
        <a href="#nav-panel" class="jqm-navmenu-link" data-icon="bars" data-iconpos="notext">Menu</a>
   
       
                <?php
                if( $show_menu ==true){
echo ' <a href="#nav-panel2" style="z-index: 9999;background: url(/ifisc/images/us.gif);" data-icon="bars" data-iconpos="notext">Perfil</a>'; 
//echo ' <a href="#nav-panel2" class="jqm-navmenu-link2" data-icon="bars" data-iconpos="notext">Menu</a>';
                }else{
//class="jqm-search-link"
 echo '<a href="#add-form"  style="z-index: 9999;background: url(/ifisc/images/login.jpg);" data-icon="bars" data-iconpos="notext">acceder</a>';
                }
                   
                    

                    $titulo="";
                        if (isset($titulo)) {
                             echo $titulo;
                        }

                    ?>
               
				
            </div>
            <div data-role="content">