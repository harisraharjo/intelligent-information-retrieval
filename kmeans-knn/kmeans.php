<?php 
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Clustering\KMeans;

$samples=['Doc1' =>[0.66,4.02], 'Doc2' =>[0.31,1.82], 'Doc3' =>[0.49,2.59], 'Doc4' => [0.50,2.69],
			'Doc5' =>[0.51,2.81], 'Doc6' => [0.65,4.64], 
			'Doc7' => [0.72,3.87], 'Doc8' => [1.62,9.64], 
			'Doc9' => [1.13,7.06], 'Doc10' => [0.61,3.92], 
			'Doc11' => [0.48,2.90], 'Doc12' => [0.59,3.11]];
$kmeans = new KMeans(3);
$hasil = $kmeans->cluster($samples);

echo "<b><u>Hasil Clustering</u></b><br><br>";
echo "<b><u>Bentuk Array</u></b><br><br>";
print_r($hasil);

echo "<br><br><b><u>Bentuk Tabel</u></b><br><br>";
echo "<table border='1'>";

$clust0 = 0;
$clust1 = 0;
$clust2 = 0;
foreach ($hasil as $cluster => $doc) {
	echo "<tr><th align='center'>Cluster ".$cluster."</th>";
	foreach ($doc as $key => $value) {
		if ($cluster == 0) $clust0++;
		else if ($cluster == 1) $clust1++;
		else $clust2++;
		echo "<td>".$key."</td>";
	}
	echo "<tr>";
}
echo "</table>";
$total = $clust0 + $clust1 + $clust2;
$clust0 = ($clust0*100) / $total;
$clust1 = ($clust1*100) / $total;
$clust2 = ($clust2*100) / $total;
 ?>

 
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("theContainer", {
	animationEnabled: true,
	title: {
		text: "Hasil Clustering"
	},
	data: [{
		type: "pie",
		showInLegend: "true",
		yValueFormatString: "##0.00\"%\"",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		startAngle: -150,
		dataPoints: [
			{y: <?php echo $clust0 ?>, label: "Cluster 0"},
			{y: <?php echo $clust1 ?>, label: "Cluster 1"},
			{y: <?php echo $clust2 ?>, label: "Cluster 2"}
		]
	}]
});
chart.render();

}
</script>
<script src="canvasjs-2.3.1/canvasjs.min.js"></script>
 <body>
 	<div id="theContainer" style="height: 360px; width: 100%;"></div>
 </body>