<!-- termina el contenido de la pagina -->
        <!-- se incluye un navbar para moverse dentro de las páginas

        remover si es necesario -->
        <?php 

            if ($alertaPendiente) {
                        echo '<div data-role="footer" class="ui-bar ui-bar-e"  data-inset="false"
                data-position="fixed" style="width:97%; height:30px;">
                <ul data-role="listview" >
                <li data-icon="alert"><a style="text-align:center; width:92%;" data-rel="external" data-ajax="false" href="/ifisc/local/common/whats_new.php">
                    ¡Tienes publicaciones nuevas!</a></li></ul>
                    </div>';
                    $footernav=false;
                    }else{
                echo '<div data-theme="a" data-role="footer" data-position="fixed"><h3>';
               echo $footer_string;
               echo '</h3></div>';
                    }
                    $footernav=false;
         ?>
        
        <?php 
            //para settear este parametro utilizar la variable $footernav = true;
            //se comprueba si se ha setteado esta variable
            if (isset($footernav)) {
            
                if ($footernav === true) {
        
        ?>
        <div data-role="footer" data-position="fixed">
            <div data-role="navbar">
                <ul>
                    <li><a href="#page-1" data-role="tab" data-icon="grid" class="ui-btn-active">Page 1</a></li>
                    <li><a href="#page-2" data-role="tab" data-icon="grid">Page 2</a></li>
                    <li><a href="#page-3" data-role="tab" data-icon="grid">Page 3</a></li>
                </ul>
            </div>
            </div>
        <?php 
                }else{
               //  echo '<div data-theme="a" data-role="footer" data-position="fixed"><h3>';
               // // echo $footer_string;
               //  echo '</h3></div>';
            } //fin de la primera condicion//fin de la segunda condicion
            }else{
                // echo '<div data-theme="a" data-role="footer" data-position="fixed"><h3>';
                // //echo $footer_string;
                // echo '</h3></div>';
            } //fin de la primera condicion
         ?>
    </div>
</div>