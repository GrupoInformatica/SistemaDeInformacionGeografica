<?php
  // find locations from db
  $conexion=mysql_pconnect("mysql4.000webhost.com","a2897560_vendedo","V3nd3d0") or die ("No se pudo conectar a la BD");
  mysql_select_db("a2897560_vendedo",$conexion) or die ("Base de datos no existe");
  
  // save data for locations
  $lats = "";          // string with latitude values
  $lngs = "";          // string with longitude values
  $addresses = "";     // string with address values
  $names = "";         // string with names
  $descrs = "";        // string with descriptions
  $photos = "";        // string with photo names
  $user_names = "";    // string with user names
  $user_locs = "";     // string with user locations
  
  $VarSqlAdicional = "";
  
  if(($_POST))
  {
    //echo 'hola';
    //exit;
    
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    $desc = $_POST['desc'];
    $dir = $_POST['dir'];
    $t_crimen = $_POST['t_crimen'];
    
    $sql1 = "INSERT INTO localizacion (`lat`,`long`,`descripcion`,`tipo_crimen`,`direccion`) values ('$lat','$long','$desc','$t_crimen','$dir');"; 
   // echo $sql1; exit;
    
    $res = mysql_query($sql1, $conexion) or die(mysql_error());
    $msg = ($res)?1:2;
    
    header("Location:mapa.php?msg=$msg");
    exit;
  }
  
  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
      <style type="text/css">
        html { height: 100% }
        body { height: 100%; margin: 0; padding: 0; background-color: ; font-weight: bold;  }
        #map-canvas { height: 70%; width: 70%; float:left; }
      </style>
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false">
      </script>
      <script type="text/javascript">
        var geocoder;
	var map;
        
        // initialize the array of markers
	var markers = new Array();
        
        
        function initialize() {
          var mapOptions = {
            center: new google.maps.LatLng(4.655133062567141,-74.09385681152344),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
          
          // add event listener for when a user clicks on the map
              google.maps.event.addListener(map, 'click', function(event) {
                          findAddress(event.latLng);
                  });
          
          
          // finds the address for the given location
          function findAddress(loc)
          {
                  geocoder = new google.maps.Geocoder(); 
                  var address = "";
                  if (geocoder) 
                  {
                          geocoder.geocode({'latLng': loc}, function(results, status) 
                          {
                                  if (status == google.maps.GeocoderStatus.OK) 
                                  {
                                          if (results[0]) 
                                          {
                                                  //alert(results[0].formatted_address);
                                                  //alert(loc.lat());
                                                  //alert(loc.lng());
                                                  //address = address + '' + results[0].formatted_address;
                                                  //alert(address);
                                                  //return address;
                                                  // fill in the results in the form
                                                  document.getElementById('lat').value = loc.lat();
                                                  document.getElementById('long').value = loc.lng();
                                                  document.getElementById('address').value = address;
                                                  
                                                  
                                          }
                                  } 
                                  else 
                                  {
                                    //return address;
                                          alert("Geocoder failed due to: " + status);
                                  }
                          });
                  }
                  
                  
                  addMarkers();
          }
          
          
          
          var polygono;
                  var ptos = [
                          new google.maps.LatLng(4.666549, -74.094925),
                          new google.maps.LatLng(4.647749, -74.076125),
                          new google.maps.LatLng(4.628949, -74.094925),
                          new google.maps.LatLng(4.647749, -74.113725)
                      ];
                    
                      // Construct the polygon
                      polygono = new google.maps.Polygon({
                        paths: ptos,
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#FF0000',
                        fillOpacity: 0.35
                      });
                    
                      polygono.setMap(map);
                      
        }
        
        
        
        function addMarkers()
	{
          var direcciones = new Array();
		// get the values for the markers from the hidden elements in the form
		var lats = document.getElementById('lats').value;
		var lngs = document.getElementById('lngs').value;
		
		var las = lats.split(";;")
		var lgs = lngs.split(";;")
		
                var icono = 'http://maps.google.com/mapfiles/kml/pal4/icon15.png';
		
		
                // for every location, create a new marker and infowindow for it
		for (i=0; i<las.length; i++)
		{
			if (las[i] != "")
			{
				// add marker
				var loc = new google.maps.LatLng(las[i],lgs[i]);
                                
                                if(tg[i]==1)
                                {
                                  icono3 = icono;
                                }
                                else
                                {
                                  icono3 = icono2;
                                }
                                
				var marker = new google.maps.Marker({
					position: loc, 
					map: window.map,
					title: nms[i],
                                        icon : icono3,
                                        numero : i,
                                        tg : tg[i],
                                        id : id[i]
				});
				
				markers[i] = marker;
                                //'<p>Guias: '+ng[i]+'</p>'+
                                //'<p>Address: '+ads[i]+'</p>'+
                                
                                /*
				var contentString = [
				  '<div id="tabs">',
				  '<div id="tab-1" style="text-align:center;">',
					'<p align="center"><h1 align="center">'+nms[i]+'</h1></p>',
					'<p align="center">'+imagen1+'</p>'+
				  '</div>',
				  '<div id="tab-2" style="text-align:center;">',
				   '<p><b>Imei: </b>'+dss2[i]+
                                   
                                   ' - <b>Placa: </b>'+pl[i]+
				   ' - <b>Cel: </b>'+ce[i]+'</p>'+
                                  // '<p>Guias Entregadas: '+ge[i]+'</p>'+
                                   // '<p>Guias del D\xeda: '+gd[i]+'</p>'+
				  '</div>',
				  '<div id="tab-3">',
					
					'<p>Location: '+loc+'</p>'+
				  '</div>',
				  '</div>'
				].join('');
				*/
                                
                                // '<a href="javascript:void(0);" onclick="mostrar_historico('+id[i]+')" style="color:#0000FF; text-decoration:underline;">Ver Detalles</a>'+
                                  
				var infowindow = new google.maps.InfoWindow;
				bindInfoWindow(marker, window.map, infowindow, contentString, loc, tg[i]);
			}
		}
                
                
                
	}
        
        
        
        // make conection between infowindow and marker (the infowindw shows up when the user goes with the mouse over the marker)
	function bindInfoWindow(marker, map, infoWindow, contentString,loc,tg)
	{
            //resetHighlightMarker();
		google.maps.event.addListener(marker, 'click', function() {
                        //dir = dir + '' +findAddress(loc); // codeLatLng(las[i],lgs[i]);
                        //alert(dir);
                        //alert(findAddress(loc));
                        
                        
                    geocoder = new google.maps.Geocoder(); 
                    var address = "", ncli='';
                    if (geocoder) 
                    {
			geocoder.geocode({'latLng': loc}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					if (results[0]) 
					{
						//alert(results[0].formatted_address);
						//alert(loc.lat());
						//alert(loc.lng());
                                                address = address + '' + String(results[0].formatted_address);
         
					}
				} 
				
			});
                        
                        
                    }
                        
                        //alert(address);
                        if(ncli!='')
                        contentString = contentString + '<div>'+ncli+'</div>';
                        setTimeout(function(){contentString = contentString + '<div>'+address+'</div>';
			map.setCenter(marker.getPosition());
                        map.zoom = 15;
			infoWindow.setContent(contentString);
			infoWindow.open(map, marker);},500);
                        //alert(marker.numero);
                        highlightMarker(marker.numero,marker.tg);
			//$("#tabs").tabs();
		 });
	}
        
        
        
        google.maps.event.addDomListener(window, 'load', initialize);
        
      </script>
      
    </head>
    <body>
      <?
      if(isset($_GET['msg']))
      {
      if($_GET['msg'] == 1){
        $msj = 'Guardado con exito!!';
      }
      elseif($_GET['msg']==2)
      {
        $msj = 'No se pudo guardar, intentelo nuevamente';
      }
      ?>
      <script type="application/x-javascript">
        alert("<?=$msj?>");
      </script>
      <?
      }
      ?>
      
        <div id="map-canvas"></div>
        <form id='form1' name='form1' method='post' action='mapa.php' >
        <div id="address_details" style="width:20%; height: 70%; float: left; ">
        
          <div class='label1'>
            Latitud:  
          </div>
          <div class='campo1'>
            <input type='text' id='lat' name='lat' value='' requerid /><br />
          </div>
          <div class='label1'> 
          Longitud:
          </div>
          <div class='campo1'>
          <input type='text' id='long' name='long' value='' requerid /><br />
          </div>
          <div class='label1'>
          Direcci&oacute;n:
          </div>
          <div class='campo1'>
          <input type='text' id='dir' name='dir' value='' /><br />
          </div>
          <div class='label1'>
          Tipo Crimen:
          </div>
          <div class='campo1'>
          <select id='t_crimen' name='t_crimen' >
              <option value=''>Seleccione</option>
              <option value='1'>Robo</option>
              <option value='2'>Violación</option>
              <option value='3'>Accidente Vial</option>
            </select>
          </div>
          <br />
          
          <div class='label1'>
          Descripci&oacute;n:
          </div>
          <div class='campo1'>
          <textarea id='desc' name='desc' rows='3' cols='40' requerid ></textarea><br />
          </div>
          <div class='boton1'>
          <input id='borrar' name='borrar' value='Cancelar' type='reset' />
          
          <input type='submit' id='guardar' name='guardar' value='Guardar' />
          </div>
        
      </div>
        <p></p>
        <div id='lista' style='width: 100%'>
          <p></p><br/><br/>
          <table border='1' width='100%'>
            <tr>
              <th>No.</th>
              <th>T. Crimen</th>
              <th>Descripcion</th>
              <th>Direcci&oacute;n</th>
              <th>Latitud</th>
              <th>Longitud</th>
            </tr>
            
          <?
            $sql1 = "SELECT * FROM localizacion "; 
            $res = mysql_query($sql1, $conexion) or die(mysql_error());
            //$datos = mysql_fetch_assoc($res);
            //$mivariable = $datos['usuario'];
            while($datos = mysql_fetch_array($res))
            {
              $lats = $datos['lat'].";;";
              $longs = $datos['long'].";;";
              ?>
              <tr>
                <td><?=$datos['id'];?></td>
                <td><?php
                
                switch ($datos['tipo_crimen'])
                {
                  case 1: echo 'Robo'; break;
                  case 2: echo 'Violacion'; break;
                  case 3: echo 'Accidente Vial'; break;
                  default: echo 'Robo'; 
                }
                
                
                ?></td>
                <td><?=$datos['descripcion'];?></td>
                <td><?=$datos['direccion'];?></td>
                <td><?=$datos['lat'];?></td>
                <td><?=$datos['long'];?></td>
              </tr>
              <?
            }
          ?>
          </table>
        </div>
        <?
        //mysql_free_result();
        ?>
        </form>
    </body>
  </html>