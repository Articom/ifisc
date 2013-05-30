
        <?php 
        //parte para mostrar los errores 
            echo '<div id = "errorRed">';
            ////////////////errores/////////////////////
            if (isset($_GET['error'])) {
                //si el error es de tipo de datos faltantes 
                if ($_GET['error']==='data1') {
                    //se muestra el error de datos faltantes
                    echo '<h6>';
                    echo 'Rellene todos los datos necesarios para la publicación.';
                    echo '</h6>';
                }
            }
            echo "</div>";
            if ($data_articulo === 'update') {
            echo '<form id="nuevo_articulo" action="/ifisc/model/articulo/update.php?Idpub='.$id_publicacion.'" method="POST" data-ajax="false">';
          }else{
            echo '<form id="nuevo_articulo" data-ajax="false" action="/ifisc/model/articulo/guardar.php" method="POST" >';
             }
         ?>
          <div data-role="fieldcontain">
               <label for="articulo_titulo">
                    Nombre:
               </label>
              <?php 
              echo ' <input name="articulo_titulo" id="articulo_titulo" placeholder="Oficinas de la facultad"
               value="'.$titulo.'" type="text">';
               ?>
             </div>
             <div data-role="fieldcontain">
                <label for="lugar">
                    Ubicación:
                </label>
                <?php 
                echo '<input name="lugar" id="lugar" placeholder="Calle # frente a..." value="'.$lugar.'" type="text">';
                 ?>
            </div>
             <div data-role="fieldcontain">
                <label for="horario">
                    Horario de atención:
                </label>
                <?php 
                echo '<input name="horario" id="horario" placeholder="De Lunes a Viernes de 8:00 am" value="'.$horario.'" type="text">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="tel">
                    Teléfono:
                </label>
                <?php 
                echo '<input name="tel" id="tel" placeholder="Teléfono de contacto" value="'.$tel.'" type="tel">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="fax">
                    Fax:
                </label>
                <?php 
                echo '<input name="fax" id="fax" placeholder="999-9999" value="'.$fax.'" type="tel">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="apost">
                    Apartado Postal:
                </label>
                <?php 
                echo '<input name="apost" id="apost" placeholder="A.P 1234-221" value="'.$apost.'" type="text">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="correo">
                    Correo de contacto:
                </label>
                <?php 
                echo '<input name="correo" id="correo" placeholder="contacto@hotmail.com" value="'.$mail.'" type="email">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="textinput1">
                    Categoría : <?php echo $categoria_name; ?>
                </label>
                <?php 
                  echo '<input name="categoria" type="hidden" id="textinput1" placeholder="" value="'.$categoria_selected.'" readonly type="text">';
                 ?>
                
            </div>
             <div data-role="fieldcontain">
               <label for="contenido">
                    Descripción básica:
               </label>
               <textarea name="contenido" class="txteditable" id="contenido" placeholder=""><?php echo $cuerpo; ?></textarea>
           </div>
           <div data-role="fieldcontain">
            <label for="publico" class="select">Publicación dirigida a:</label>
            <select name="publico" id="publico" data-native-menu="false">
                <option value="0">Todo el mundo</option>
               <?php 
                //iteramo sobre todods los roles que existan
                  while($row = mysql_fetch_array($roles)){
                                   echo '<option value="';
                                   echo $row['id'].'" ';//el id del objeto
                                   if ($row['id'] == $publico) {
                                      echo 'selected';
                                   }
                                   echo '>Todo ';
                                   echo $row['Nombre'];//nombre del objeto
                                   echo '</option>';
                                } 
                 ?>
            </select>
           </div>
           sube una imagen
          <input type="submit" data-ajax="false"  value="Guardar" data-inline="true" data-icon="check"/>
          <a href="/ifisc/index.php" data-ajax="false"  data-role="button" data-inline="true">Cancelar</a>
          </form>
     </div>