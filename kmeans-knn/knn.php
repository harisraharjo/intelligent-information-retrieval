<?php 
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Classification\KNearestNeighbors;
$samples = [[3,4,3.5,4,3],[4,4,4,3,3],[2,2.5,4,3,4],[3,4,4,3,3],[2,3,2.5,3,2.5]];
$labels = ['Badminton', 'Badminton', 'Basket', 'Badminton', 'Basket'];

echo "<b><u>Data Training KNN</u></b><br><br>";
echo "<table border='1'>";
echo "<tr><th align='center'></th>";
for ($i=0; $i < count($samples[0]); $i++) { 
	echo "<th align='center'>Term".($i+1)."</th>";
}
echo "<th align='center'>Kategori</th></tr>";
$i = 1;
foreach ($samples as $doc => $term) {
	echo "<tr><th align='center'>Doc".$i."</th>";
	foreach ($term as $value) echo "<td>".$value."</td>";
	echo "<td>".$labels[$i-1]."</td>";
	echo "<tr>";
	$i++;
}
echo "</table><br>";

$data_baru = [3,3,3,3.3,4];
$classifier = new KNearestNeighbors($k=3);
$classifier->train($samples,$labels);
$hasil = $classifier->predict($data_baru);
echo "Hasil Prediksi Dokumen Baru dengan Bobot Term = ";
foreach ($data_baru as $term) echo $term." , ";
echo "adalah ".$hasil;
 ?>