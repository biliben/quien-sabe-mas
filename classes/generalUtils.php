<?php
/**
 * 
 * Esta clase contiene los metodos encargados de las tareas mas comunes.
 * @author eData S.L.
 * @version 4.0
 */
class generalUtils{
  
  /**
   * 
   * Encargada de eliminar las comillas simples de una cadena.
   * @param string $cadena
   * @return string
   * 
   */
  static function filtrarInyeccionSQL($cadena){
    return str_replace("'","",$cadena);
  }
  
  /**
   * 
   * Agregamos antibarras para escapar cadenas con comillas simples o comillas dobles.
   * @param string $cadena
   * @return string
   * 
   */
  static function escaparCadena($cadena){
    $cadena=str_replace("\\","",$cadena);
    return addslashes($cadena);
  }
  
  /**
   * 
   * Quitamos antibarras
   * @param string $cadena
   * @return string
   * 
   */
  static function reeamplazarAntiBarras($cadena){
    return str_replace("\\","",$cadena);
  }
  
  /**
   * 
   * Realizamos redireccion a la pagina deseada.
   * @param string $url
   * 
   */
  static function redirigir($url){
    header("Location:".$url);
    exit();
  }
  
  /**
   * 
   * Dado un email, verificamos que cumple con el formato estandar
   * @param string $email
   * @return string
   * 
   */
  static function validarEmail($email){
    return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>]+\.+[a-z]{2,6}))$#si', $email);
  }
      
  /**
   * 
   * Generamos un combo, donde las opciones son generadas por los resultados de un store procedure pasado como parametro
   * @param object $db
   * @param string $procedure
   * @param string $nombreCombo
   * @param string $idCombo
   * @param string $valorActual
   * @param string $opcionTexto
   * @param string $opcionValor
   * @param string $opcionDefectoTexto
   * @param string $opcionDefectoValor
   * @param string $evento
   * @return string
   * 
   */
  static function construirCombo($db,$procedure,$nombreCombo,$idCombo,$valorActual,$opcionTexto,$opcionValor,$opcionDefectoTexto,$opcionDefectoValor,$evento,$clase=""){
    $resultado=$db->callProcedure($procedure);
    $totalRegistros=$db->getNumberRows($resultado);
    
    //Establecemos el combo como vacio y no lo mostraremos por pantalla
    if($totalRegistros==0){
      $clase="class='dropdown-empty'";
    }//end if

    $combo="<select name='".$nombreCombo."' id='".$idCombo."' ".$evento." ".$clase.">";
    if($opcionDefectoTexto!=""){
      $combo.="<option value='".$opcionDefectoValor."'>".$opcionDefectoTexto."</option>";
    }
    
    while($dato=$db->getData($resultado)){
      if($dato[$opcionValor]==$valorActual){
        $seleccionado="SELECTED";
      }else{
        $seleccionado="";
      }//end else
      $combo.="<option value='".$dato[$opcionValor]."' ".$seleccionado.">".$dato[$opcionTexto]."</option>";
    }//end while
    $combo.="</select>";
    
    return $combo;
  }//end function
  
  
  
  /**
   * 
   * Generamos un combo a partir de una matriz de valores
   * @param array $matriz
   * @param string $nombreCombo
   * @param string $idCombo
   * @param string $valorActual
   * @param string $opcionDefectoTexto
   * @param string $opcionDefectoValor
   * @param string $evento
   * @return string
   * 
   */
  static function construirComboMatriz($matriz,$nombreCombo,$idCombo,$valorActual,$opcionDefectoTexto,$opcionDefectoValor,$evento,$valorConcreto=false,$clase=""){
    $combo="<select name='".$nombreCombo."' id='".$idCombo."' ".$evento." ".$clase.">";
    
    //Solo si pasamos una opcion defecto, es cuando creariamos una opcion por defecto.
    if($opcionDefectoTexto!=""){
      if($opcionDefectoValor==$valorActual){
        $seleccionado="SELECTED";
      }else{
        $seleccionado="";
      }
      $combo.="<option value='".$opcionDefectoValor."' ".$seleccionado.">".$opcionDefectoTexto."</option>";
    }
    
    /**
     * 
     * Numero de elementos de la matriz
     * @var int
     * 
     */
    $lenMatriz=count($matriz);
    
    //Recorremos matriz
    for($i=0;$i<$lenMatriz;$i++){
      if(($valorConcreto && $matriz[$i]["valor"]==$valorActual) || (!$valorConcreto && $i==$valorActual)){
        $seleccionado="SELECTED";
      }else{
        $seleccionado="";
      }//end else
      
      if($valorConcreto){
        $valorReal=$matriz[$i]["valor"];
      }else{
        $valorReal=$i;
      }
      $combo.="<option value='".$valorReal."' ".$seleccionado.">".$matriz[$i]["descripcion"]."</option>";
    }
    $combo.="</select>";
    
    return $combo;
  }
      
  /**
   * 
   * Dado un nombre de fichero, obtenemos su extension
   * @param string $fichero
   * @return string
   * 
   */
  static function obtenerExtensionFichero($fichero){
    return substr($fichero, strrpos($fichero,".")+1);
  }
  
    /**
   * 
   * Dado un nombre de fichero, obtenemos su nombre sin extension
   * @param string $fichero
   * @return string
   * 
   */
  static function obtenerFicheroSinExtension($fichero){
    return substr($fichero, 0 ,strrpos($fichero,"."));
  }
  
    /**
   * 
   * Dada una fecha en formato aaaa-mm-dd o dd-mm-aaaa devolvemos la inversa
   * @example Si pasamos 31-10-1985, devolvoremos 1985-10-31, si pasamos 1985-10-31, devolvremos 31-10-1985
   * @param string $fecha
   * @return string
   */
  static function conversionFechaFormato($fecha,$delimitadorOrigen="-",$delimitadorDestino="-"){
    $fechaConcreta=explode($delimitadorOrigen,$fecha);
    
    return $fechaConcreta[2].$delimitadorDestino.$fechaConcreta[1].$delimitadorDestino.$fechaConcreta[0];
  }
  
  /**
   * Formamos la url amigable para los menus
   * 
   */
  static function generarUrlAmigableMenu($vectorAtributos){     
    $urlAmigable=$vectorAtributos["idioma"]."/".generalUtils::toAscii($vectorAtributos["seo_url"]).":".$vectorAtributos["id_menu"];

    return $urlAmigable;
  }
  
  /**
   * Formamos la url amigable para los detalles
   * 
   */
  static function generarUrlAmigableDetalle($vectorAtributos){      
    $urlAmigable=$vectorAtributos["idioma"]."/detail/".generalUtils::toAscii($vectorAtributos["seo_url"]).":".$vectorAtributos["id_menu"]."-".$vectorAtributos["id_detalle"];

    return $urlAmigable;
  } 
  
  /**
   * Formamos la url amigable para profile
   * 
   */
  static function generarUrlAmigablePerfil($vectorAtributos){     
    $urlAmigable=$vectorAtributos["idioma"]."/profile/".generalUtils::toAscii($vectorAtributos["seo_url"]).":".$vectorAtributos["id_menu"]."-".$vectorAtributos["perfil"];

    return $urlAmigable;
  } 
  
  
  /** 
   * Obtener url menu con contenido.Si el menu leido, no tiene contenido, 
   * pondremos la url del menu hijo mas cercano que tenga url, en caso de que sea un menu copia, pondremos url del menu copia
   * 
  */
  static function generarUrlMenuContenido($db,$idModulo,$idMenu,$descripcion,$idIdioma,$urlReal){
    if($idModulo==1 && $descripcion==""){
      $resultadoMenuDerivado=$db->callProcedure("CALL ed_sp_web_menu_hijo_contenido_obtener(".$idMenu.",".$idIdioma.",1,'','','')");
      if($db->getNumberRows($resultadoMenuDerivado)>0){
        $datoMenuDerivado=$db->getData($resultadoMenuDerivado);
        if($datoMenuDerivado["seo_url"]!=""){
          $urlReal = $datoMenuDerivado["seo_url"];
        }
        if($datoMenuDerivado["id_modulo"] != 1){
          //Datos url seo
          $resultadoMenuSeo = $db->callProcedure("CALL ed_sp_web_menu_seo_obtener(".$datoMenuDerivado["id_menu"].",".$idIdioma.")");
          $datoMenuSeo      = $db->getData($resultadoMenuSeo);
          $urlReal          = $datoMenuSeo["seo_url"];
      
        }//end else if
      }//end if
    }//end if
    return $urlReal;
  }
  /** 
   * Igual que el anterior pero para breadcrumb
  */
  static function generarUrlMenuContenidoBreadCrumb($db,$idModulo,$idMenu,$descripcion,$idIdioma,$urlReal){
    if ($descripcion=="") {
      $urlReal = "";
    }
    return $urlReal;
  }
  /**
 * 
 * Funcion extraida de http://www.kiwwito.com/articulo/funcion-php-para-validar-dni-nie-espanol
 * @param string $cif
 * @return boolean
 */
    static function validarNif ($cadena,$esNif=true){
        //Comprobamos longitud
        if (strlen($cadena) != 9){
          return false;      
        }
    
        //Posibles valores para la letra final 
        $valoresLetra = array(
            0 => 'T', 1 => 'R', 2 => 'W', 3 => 'A', 4 => 'G', 5 => 'M',
            6 => 'Y', 7 => 'F', 8 => 'P', 9 => 'D', 10 => 'X', 11 => 'B',
            12 => 'N', 13 => 'J', 14 => 'Z', 15 => 'S', 16 => 'Q', 17 => 'V',
            18 => 'H', 19 => 'L', 20 => 'C', 21 => 'K',22 => 'E'
        );
  
         //Comprobar si es un DNI
        if ($esNif && preg_match('/^[0-9]{8}[a-zA-Z]$/i', $cadena)){
            //Comprobar letra
            if (strtoupper($cadena[strlen($cadena) - 1]) !=$valoresLetra[((int) substr($cadena, 0, strlen($cadena) - 1)) % 23]){
              return false;
            }
                
            //Todo fue bien 
            return true; 
        }//Comprobar si es un NIE
      else if (!$esNif && preg_match('/^[XYZ][0-9]{7}[A-Z]$/i', $cadena))
      {
          //Comprobar letra
          if (strtoupper($cadena[strlen($cadena) - 1]) !=
              $valoresLetra[((int) substr($cadena, 1, strlen($cadena) - 2)) % 23])
              return false;
  
          //Todo fue bien
          return true;
      }
      
        //Cadena no válida  
        return false; 
    }
    
    /**
     * 
     * Validamos el formato y la coherencia de una fecha pasada en formato dd@mm@aaaa, donde @ es un delimitador que se pasa por
     * parametro
     * @param date $fecha
     */
    static function validarFecha($fecha,$delimitador="/"){
      $fechaDesglosada=explode($delimitador,$_POST["txtFechaNacimiento"]);
      
      //Debemos tener 3 bloques
      if(count($fechaDesglosada)!=3){
        return false;
      }
      if(checkdate($fechaDesglosada[1], $fechaDesglosada[0], $fechaDesglosada[2])){
        return true;
      }
      
      return false;
    } 
    

  /**
   * Limpiamos cadena para que sea considerada amigable
   */
  
  static function toAscii($cadena){
    setlocale(LC_ALL, 'en_US.UTF8');
    $cadenaLimpia = iconv("UTF-8", "ASCII//TRANSLIT", $cadena);
    $cadenaLimpia = preg_replace("/[^a-zA-Z0-9\/_| -]/", "", $cadenaLimpia);
    $cadenaLimpia = strtolower(trim($cadenaLimpia, "-"));
    $cadenaLimpia = preg_replace("/[\_| -]+/", "-", $cadenaLimpia);

    return $cadenaLimpia;
  }   
  
  
  static function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
      $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
    return $connection;
  }
  
  static function autoLinkTwitter($text){
      // properly formatted URLs
      $urls = "/(((http[s]?:\/\/)|(www\.))?(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
      $text = preg_replace($urls, " <a href='$1' target='_blank'>$1</a>", $text);
  
      // URLs without protocols
      $text = preg_replace("/href=\"www/", "href=\"http://www", $text);
  
      // Twitter usernames
      $twitter = "/@([A-Za-z0-9_]+)/is";
      $text = preg_replace ($twitter, " <a href='http://twitter.com/$1' target='_blank'>@$1</a>", $text);
  
      // Twitter hashtags
      $hashtag = "/#([A-Aa-z0-9_-]+)/is";
      $text = preg_replace ($hashtag, " <a href='https://twitter.com/search?q=$1&src=hash' target='_blank'>#$1</a>", $text);
      return $text;
  }
  
  /* creates a compressed zip file */
  static function create_zip($files = array(),$destination = '',$overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { return false; }
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
      //cycle through each file
      foreach($files as $file) {
        //make sure the file exists
        if(file_exists($file)) {
          $valid_files[] = $file;
        }
      }

    }
    //if we have good files...

    if(count($valid_files)) {
      //create the archive
      $zip = new ZipArchive();
      if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
        return false;
      }
      //add the files
      $i=1;
      foreach($valid_files as $file) {
        $new_filename = substr($file,strrpos($file,'/') + 1);
        $zip->addFile($file,$new_filename);
      }
      //debug
      //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
      
      //close the zip -- done!
      $zip->close();
      
      //check to make sure the file exists
      return file_exists($destination);
    }
    else
    {
      return false;
    }
  }//end function
  
  /**
   * Agregamos http a una url siempre que no la tenga...
   */
  static function agregarProtocoloUrl($url) {
      if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
          $url = "http://" . $url;
      }
      return $url;
  }
  
  /**
   * 
   *  Agregamos un tratamiento a los string que salen de base de datos
   * 
   */
  static function tratarCadena($cadena){
    $cadena=htmlspecialchars($cadena);
    
    return $cadena;
  }//end function
  
  /**
   * 
   *  Generamos validaciones
   * 
   */
  static function generarValidaciones($plantillaOrigen,$plantillaDestino){
    $plantillaOrigen->parse("contenido_principal");
      $plantillaDestino->assign("FUNCIONES_VALIDACION",$plantillaOrigen->text("contenido_principal"));
  }//end function
  
  /**
   * 
   *  Dado un string concreto reemplazamos los patterns encontrados
   * 
   */
  static function reemplazarPattern(&$cadena,$patterns){
    $totalReemplazos=0;
    foreach($patterns as $clave=>$valor){
      $numeroReemplazoConcreto=0;
      $cadena=str_replace("[".$clave."]",$valor,$cadena,$numeroReemplazoConcreto);
      $totalReemplazos+=$numeroReemplazoConcreto;
    }//end foreach
    
    return $totalReemplazos;
    
  }//end function
    
}//end class