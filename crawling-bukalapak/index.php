<?php 
	include_once('simple_html_dom.php');
	//$proxy = 'proxy3.ubaya.ac.id:8080';

 	$website = "https://www.bukalapak.com/";
 	$i=0;
 	echo "<h1> MINI BUKALAPAK</h1>";
 	
 	echo "<form action='bukalapak.php' method='post'>";
 	echo "<label>Cari Barang </label> <input type='text' name='cari'> <input type='submit' name='cariButton' value='Search'>";
 	echo "</form>";

 	$hargaBarang = "";

	if(isset($_POST['cariButton'])){
		$keyword = $_POST['cari'];
		$sortedKey = str_replace(' ', '+', $keyword);
 		$hasilSearch = $website."/products?utf8=%E2%9C%93&source=navbar&from=omnisearch&search_source=omnisearch_organic&search%5Bhashtag%5D=&search%5Bkeywords%5D=".$sortedKey;
		$html = file_get_html($hasilSearch);
	}
	else{
		$html = file_get_html($website);
	}

	echo "<table border=1>";
	echo "<tr>";
	echo "<td> <b> Nama Barang</b></td>";
	echo "<td> <b> Harga Barang </b> </td>";
	echo "<td> <b> Link Resmi </b> </td>";
	echo "</tr>";
	
	foreach ($html->find('div[class="product-description"]') as $barang) {
		if ($i>9) break;
		else{
			$cekDiskon = $barang->find('div["class=product-price"] .product-price__reduced');
			if($cekDiskon != null){
				$hargaBarang = $barang->find('div[class="product-price"] span[class="product-price__reduced"] span[class="amount positive"]',0)->innertext;
			}else{
				$hargaBarang = $barang->find('span[class="amount positive"]',0)->innertext;
			}
			
			$namaBarang = $barang->find('a[class="product__name"]',0)->innertext;
			$fakeLink = $barang->find('a[class="product__name"]',0)->href;
			$linkBarang	= $website.$fakeLink;

			echo "<tr>";
			echo "<td>".$namaBarang."</td>";
			echo "<td>".$hargaBarang."</td>";
			echo "<td><a href='".$linkBarang."'</a>See Detail</td>";	
			//echo "<td> <a href='".$linkBerita."'>".$judulBerita."<a/> </td>";			
			echo "</tr>";
		}
		$i++;
	}
	echo "</table>";
/*if($result['code']=='200'){
	
}*/
 
	
/*function extract_html($url, $proxy) {
	$response = array();
	$response['code']='';
	$response['message']='';
	$response['status']=false;	
	
    $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1';
 
    // Some websites require referrer
    $host = parse_url($url, PHP_URL_HOST);
    $scheme = parse_url($url, PHP_URL_SCHEME);
    $referrer = $scheme . '://' . $host; 
 
    $curl = curl_init();
 
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_PROXY, $proxy);
	//curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_userpwd);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_REFERER, $referrer);
 
    /*if ( !file_exists(COOKIE_FILENAME) || !is_writable(COOKIE_FILENAME) ) {
		$response['status']=false;
        $response['message']='Cookie file is missing or not writable.';
		return $response;
    }*/
	
    /*curl_setopt($curl, CURLOPT_COOKIESESSION, 0);
    curl_setopt($curl, CURLOPT_COOKIEFILE, COOKIE_FILENAME);
    curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILENAME);
 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
 
    // allow to crawl https webpages
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
 
    // the download speed must be at least 1 byte per second
    curl_setopt($curl,CURLOPT_LOW_SPEED_LIMIT, 1);
 
    // if the download speed is below 1 byte per second for more than 30 seconds curl will give up
    curl_setopt($curl,CURLOPT_LOW_SPEED_TIME, 30);
 
    $content = curl_exec($curl);
 
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
	$response['code'] = $code;
	
    if ($content === false) {
		$response['status'] = false;
		$response['message'] = curl_error($curl);
    }
	else{
		$response['status'] = true;
		$response['message'] = $content;
	}
 
    curl_close($curl);
 
    return $response;
}*/
 ?>