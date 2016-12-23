<?php
include 'includes/connect.php';
include 'includes/header.php';

?>
<script>
//Default Search Parameters
var name = "";
var max_price = 0;
var brand = "";
var wheels = 0;
var colour = "";

//Used to store data
var vehicleId = Array();
var vehicleName = Array();
var vehiclePrice = Array();
var vehicleColour = Array();
var vehicleBrand = Array();
var vehiclePicture = Array();
      
//First Search. All Data.      
checkVehicles(name, max_price, brand, wheels, colour);

//Clears The Div In Which Data Goes Within
function clearVehicles(){	
document.getElementById("javascript").innerHTML = "";
}

//Helps Build The Search Query
function buildFilter(type, inputValue){
	if(type == "name"){
		name = inputValue;
	} else if(type == "max_price"){
		max_price = inputValue;
	} else if(type == "brand"){
		brand = inputValue;
	} else if(type == "wheels"){
		wheels = inputValue;
	} else if(type == "colour"){
		colour = inputValue;
	}
	console.log(name, max_price, brand, wheels, colour);
	checkVehicles(name, max_price, brand, wheels, colour);		
}

//Queries The Data Base Using Ajax And Links To a PHP Script.
function checkVehicles(vehicleName, vehicleMaxPrice, vehicleBrand, vehicleWheels, vehicleColour){
	console.log('data');
$.ajax({
        type: 'POST',
        dataType: "json", 
        data: {
            name:vehicleName,
            max_price:vehicleMaxPrice,
            brand:vehicleBrand,
            wheels:vehicleWheels,
            colour:vehicleColour
            }, 
        url: 'scripts/vehicleRetriever.php',
        success: function(data){
            console.log(data);
            vehicleId=data.id;
            vehicleName=data.name;
            vehiclePrice=data.max_price;
            vehicleColour=data.colour;
            vehicleBrand=data.brand;
            vehiclePicture=data.picture;
            clearVehicles();
            fillArray(vehicleId, vehicleName, vehiclePrice, vehicleColour, vehicleBrand, vehiclePicture);
        },
        error: function(){
            alert('Problem With Data');
            console.log(data);
        }
    })
}

//Wipes The Array Clear
function clearArray(){
	vehicleId = [];
	vehicleName = [];
	vehiclePrice = [];
	vehicleBrand = [];
	vehicleColour = [];
	vehiclePicture = [];
}

//Fills The Array
function fillArray(id, name, price, colour, brand, picture){
	clearArray();
	vehicleId = id;
	vehicleName = name;
	vehiclePrice = price;
	vehicleBrand = brand;
	vehicleColour = colour;
	vehiclePicture = picture;
	displayVehicles();
}

//Displays The Data To The Specified Div.
function displayVehicles(){
	for(var i = 0; i < vehicleId.length; i++){
	var div = document.createElement('div');
    div.className = 'element';	
    div.innerHTML="<div class='cell id'><img src='/vehicle_images/" + vehiclePicture[i] + "' title=" + vehicleName[i] + 
    "><h2><span>" + vehicleBrand[i] + " "  + vehicleName[i] + 
    "</span></h2><h3><span>&pound" + vehiclePrice[i] + "</span></h3></div><h4><span><a href='view_vehicles.php?id="+vehicleId[i]+"'>More Info</a></span></h4></div>";    // Change the content
	document.getElementById('javascript').appendChild(div);
    }	
}
</script>
<div id="content">
<div clss="filter">
  <form id='vehicleFilter'>
  <label for 'Name'>Name: </label>
  <input type="text" name="Name" onkeyup="buildFilter('name', this.value)"/>
   <label for 'Color'>Color: </label>
  <select id="Color" onchange="buildFilter('colour', this.value)">
  <option id="Any">Any</option>
  <option id="Red">Red</option>
  <option id="Black">Black</option>
  <option id="White">White</option>
  <option id="Orange">Orange</option>
  </select>
  <label for 'Wheels'>Wheels: </label>
  <select id="Wheels" onchange="buildFilter('wheels', this.value)">
  <option id="Any">Any</option>
  <option id="2">2</option>
  <option id="3">3</option>
  <option id="4">4</option>
  </select> 
  <label for 'Brands'>Brands: </label>
  <select id="Brands" onchange="buildFilter('brand', this.value)">
  <option id="Any">Any</option>
  <option id="2">BMW</option>
  <option id="3">Audi</option>
  <option id="4">Porsche</option>
  <option id="3">Bugatti</option>
  <option id="4">Lamborghini</option>
  </select> 
  <label for 'Max_Price'>Max Price</label>
  <input type="number" name="Max_Price" onkeyup="buildFilter('max_price', this.value)"/><br />
  </form>
</div>
<div class="vehicles">
	<div id="javascript">
	
	</div>
</div>
</div>
<?php
include 'includes/footer.php';
?>
