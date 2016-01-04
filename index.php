
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset='UTF-8'>

	<title>Responsive Table</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('fromplace'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.k;
                var longitude = place.geometry.location.D;
               
            });
        });
</script>
<script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('toplace'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.k;
                var longitude = place.geometry.location.D;
               
            });
        });
</script>
</head>

<body>
<form action="index.php" method="post">
From<input type="text" id="fromplace" name="from"/><br/>
To<input type="text" id="toplace" name="to"/><br/>
<input type="submit" name="search">
</form>
<?php
if($_POST['search'])
{
$from = $_POST['from'];
$to = $_POST['to'];

$from = urlencode($from);
$to = urlencode($to);

$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
$data = json_decode($data);

$time = 0;
$distance = 0;

foreach($data->rows[0]->elements as $road) 
{
    $time += $road->duration->value;
    $distance += $road->distance->value;
}
$time=$time/60;
$distance=$distance/1000;
echo "To: ".$data->destination_addresses[0];
echo "<br/>";
echo "From: ".$data->origin_addresses[0];
echo "<br/>";
echo "Time: ".$time." MINUTES";
echo "<br/>";
echo "Distance: ".$distance." KM";
}
?>


</body>

</html>