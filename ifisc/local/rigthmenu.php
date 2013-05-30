 <div data-role="panel" data-position="right" data-display="overlay" data-position-fixed="true" data-theme="d" id="nav-panel2">
        <ul data-role="listview" data-theme="d" class="nav-search">


            <li data-icon="delete"><a href="#" data-rel="close">Cerrar Menu >></a></li>      
                        <li><a href="/ifisc/index.php" data-transition="fade" rel="external" class="contentLink">Inicio</a></li>
                        <li ><a href="/ifisc/local/usuario/perfil.php" data-transition="fade" rel="external" class="contentLink">Perfil</a></li>
                        <li ><a href="/ifisc/local/usuario/preferencias.php" data-transition="fade" rel="external" class="contentLink">Mis preferencias</a></li>
                        <li><a href="/ifisc/model/sesion/salir.php" rel="external" data-transition="fade" class="contentLink">Salir</a></li>
                        <li data-role="list-divider" data-theme="f">Publicaciones</li>
                    
                    <?php 
                        //si tiene permisos de hacer publicaciones se le muestra el menu
                        if ($permiso_usuario['CrearPublicaciones']) {
                            echo '<li><a href="/ifisc/local/articulo/propios.php" data-transition="fade" rel="external" class="contentLink">Mis publicaciones</a></li>';
                            echo '<li><a href="/ifisc/local/articulo/nuevo_tipo.php" data-transition="fade" rel="external" class="contentLink">Nueva publicación</a></li>';
                        }
                        //si tiene permisos de aprobar publicaciones se le muestra este menú
                        if ($permiso_usuario['AprobarPublicaciones']) {
                            echo '<li class="active"><a href="/ifisc/local/articulo/aprobar.php" data-transition="fade" rel="external" class="contentLink">Aprobar publicaciones</a></li>';                     
                       
                        }
                        if ($permiso_usuario['EditarMenuArt']) {
                            echo '<li class="active"><a href="/ifisc/local/admin/articulo/menu_articulo.php" data-transition="fade" rel="external" class="contentLink">Editar Menú</a></li>';                     
                       
                        }
                        
                         ?>
                    <!--<li><a href="/ifisc/local/articulo/categorias.php" data-transition="fade" rel="external" class="contentLink">categorias</a></li>-->
                    
                    <?php 
                    //menu especial que solo se le mostrará a un usuario con rol 1 = coordinador
                    if ($role_usuario['id'] === '1') {
                        echo '<li data-role="list-divider" data-theme="f">Administración</li>';
                        //menu especial para los usuarios que tengan el permiso de aprobar usuarios
                        if ($permiso_usuario['AprobarUsuario']) {
                            echo '<li><a href="/ifisc/local/admin/usuario/aprobar.php" data-transition="fade" rel="external">Aprobar usuarios</a></li>';
                        }
                        //item especial que solo se le muestra a usuarios con el permiso de editar permisos de los roles
                        if ($permiso_usuario['EditarPermisos']) {
                            echo '<li><a href="/ifisc/local/admin/permisos/rolesAdmin.php" data-transition="fade" rel="external">Configurar permisos</a></li>';
                        }
                       
                    }
                     echo '</ul>';
                    ?>          

    </div><!-- /panel -->