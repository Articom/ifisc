
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
                    Título:
               </label>
               <?php
               echo '<input name="articulo_titulo" id="articulo_titulo" placeholder="Título de la publicación"
                              value="'.$titulo.'" type="text">';
                ?>
             </div>
             <div data-rol="fielcontain">
              <label for="in_fecha">
                  Fecha:
              </label>
              <?php
                 echo '<input name="in_fecha" id="in_fecha" value="';
                 echo $fecha;
                 echo '" type="date">';
               ?>
             </div>
             <div data-role="fieldcontain">
             <label for="hora">Hora:</label>
             <?php 
                echo '<input type="time" data-clear-btn="true" name="hora" id="hora" value="'.$hora.'">';
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
                <label for="lugar">
                    Lugar:
                </label>
                <?php 
                echo '<input name="lugar" id="lugar" placeholder="Ubicación" value="'.$lugar.'" type="text">';
                 ?>
            </div>
             <div data-role="fieldcontain">
                <label for="organiz">
                    Organizadores:
                </label>
                <?php 
                echo '<input name="organiz" id="organiz" placeholder="Nombre de los organizadores" value="'.$organizadores.'" type="text">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="contacto">
                    Contacto:
                </label>
                <?php 
                echo '<input name="contacto" id="contacto" placeholder="Contactarse con..." value="'.$contacto.'" type="text">';
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
               <label for="contenido">
                    Descripción básica:
               </label>
               <textarea name="contenido" class="txteditable" id="contenido" placeholder=""> <?php echo $cuerpo; ?></textarea>
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