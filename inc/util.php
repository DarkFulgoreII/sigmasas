<?
	//util methods
	function include_javascript()
	{
		include_bootstrap();
		include_base_jqwidgets();
		include_datetimeinput_widget();
		include_style();
		include_hiding();
		include_spinner_widget();
		//put all including functions here!
	}
	function include_hiding()
	{
		?>
			<script languague="javascript">
		        function mostrar_ocultar(id) {
		            div = document.getElementById(id);
		            if(div.style.display == '')
		            {
		            	div.style.display='none';
		            }
		            else
		            {
		            	div.style.display='';
		            }
		        }
			</script>
		<?
	}
	function include_style()
	{
		?>
			<style>
			.vertical-text {
				transform: rotate(90deg);
				transform-origin: left top 0;
			}
			</style>
		<?
	}
	function include_bootstrap()
	{
		?>
			<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
 			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  			<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<?
	}
	function include_base_jqwidgets()
	{
		?>
			<link rel="stylesheet" href="../inc/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
		    <script type="text/javascript" src="../inc/jqwidgets/scripts/jquery-1.11.1.min.js"></script>
	    <?
	}
	function include_spinner_widget()
	{
		?>
			<script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxcore.js"></script>
   			<script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxnumberinput.js"></script>
    		<script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxbuttons.js"></script>
		<?
	}

	function include_datetimeinput_widget()
	{
		?>
		    <script type="text/javascript" src="../inc/jqwidgets/scripts/demos.js"></script>
		    <script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxcore.js"></script>
		    <script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxdatetimeinput.js"></script>
		    <script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxcalendar.js"></script>
		    <script type="text/javascript" src="../inc/jqwidgets/jqwidgets/jqxtooltip.js"></script>
		    <script type="text/javascript" src="../inc/jqwidgets/jqwidgets/globalization/globalize.js"></script>
	    <?		
	}
	
	function putSpinnerInput($id, $defaultvalue="5")
	{
		$pos = explode("___", $id)[1];
		$name = explode("___", $id)[0];
		$i = explode("_",$pos)[0];
		$j = explode("_",$pos)[1];
		?>
			<script type="text/javascript">
		        $(document).ready(function () {
		            // Create jqxNumberInput
		            //$("#<?=$id?>").jqxNumberInput
		            var spinner =$("#<?=$id?>");
		            spinner.jqxNumberInput
		            (
		            	{ 
		            		width: '80px', 
		            		height: '25px', 
		            		digits: 1 , 
		            		spinButtons: true ,
		            		min : 0,
		            		max : 5,
		            		spinButtonsStep :10,
		            		decimalSeparator : "."
		            	}
		            );
		            spinner.jqxNumberInput('val', <?=$defaultvalue?>);
		            matrix_<?=$name?>[<?=$i?>][<?=$j?>] =spinner ;
		        });
    		</script>
    		<div style='margin-top: 3px;' id='<?=$id?>'></div>
    		<input type='hidden' id='hidden_<?=$name?>[<?=$i?>][<?=$j?>]' name = 'hidden_<?=$name?>[<?=$i?>][<?=$j?>]'></hidden>
		<?
	}
	function putCalendarInput($id,  $width='250px', $height='25px')
	{	
		?>
			<script type="text/javascript">
	            $(document).ready(function () {               
	                // Create a jqxDateTimeInput
	                $("#<?= $id ?>").jqxDateTimeInput({ width: '<?= $width ?>', height: '<?= $height ?>',  culture: 'ja-JP', formatString: "yyyy-MM-dd"});
	            });
	        </script>
	        <div id='<?= $id ?>'>
	        </div>
        <?
	}
	function putTimeInput($id, $width='250px', $height='25px')
	{	
		?>
			<script type="text/javascript">
			      $(document).ready(function () {         
			          // Create jqxDateTimeInput and set its format string to Time. 
			          // Set the showCalendarButton option to hide the calendar's button.
			          $("#<?= $id ?>").jqxDateTimeInput({ width: '<?= $width ?>', height: '<?= $height ?>', formatString: 'T', showCalendarButton: false});
			      });
			</script>  
			<div id='<?= $id ?>'>
	        </div>
        <?
	}
	function eecho($string)
	{
		echo (utf8_encode($string));
	}
	function eecho_capital($string)
	{
		$str = ucwords(strtolower($string));
		eecho ($str);
	}
	function validar_referer($url)
	{
		print_variable("referer",$url);
		if(DEBUG_MODE == "OFF" ) 
		{
			return true;
		}

		if($url== "http://moodleinstitucional.uniandes.edu.co"  || $url== "http://sigma.uniandes.edu.co") 
		{
			return true;
		}
		else 
		{
			return false;
			//header('Location: '.SITE.'web/denegado.php');
		}
	}
	function print_recursive($label, $obj)
	{
		if(DEBUG_MODE == "ON")
		{
			echo "<pre>\n";
			echo "Contenido de: ".$label."\n";
			print_r($obj);
			echo "\n</pre>";	
		}
	}
	function print_recursive_level($label, $obj, $level)
	{
		if(DEBUG_MODE == "ON")
		{
			echo "<pre>\n";
			echo "Contenido de: ".$label."\n";
			print_r_level($obj, $level);
			echo "\n</pre>";	
		}
	}
	function print_variable($label, $obj)
	{
		if(DEBUG_MODE == "ON")
		{
			echo "<pre>\n";
			echo "Contenido de ".$label.": ";
			print($obj);
			echo "\n</pre>";
		}
	}
	//Formats a DATETIME data type into user readable type
	function getTimestamp($mysqlDATETIME)
	{
		setlocale(LC_TIME,"Spanish");
		$year = strtok($mysqlDATETIME,"-");
		$month = strtok("-");
		$day = strtok(" ");
		$hour = strtok(":");
		$minute = strtok(":");
		$second = strtok("");
		$date = mktime($hour,$minute,$second,$month,$day,$year);
		
		return $date;
	}
	
	
	// Deletes a directory if it's empty or not.
	function deldir($dir)
	{
		$current_dir = opendir($dir);
	 	while($entryname = readdir($current_dir))
		{
			if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
			 deldir("${dir}/${entryname}");
		 }elseif($entryname != "." and $entryname!=".."){
				unlink("${dir}/${entryname}");
			}
		}
		closedir($current_dir);
		rmdir(${dir});
	}
	/**
     *  Funcion:  AutenticarLdap
	 *  Autor: Mauricio González Palacios (DTI).
	 *  Última fecha de modificación: 17/10/2002
	 *  Versión: 0.1.
     **/ 
    function AutenticarLdap( $login, $clave ){
	    $success = 0;
        if (!strlen(trim($login)) || !strlen(trim($clave))){
            return 0;
        }
        // Se conecta con LDAP.
        $ds=ldap_connect("ldap.uniandes.edu.co","389");
        // Bind para autenticar.
        $r = @ldap_bind($ds,"uid=". $login .", ou=people, dc=uniandes, dc=edu, dc=co",$clave);

        //Se busca y se recupera el nombre del usuario
		$sr=ldap_search($ds,"ou=people, dc=uniandes, dc=edu, dc=co", "uid=".$login);  
        $info = ldap_get_entries($ds, $sr);

        //Cierra la conexión con LDAP.
        ldap_close($ds);
        //Retorna el resultado del Bind (1 Si lo autenticó; 0 Dlc).
        return $r;
    }

	 // Validates that a given user belongs to the directory.
	 function SearchLdapUser ($usuario)
	 {
	 	
	 	if (!strlen(trim($usuario)) ){
			return 0;
		}
		// Se conecta con LDAP.
		$ds=ldap_connect("ldap.uniandes.edu.co","389");
		
		// Bind para autenticar.
		if ($ds)
		{
			$r = @ldap_bind($ds,"uid=$usuario, ou=people, dc=uniandes, dc=edu, dc=co"); 
			$sr=ldap_search($ds,"ou=people, dc=uniandes, dc=edu, dc=co", "uid=$usuario"); 
			if ($sr) 
				$info = ldap_get_entries($ds,$sr);
		}
		if ($info["count"] != 0)
			return true;
		else 
			return false;
	 }
	  
	 
	// Gets the user name from the directory.
	function GetLdapUser($usuario)
	{
		$cn = 0;
		$displayName = 0;
		if (!strlen(trim($usuario)) ){
			return 0;
		}
		// Se conecta con LDAP.
		$ds=ldap_connect("ldap.uniandes.edu.co","389");
		
		// Bind para autenticar.
		if ($ds)
		{
			$r = @ldap_bind($ds,"uid=$usuario, ou=people, dc=uniandes, dc=edu, dc=co"); 
			$sr=ldap_search($ds,"ou=people, dc=uniandes, dc=edu, dc=co", "uid=$usuario"); 
			if ($sr)
			$info = ldap_get_entries($ds,$sr);
		
			for ($i=0; $i<$info["count"]; $i++) 
			{  #loop though ldap search result
				for ($ii=0; $ii<$info[$i]["count"]; $ii++) 
				{ #loop though attributes in this dn
					if (strcmp($info[$i][$ii],"cn")==0)
					{
						$attrib = $info[$i][$ii]; #set attribute
						$cn = $info[$i][$attrib][0];
					}	
					if (strcmp($info[$i][$ii],"sn")==0)
					{
						$attrib = $info[$i][$ii]; #set attribute
						$lastNames = $info[$i][$attrib][0];
					}	
					if (strcmp($info[$i][$ii],"givenname")==0)
					{
						$attrib = $info[$i][$ii]; #set attribute
						$givenname = $info[$i][$attrib][0];
					}
					if (strcmp($info[$i][$ii],"uacarnetestudiante")==0)
					{
						$attrib = $info[$i][$ii]; #set attribute
						$code = $info[$i][$attrib][0];
					}
					if (strcmp($info[$i][$ii],"departmentnumber")==0)
					{
						$attrib = $info[$i][$ii]; #set attribute
						$program = $info[$i][$attrib][0];
					}	
				} 
			} 
		}
		
		//Cierra la conexión con LDAP.
		ldap_close($ds);
		//Retorna el resultado del Bind (1 Si lo autenticó; 0 Dlc).
		
		if ($lastNames)
		{
			$returnArray["displayName"] = trim($lastNames) . ", " . trim($givenname);
		}
		else
			$returnArray["displayName"] = $cn;
		$returnArray["program"] = $program;
		$returnArray["code"] = $code;
			
		return $returnArray;
	}
	/**
	* Recrusive print variables and limit by level.
	*
	* @param   mixed  $data   The variable you want to dump.
	* @param   int    $level  The level number to limit recrusive loop.
	*
	* @return  string  Dumped data.
	*
	* @author  Simon Asika (asika32764[at]gmail com)
	* @date    2013-11-06
	*/
	function print_r_level($data, $level = 5)
	{
	    static $innerLevel = 1;
	    
	    static $tabLevel = 1;
	    
	    static $cache = array();
	    
	    $self = __FUNCTION__;
	    
	    $type       = gettype($data);
	    $tabs       = str_repeat('    ', $tabLevel);
	    $quoteTabes = str_repeat('    ', $tabLevel - 1);
	    
	    $recrusiveType = array('object', 'array');
	    
	    // Recrusive
	    if (in_array($type, $recrusiveType))
	    {
	        // If type is object, try to get properties by Reflection.
	        if ($type == 'object')
	        {
	            if (in_array($data, $cache))
	            {
	                return "\n{$quoteTabes}*RECURSION*\n";
	            }
	            
	            // Cache the data
	            $cache[] = $data;
	            
	            $output     = get_class($data) . ' ' . ucfirst($type);
	            $ref        = new \ReflectionObject($data);
	            $properties = $ref->getProperties();
	            
	            $elements = array();
	            
	            foreach ($properties as $property)
	            {
	                $property->setAccessible(true);
	                
	                $pType = $property->getName();
	                
	                if ($property->isProtected())
	                {
	                    $pType .= ":protected";
	                }
	                elseif ($property->isPrivate())
	                {
	                    $pType .= ":" . $property->class . ":private";
	                }
	                
	                if ($property->isStatic())
	                {
	                    $pType .= ":static";
	                }
	                
	                $elements[$pType] = $property->getValue($data);
	            }
	        }
	        // If type is array, just retun it's value.
	        elseif ($type == 'array')
	        {
	            $output = ucfirst($type);
	            $elements = $data;
	        }
	        
	        // Start dumping datas
	        if ($level == 0 || $innerLevel < $level)
	        {
	            // Start recrusive print
	            $output .= "\n{$quoteTabes}(";
	            
	            foreach ($elements as $key => $element)
	            {
	                $output .= "\n{$tabs}[{$key}] => ";
	                
	                // Increment level
	                $tabLevel = $tabLevel + 2;
	                $innerLevel++;
	                
	                $output  .= in_array(gettype($element), $recrusiveType) ? $self($element, $level) : $element;
	                
	                // Decrement level
	                $tabLevel = $tabLevel - 2;
	                $innerLevel--;
	            }
	            
	            $output .= "\n{$quoteTabes})\n";
	        }
	        else
	        {
	            $output .= "\n{$quoteTabes}*MAX LEVEL*\n";
	        }
	    }
	    
	    // Clean cache
	    if($innerLevel == 1)
	    {
	        $cache = array();
	    }
	    
	    return $output;
	}// End function

?>