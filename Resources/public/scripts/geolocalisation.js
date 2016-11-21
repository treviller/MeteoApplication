function getPos(position)
{
	  document.getElementById("lat").value = position.coords.latitude;
	  document.getElementById("lng").value = position.coords.longitude;
	  document.getElementById("formGPS").submit();
}

function errorPos(error)
{
	var info;
	switch(error.code) {
	case error.TIMEOUT:
		info += "Timeout !";
	break;
	case error.PERMISSION_DENIED:
		info += "Vous n’avez pas donné la permission";
	break;
	case error.POSITION_UNAVAILABLE:
		info += "La position n’a pu être déterminée";
	break;
	case error.UNKNOWN_ERROR:
		info += "Erreur inconnue";
		break;
	}
}

var button1 = document.getElementById("buttonGPS");

button1.addEventListener("click", function(e)
{
	if(navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(getPos,errorPos);
	}
	e.preventDefault();
});