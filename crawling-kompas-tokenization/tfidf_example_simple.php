<?php 
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Math\Distance\Euclidean;
use Phpml\Math\Distance\Manhattan;
use Phpml\Math\Distance\Chebyshev;
use Phpml\Math\Distance\Minkowski;

$sample_data = [
	'dolar naik harga naik hasil turun', 'harga naik harus gaji naik',
	'premium tidak pengaruh dolar', 'harga laptop naik', 'naik harga'
];

$tf = new TokenCountVectorizer(new WhitespaceTokenizer());
$tf->fit($sample_data);
$tf->transform($sample_data);
$vocabulary = $tf->getVocabulary();
$i = 1;
echo "<b>TERM FREQUENCY</b><br><br>";
echo "<table border='1'>";
echo "<tr><th align='center'></th>";
foreach ($vocabulary as $term) {
	echo "<th align='center'>" . $term . "</th>";
}
echo "</tr>";
foreach ($sample_data as $isi) {
	if ($i == count($sample_data)) echo "<tr><td>Q</td>";
	else echo "<tr><td>D" . $i . "</td>";

	foreach ($isi as $item) {
		echo "<td>" . $item . "</td>";
	}
	echo "</tr>";
	$i++;
}
echo "</table><br><br>";

$tfidf = new TfIdfTransformer($sample_data);
$tfidf->transform($sample_data);
$i = 1;
echo "<b>TF-IDF</b><br><br>";
echo "<table border='1'>";
echo "<tr><th align='center'></th>";
foreach ($vocabulary as $term) echo "<th align='center'>" . $term . "</th>";
echo "</tr>";

//Memasukkan item kedalam Array
$isiD1 = array();
$isiD2 = array();
$isiD3 = array();
$isiD4 = array();
$isiQ = array();

foreach ($sample_data as $isi) {
	if ($i == count($sample_data)) {
		echo "<tr><td>Q</td>";
	} else echo "<tr><td>D" . $i . "</td>";

	foreach ($isi as $item) {
		echo "<td>" . round($item, 1) . "</td>";
		if ($i == 1) {
			$isiD1[] = round($item, 1);
		} else if ($i == 2) {
			$isiD2[] = round($item, 1);
		} else if ($i == 3) {
			$isiD3[] = round($item, 1);
		} else if ($i == 4) {
			$isiD4[] = round($item, 1);
		} else {
			$isiQ[] = round($item, 1);
		}
	}
	echo "</tr>";
	$i++;
}
echo "</table>";

//---------------------------------------TUGAS RUMAH 1------------------------------------------
echo "<br><H4><b><u>SIMILIARITY BASED ON DISTANCE</H3></u></b>";
//Euclidean
echo "<br><u><b>Euclidean</b></u><br>";
$euclidean = new Euclidean();
$indexEuclidean = 1;
foreach ($sample_data as $isi) {

	if ($indexEuclidean == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexEuclidean . " dan Q = ";
	}

	if (count($isiD1) == count($isiQ)) {
		if ($indexEuclidean == 1) {
			echo round($euclidean->distance($isiD1, $isiQ), 2) . "<br>";
		} else if ($indexEuclidean == 2) {
			echo round($euclidean->distance($isiD2, $isiQ), 2) . "<br>";
		} else if ($indexEuclidean == 3) {
			echo round($euclidean->distance($isiD3, $isiQ), 2) . "<br>";
		} else {
			echo round($euclidean->distance($isiD4, $isiQ), 2) . "<br>";
		}
	}
	$indexEuclidean++;
}

//Manhattan
echo "<br><u><b>Manhattan</b></u><br>";
$manhattan = new Manhattan();
$indexManhattan = 1;
foreach ($sample_data as $isi) {

	if ($indexManhattan == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexManhattan . " dan Q = ";
	}

	if (sizeof($isiD1) == sizeof($isiQ)) {
		if ($indexManhattan == 1) {
			echo $manhattan->distance($isiD1, $isiQ) . "<br>";
		} else if ($indexManhattan == 2) {
			echo $manhattan->distance($isiD2, $isiQ) . "<br>";
		} else if ($indexManhattan == 3) {
			echo $manhattan->distance($isiD3, $isiQ) . "<br>";
		} else {
			echo $manhattan->distance($isiD4, $isiQ) . "<br>";
		}
	}
	$indexManhattan++;
}

//Chebyshev
echo "<br><u><b>Chebyshev</b></u><br>";
$chebyshev = new Chebyshev();
$indexChebyshev = 1;
foreach ($sample_data as $isi) {

	if ($indexChebyshev == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexChebyshev . " dan Q = ";
	}

	if (sizeof($isiD1) == sizeof($isiQ)) {
		if ($indexChebyshev == 1) {
			echo $chebyshev->distance($isiD1, $isiQ) . "<br>";
		} else if ($indexChebyshev == 2) {
			echo $chebyshev->distance($isiD2, $isiQ) . "<br>";
		} else if ($indexChebyshev == 3) {
			echo $chebyshev->distance($isiD3, $isiQ) . "<br>";
		} else {
			echo $chebyshev->distance($isiD4, $isiQ) . "<br>";
		}
	}
	$indexChebyshev++;
}

