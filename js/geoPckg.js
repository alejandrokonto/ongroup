function initialize(){
		var lats = [];
		var longs = [];
		var latSum=0;
		var longSum=0;
		/*retreive the cords of the destination points*/
		var latDiv = document.querySelectorAll(".domTarget .domTargetLat");
		var longDiv = document.querySelectorAll(".domTarget .domTargetLong");
		/*calculate the center of the map display*/
		for(var i=0; i< latDiv.length;i++){
		lats[i] = latDiv[i].innerHTML;
		longs[i] = longDiv[i].innerHTML}
		
		for(var i=0;i<lats.length;i++){
			latSum += parseFloat(lats[i]);
			}
		
		for(var i=0;i<longs.length;i++){
			longSum += parseFloat(longs[i]);
			}
		var latC = latSum/lats.length;
		var longC = longSum/longs.length;
		/*map*/
		var map_canvas = document.getElementById("googleMaps");
		var googlelatlong = new google.maps.LatLng(latC,longC);
		var mapOptions = {
			center: googlelatlong,
			zoom: 5,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(map_canvas, mapOptions);
		/*markers and route specification*/
		var title = "Location";
		var content = "You are here";
		var routeCords = [];
		for(var i=0;i<lats.length;i++){
			routeCords[i] = new google.maps.LatLng(parseFloat(lats[i]),parseFloat(longs[i]));
			addMarker(map, routeCords[i], title, content);
		}
		
		var route = new google.maps.Polyline({
			path: routeCords,
			geodesic:true,
			strokeColor:'#e05656',
			strokeOpacity:0.8,
			strokeWeight:2
			});
		
		route.setMap(map)
		
	}
	
	
	
function addMarker(map, latlong, title, content){
	
		var markerOptions = {
				position: latlong,
				map: map,
				title: title,
				clickable: true
			};
		
		var marker = new google.maps.Marker(markerOptions);
		
		var infoWindowOptions = {
				content: content,
				position: latlong
		};
		
		var infoWindow = new google.maps.InfoWindow(infoWindowOptions);
		
		google.maps.event.addListener(marker, "click", function(){
			infoWindow.open(map);
			});

}

google.maps.event.addDomListener(window, "load", initialize);
