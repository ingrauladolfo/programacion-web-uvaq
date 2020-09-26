<?php


$currency=$_REQUEST["moneda"];

$curl = curl_init();

$response = file_get_contents("http://restcountries.eu/rest/v2/currency/$currency");

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
		echo("<a href='paisesMoneda.php?moneda=".$currency["code"]."' class='currency' data-currency='".$currency["code"]."'>".$currency["code"]."</li>");
	}
	echo("</td>");

	echo("</tr>");
}
echo("</table>");


echo("<pre>");
print_r($response);