//Minkowski
echo "<br><u><b>Minkowski</b></u><br>";
$minkowski = new Minkowski($lambda = 2);
$indexMinkowski = 1;
foreach ($sample_data as $isi) {

	if ($indexMinkowski == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexMinkowski . " dan Q = ";
	}

	if (sizeof($isiD1) == sizeof($isiQ)) {
		if ($indexMinkowski == 1) {
			echo round($minkowski->distance($isiD1, $isiQ), 2) . "<br>";
		} else if ($indexMinkowski == 2) {
			echo round($minkowski->distance($isiD2, $isiQ), 2) . "<br>";
		} else if ($indexMinkowski == 3) {
			echo round($minkowski->distance($isiD3, $isiQ), 2) . "<br>";
		} else {
			echo round($minkowski->distance($isiD4, $isiQ), 2) . "<br>";
		}
	}
	$indexMinkowski++;
}

//-------------------------------TUGAS RUMAH 2-----------------------------------------------------
//Canberra Distance
echo "<br><u><b>Canberra</b></u><br>";

function canberraDistance(array $a, array $b)
{
	if (count($a) !== count($b)) {
		echo "Ukuran Array tidak sama";
	}

	$hasilHitungAtas = array_map(function ($m, $n) {
		$pembilang = abs($m - $n);
		return $pembilang;
	}, $a, $b);

	$hasilHitungBawah = array_map(function ($m, $n) {
		$penyebut = abs($m) + abs($n);
		return $penyebut;
	}, $a, $b);

	$hasilHitung = array();
	for ($i = 0; $i < count($hasilHitungBawah); $i++) {
		if ($hasilHitungBawah[$i] == 0) {
			$hasilHitungAtas[$i] = $hasilHitungBawah[$i];
			$hasilHitungBawah[$i] = $hasilHitungAtas[$i] + 1; //plus 1 smp 99999 tdk pengaruh krn hnya untuk meng-nol kan hasil
			$hasilHitung[] = $hasilHitungAtas[$i] / $hasilHitungBawah[$i];
		} else {
			$hasilHitung[] = $hasilHitungAtas[$i] / $hasilHitungBawah[$i];
		}
	}

	$hasilSigmaTotal =  array_sum($hasilHitung);
	return $hasilSigmaTotal;
}

$indexCanberra = 1;
foreach ($sample_data as $isi) {

	if ($indexCanberra == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexCanberra . " dan Q = ";
	}

	if (sizeof($isiD1) == sizeof($isiQ)) {
		if ($indexCanberra == 1) {
			echo canberraDistance($isiD1, $isiQ) . "<br>";
		} else if ($indexCanberra == 2) {
			echo canberraDistance($isiD2, $isiQ) . "<br>";
		} else if ($indexCanberra == 3) {
			echo canberraDistance($isiD3, $isiQ) . "<br>";
		} else {
			echo canberraDistance($isiD4, $isiQ) . "<br>";
		}
	}
	$indexCanberra++;
}

//Hamming Distance
echo "<br><u><b>Hamming</b></u><br>";

function hammingDistance(array $a, array $b): int
{
	$hasilD = array();
	$hasilQ = array();
	if (count($a) !== count($b)) {
		echo "Ukuran Array tidak sama";
	}

	$i = 0;
	foreach ($a as $key) {
		if ($i == count($a)) {
			break;
		}

		if ($a[$i] > 0) {
			$hasilD[] = 1;
		} else {
			$hasilD[] = 0;
		}
		$i++;
	}

	$i = 0;
	foreach ($b as $key) {
		if ($i == count($b)) {
			break;
		}

		if ($b[$i] > 0) {
			//$b[$i] = 1;
			$hasilQ[] = 1;
		} else {
			//$b[$i] = 0;
			$hasilQ[] = 0;
		}
		$i++;
	}

	$totalBinary = array_map(function ($m, $n) {
		if ($m != $n) {
			$hasil = $m + $n;
		} else {
			$hasil = 0;
		}
		return $hasil;
	}, $hasilD, $hasilQ);

	$hasilSigmaTotal =  array_sum($totalBinary);
	return $hasilSigmaTotal;
}

$indexHamming = 1;
foreach ($sample_data as $isi) {

	if ($indexHamming == count($sample_data)) {
		break;
	} else {
		echo "D" . $indexHamming . " dan Q = ";
	}

	if (sizeof($isiD1) == sizeof($isiQ)) {
		if ($indexHamming == 1) {
			echo hammingDistance($isiD1, $isiQ) . "<br>";
		} else if ($indexHamming == 2) {
			echo hammingDistance($isiD2, $isiQ) . "<br>";
		} else if ($indexHamming == 3) {
			echo hammingDistance($isiD3, $isiQ) . "<br>";
		} else {
			echo hammingDistance($isiD4, $isiQ) . "<br>";
		}
	}
	$indexHamming++;
}
