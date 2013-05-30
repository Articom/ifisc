
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
                   Nombre de la carrera:
               </label>
               <?php 
               echo '<input name="articulo_titulo" id="articulo_titulo" placeholder="Lic. en Ing..."
               value="'.$titulo.'" type="text">';
                ?>
             </div>  
             <div data-role="fieldcontain">
                <label for="titulo_carrera">
                    Título que brinda la carrera:
                </label>
                <?php 
                echo '<input name="titulo_carrera" id="titulo_carrera" placeholder="Licenciado en... con título intermedio..." value="'.$titulo_carrera.'" type="text">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="nivel">
                    Nivel académico
                </label>
                <select id="nivel" name="nivel" data-theme="a" data-mini="true">
                    <option value="1" <?php if ($nivel == 1) {
                      echo 'selected';
                    } ?>>
                        Pregrado
                    </option>
                    <option value="2" <?php if ($nivel == 2) {
                      echo 'selected';
                    } ?>>
                        Postgrado y Maestria
                    </option>
                    <option value="3" <?php if ($nivel == 3) {
                      echo 'selected';
                    } ?>>
                        Doctorado
                    </option>
                </select>
            </div>
            <div data-role="fieldcontain">
                <label for="costo">
                    Costo:
                </label>
                <?php 
                echo '<input name="costo" id="costo" placeholder="B/. 500.34" value="'.$costo.'" type="text">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="web_plan">
                    Dirección del plan de estudio: 
                </label>
                <?php 
                echo '<input name="web_plan" id="web_plan" placeholder="utp.ac.pa/planes" value="'.$web_plan.'" type="url">';
                 ?>
            </div>
            <div data-role="fieldcontain">
                <label for="duracion">
                    Duración en semestres:
                </label>
                <?php 
                echo '<input name="duracion" id="duracion" placeholder="" value="'.$duracion.'" type="number" min="1">';
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
               <label for="perfil">
                    Perfíl del egresado:
               </label>
               <textarea name="perfil" id="perfil" placeholder="Aspectos que destacan a la persona que aplica para esta carrera..."><?php echo $perfil; ?></textarea>
           </div>
           <div data-role="fieldcontain">
               <label for="campo">
                    Campo laboral:
               </label>
               <textarea name="campo" id="campo" placeholder="Plazas de trabajo existentes luego de culminar con la carrera..."><?php echo $campo; ?></textarea>
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