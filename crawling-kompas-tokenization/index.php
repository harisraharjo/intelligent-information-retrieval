<?php 
	include_once('simple_html_dom.php');
	require_once __DIR__ .'/vendor/autoload.php';
	//$proxy = 'proxy3.ubaya.ac.id:8080';
	$website = "https://www.kompas.com/";
 
 	$i=0;

	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
	$stemmer = $stemmerFactory->createStemmer();

	$stopwordFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
	$stopword = $stopwordFactory->createStopWordRemover();

	$hasilStopWord = "";

	$html = file_get_html($website);
	
	echo "<table border=1>";
	echo "<tr>";
	echo "<td> <b> Tanggal Berita </b></td>";
	echo "<td> <b> Judul Berita </b> </td>";
	echo "<td> <b> Hasil preprocessing Judul </b> </td>";
	echo "<td> <b> Hasil Stopword Judul </b> </td>";
	echo "</tr>";


	foreach ($html->find('div[class="article__list clearfix"]') as $berita) {
		if ($i>=1) break;
		else{
			$tglBerita = $berita->find('div[class="article__date"]',0)->innertext;
			$judulBerita = $berita->find('a[class="article__link"]',0)->innertext;
			$linkBerita = $berita->find('a[class="article__link"]',0)->href;
			$output = $stemmer->stem($judulBerita);
			$hasilStopWord = $stopword->remove($output);

			echo "<tr>";
			echo "<td>".$tglBerita."</td>";
			
			echo "<td> <a href='".$linkBerita."'>".$judulBerita."<a/> </td>";	
			echo "<td>".$output."</td>";		
			echo "<td>".$hasilStopWord."</td>";
			echo "</tr>";
		}
		$i++;
	}
	echo "</table>";

	echo "<br><h3>Hasil Tokenisasi</h3><br>";
	
	echo "<table border=1>";
	echo "<tr>";
	echo "<td> <b> Unigram </b></td>";
	echo "<td> <b> Bigram </b> </td>";
	echo "<td> <b> Trigram </b> </td>";
	echo "</tr>";

	$hasilSplit = explode(" ", $hasilStopWord);
	$index = 0;
		foreach ($hasilSplit as $value) {
			if ($index > sizeof($hasilSplit)){
				break;				  
			} 
			else{
				
				$keUni = toUnigram($hasilSplit,$index);
				$keBi = toBigram($hasilSplit,$index);
				$keTri = toTrigram($hasilSplit,$index);
				
				echo "<tr>";
				echo "<td>".$keUni."</td>";
				echo "<td>".$keBi."</td>";
				echo "<td>".$keTri."</td>";
				echo "</tr>";
			}
			$index++;
		}
		

	echo "</table>";



function toUnigram($text,$idx){
	$hasil = $text[$idx];
	return $hasil;
}

function toBigram($text,$idx){
	$hasilAsli = "";
	$ind = $idx++;

	if ($idx >= sizeof($text)) {
		$hasilAsli;
	}else{
		$hasil1 = $text[$idx];
		$hasil2 = $text[$ind];
		$hasilAsli = $hasil2." ".$hasil1;
	}

	return $hasilAsli;
}

function toTrigram($text,$idx){
	$hasilAsli = "";
	$ind = $idx++;
	$ind2 = $ind + 2;
	if ($ind2 >= sizeof($text)) {
		$hasilAsli;
	}else{
		$hasil1 = $text[$idx];
		$hasil2 = $text[$ind];
		$hasil3 = $text[$ind2];
		$hasilAsli = $hasil2." ".$hasil1." ".$hasil3;
	}
	return $hasilAsli;
}
 
	
 ?>