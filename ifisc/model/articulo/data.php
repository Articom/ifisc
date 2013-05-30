<?php 

if ($data_articulo === 'update') {
        $titulo = $publicacion_selected['Titulo'];
        $cuerpo= $publicacion_selected['Cuerpo'];
        $fecha = $publicacion_selected['Fecha'];
         $publico = $publicacion_selected['Destino'];
         ////////////////////////////////////
             $hora= $publicacion_selected['Hora'];
             $lugar=$publicacion_selected['Lugar'];
             $organizadores=$publicacion_selected['Organizadores'];
             $contacto=$publicacion_selected['Contacto'];
             $tel=$publicacion_selected['Telefono'];
             $imagen =$publicacion_selected['Image'];
         //////////////////////////////////////////////
             $fecha_fin=$publicacion_selected['FechaCaduca'];
             $web=$publicacion_selected['URLWeb'];
         ///////////////////////////////////////////
             $posicion=$publicacion_selected['Puesto'];
             $salario=$publicacion_selected['Salario'];
             $mail=$publicacion_selected['Correo'];
             $requisitos=$publicacion_selected['Requisitos'];
        ///////////////////////////////////////////////////
             $perfil=$publicacion_selected['Perfil_egresado'];
             $costo=$publicacion_selected['Costo'];
             $campo=$publicacion_selected['Campo_laboral'];
             $duracion=$publicacion_selected['Duracion'];
             $web_plan=$publicacion_selected['URLPlan'];
             $titulo_carrera=$publicacion_selected['Titulo_profesional'];
             $nivel=$publicacion_selected['Nivel_academico'];
         ////////////////////////////////////////////////
             $fax=$publicacion_selected['Fax'];
             $apost=$publicacion_selected['Apartado_P'];
             $horario=$publicacion_selected['Horario'];
}else{
           $titulo = "";
        $cuerpo= "";
        $fecha = date('Y-m-d');
         $id_categoria = "";
         $publico = "";
         ////////////////////////////////////
             $hora = "";
             $lugar="";
             $organizadores="";
             $contacto="";
             $tel= "";
         //////////////////////////////////////////////
             $fecha_fin=date('Y-m-d');
             $web="";
         ///////////////////////////////////////////
             $posicion="";
             $salario="";
             $mail="";
             $requisitos="";
        ///////////////////////////////////////////////////
             $perfil="";
             $costo="";
             $campo="";
             $duracion="9";
             $web_plan="http://www.-URL-.com";
             $titulo_carrera="";
             $nivel="";
         ////////////////////////////////////////////////
             $fax="";
             $apost="";
             $horario="";
}
 ?>