
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
        <h1 class="jqm-logo"><a href="/ifisc/index.php"><img src="/ifisc/_assets/img/jquery-logo.png" alt="Creando el desarrollo"></a></h1>
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