<html>
	<head>
		<style>
			.hidden {
				display:none;
			}
			p {
				margin: 4 0;
			}
			.error {
				color: red;
				font-size: 10px;
			}
			.currency {
				color: blue;
				cursor: pointer;
			}
		</style>	
		<script
		src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
		
		<script>
			$( document ).ready(function() {  
				$(".currency").click(function(){
					var currency = $(this).data("currency");
					var settings = {
					  "url": "https://restcountries.eu/rest/v2/currency/"+currency,
					  "method": "GET",
					}
					var allCountries="";
					$.ajax(settings).done(function (response) {
						response.forEach(function(country){
							allCountries+="\n"+country["name"];
						});
						alert(allCountries);
					});					
					
					
					
				});   
				$("#usuarios").click(function(){
					usersTable = "";

					var settings = {
					  "url": "https://mediomaraton.uvaq.edu.mx:3000/usuario/",
					  "method": "GET",
					}
					$.ajax(settings).done(function (response) {
					  console.log(response);
					  console.log(response["usuarios"][0]["correo"]);
					  
					  response["usuarios"].forEach(function(usuario){
						console.log(usuario);
						usersTable += `
						<tr>
							<td>${usuario["correo"]}</td>
							<td>${usuario["nombre"]}</td>
							<td>${usuario["genero"]}</td>

						</tr>`;
												  
					  });
					  $("#todoslosusuarios").html(usersTable);
					});		
				});


			});
		</script>	
		
				
	</head>
	<body>
		<p> Da Click aqui para obtener todos los usuarios </p>
		<button id="usuarios">Usuarios</button>
		<table border=1 id="todoslosusuarios"></table>
	</body>		
</html>

<?php




$curl = curl_init();

$response = file_get_contents("http://restcountries.eu/rest/v2/all");

$response = json_decode($response,true);

echo("<table border=1>");
foreach($response as $country)
{
	echo("<tr>
	<td>".$country["name"]."</td>
	<td>".$country["alpha3Code"]."</td>");
	echo("<td>");
	foreach($country["currencies"] as $currency)
	{
		echo("<a class='currency' data-currency='".$currency["code"]."'>".$currency["code"]."</li>");
	}
	echo("</td>");

	echo("</tr>");
}
echo("</table>");


echo("<pre>");
print_r($response);


