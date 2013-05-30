<div data-role="panel" data-position="right" data-position-fixed="true" data-display="overlay" data-theme="b" id="add-form">
        <form class="userform" data-ajax="false" action="/ifisc/model/sesion/seguridad/acceso.php" method="POST" >
            <h2>Acceder</h2>
            <label for="name">Usuario:</label>
            <input type="text" name="usuario" id="name" value="" data-clear-btn="true" data-mini="true">
            <label for="password">Contraseña:</label>
            <input type="password" name="clave" id="password" value="" data-clear-btn="true" autocomplete="off" data-mini="true">
            <div class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-rel="close" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                <div class="ui-block-b"><input type="submit" value="Aceptar" data-theme="b" data-mini="true"/></div>
            </div>
        </form>
    </div><!-- /panel -->