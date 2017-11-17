var map = new AMap.Map('container', {
  	resizeEnable: true,
    resizeEnable: true,
    center: [116.397428, 39.90923],
    zoom: 13,
    keyboardEnable: false

});
function geocoder() {
	AMap.service('AMap.Geocoder',function(){
	    var geocoder = new AMap.Geocoder();
	    geocoder.getLocation( _shop_address, function(status, result) {
	        if (status === 'complete' && result.info === 'OK') {
	            geocoder_CallBack(result);
	        }
	    });
	});
}

function addMarker(i, d) {
    var marker = new AMap.Marker({
        map: map,
        position: [ d.location.getLng(),  d.location.getLat()]
    });
    var infoWindow = new AMap.InfoWindow({
        content: d.formattedAddress,
        offset: {x: 0, y: -30}
    });
    marker.on("mouseover", function(e) {
        infoWindow.open(map, marker.getPosition());
    });
}

function geocoder_CallBack(data) {
    var geocode = data.geocodes;
    for (var i = 0; i < geocode.length; i++) {
        addMarker(i, geocode[i]);
    }
    map.setFitView();
}
geocoder();
