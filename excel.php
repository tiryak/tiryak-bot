<?php

require 'functions.php';

// Website URL
$website = 'https://www.mecitefendi.com.tr';

// Categories array
$categories = [
	'100-dogal-urunler_31',
	'dogal-sampuanlar-ve-dogal-sac-bakim-urunleri_34',
	'dogal-cilt-bakim-urunleri_35',
	'dogal-dus-jelleri_32',
	'agiz-bakim-urunleri_94',
	'sac-bakim-urunleri_117',
	'250-ml-sampuanlar_114',
	'400-ml-sampuanlar_115',
	'body-butter-kremler_89',
	'el-ve-ayak-bakim-urunleri_27',
	'yuz-bakim-urunleri_40',
	'organik-sabunlar_42',
	'bitkisel-sabunlar_45',
	'ozel-sabun-serisi_107',
	'masaj-urunleri_48',
	'kolonyalar_47',
	'selulit-urunleri_49',
	'gunes-urunleri_50',
	'ozel-urunler_51',
	'20cc-50cc-sabit-yaglar_63',
	'250cc-sabit-yaglar_65',
	'litrelik-sabit-yaglar_64',
	'10cc-ucucu-yaglar_77',
	'20cc-50cc-ucucu-yaglar_66',
	'litrelik-ucucu-yaglar_67',
	'ozel-urun-yaglar_118',
	'litrelik-esanslar-aromalar_69',
	'20cc50cc-esans-ve-aromalar_113',
	'bitkisel-aromatik-sular_56',
	'bitkisel-caylar_57',
	'bitkisel-macunlar_58',
	'organik-sular_99',
	'organik-sirkeler_88',
	'gida-takviyeleri_85',
	'ogutulmus-urunler_98'
];

// Products array
$products = [];

$i = 0;

foreach ($categories as $category)
{
	// Connect to category page
	$connect = connect($website . '/index.php?sayfa=kategori&kat_link=' . $category);

	/*
	 * Start Preg Match All
	 */
	preg_match_all(
		'@<div class="urun-ad barlow text-center">(.*?)<a href="(.*?)">(.*?)</a>@si',
		$connect,
		$productsName
	);

	preg_match_all(
		'@<div class="urun-fiyat ubuntu text-center">(.*?)<span (.*?)>(.*?)</span>(.*?)</div>@si',
		$connect,
		$productsPrice
	);

	preg_match_all(
		'@<img class="(.*?)" src="(.*?)"(.*?)>@si',
		$connect,
		$productsImage
	);
	/*
	 * End Preg Match All
	 */

	$j = 0;

	/*
	 * Link to products
	 */
	foreach ($productsName[2] as $link)
	{
		$products[$i][$j]['link'] = $link;
		$j++;
	}

	$j = 0;

	/*
	 * Name to products
	 */
	foreach ($productsName[3] as $name)
	{
		$name = trim($name);

		$products[$i][$j]['name'] = Transliterator::create('tr-title')->transliterate($name);
		$products[$i][$j]['slug'] = permalink($name);
		$j++;
	}

	$j = 0;

	/*
	 * Price to products
	 */
	foreach ($productsPrice[3] as $price)
	{
		$explode = explode('<i class="fa fa-try"></i>', $price);

		$products[$i][$j]['price'] = turkishLira($explode[0]);
		$j++;
	}

	$j = 0;

	/*
	 * Image to products
	 */
	foreach ($productsImage[2] as $image)
	{
		$explode = explode('https://www.mecitefendi.com.tr/timthumb.php?src=', $image);
		$image = explode('&w=300&h=325&zc=2', $explode[1]);

		$products[$i][$j]['image'] = $image[0];
		$j++;
	}

	$i++;
}

// Output array
$output = [];

/*
 * Assign products to output array
 */
foreach ($products as $product)
{
	 $output = array_merge($output, array_values($product));
}

// Columns array
$columns = [
	'product_id' => 'integer',
	'name(tr-tr)' => 'string',
	'categories' => 'integer',
	'sku' => 'integer',
	'upc' => 'string',
	'ean' => 'string',
	'jan' => 'string',
	'isbn' => 'string',
	'mpn' => 'string',
	'location' => 'string',
	'quantity' => 'integer',
	'model' => 'string',
	'manufacturer' => 'string',
	'image_name' => 'string',
	'shipping' => 'string',
	'price' => 'string',
	'points' => 'integer',
	'date_added' => 'string',
	'date_modified' => 'string',
	'date_available' => 'string',
	'weight' => 'integer',
	'weight_unit' => 'string',
	'length' => 'integer',
	'width' => 'integer',
	'height' => 'integer',
	'length_unit' => 'string',
	'status' => 'string',
	'tax_class_id' => 'integer',
	'description(tr-tr)' => 'string',
	'meta_title(tr-tr)' => 'string',
	'meta_description(tr-tr)' => 'string',
	'meta_keywords(tr-tr)' => 'string',
	'stock_status_id' => 'integer',
	'store_ids' => 'integer',
	'layout' => 'string',
	'related_ids' => 'string',
	'tags(tr-tr)' => 'string',
	'sort_order' => 'integer',
	'subtract' => 'string',
	'minimum' => 'integer'
];

$data = [];

$start = 726;

foreach ($output as $product)
{
	/*if (!file_exists('excel/images'))
	{
		mkdir('excel/images', 0777, true);
	}

	file_put_contents(
		'excel/images/' . $product['slug'] . '.jpg',
		file_get_contents($product['image'])
	);*/

	$data[] = [
		'product_id' => $start,
		'name(tr-tr)' => $product['name'],
		'categories' => 68,
		'sku' => 2,
		'upc' => '',
		'ean' => '',
		'jan' => '',
		'isbn' => '',
		'mpn' => '',
		'location' => '',
		'quantity' => 0,
		'model' => 'T00' . ($start - 5),
		'manufacturer' => 'Mecitefendi',
		'image_name' => 'catalog/urunler/mecitefendi/' . $product['slug'] . '.jpg',
		'shipping' => 'yes',
		'price' => $product['price'],
		'points' => 0,
		'date_added' => date('Y-m-d H:i:s'),
		'date_modified' => date('Y-m-d H:i:s'),
		'date_available' => '2022-08-09',
		'weight' => '0,00',
		'weight_unit' => 'kg',
		'length' => 0,
		'width' => 0,
		'height' => 0,
		'length_unit' => 'cm',
		'status' => 'true',
		'tax_class_id' => 0,
		'description(tr-tr)' => 'Açıklama.',
		'meta_title(tr-tr)' => $product['name'],
		'meta_description(tr-tr)' => $product['name'],
		'meta_keywords(tr-tr)' => $product['name'],
		'stock_status_id' => 5,
		'store_ids' => 0,
		'layout' => '',
		'related_ids' => '',
		'tags(tr-tr)' => tagCloud($product['name']),
		'sort_order' => 1,
		'subtract' => 'true',
		'minimum' => 1
	];

	$start++;
}

try
{
	exportExcel('products-' . date('Y-m-d'), $columns, $data);

	echo 'Dışarı aktarma işlemi başarıyla tamamlandı.';
}
catch (Exception $e)
{
	echo 'Bir hata oluştu ve dışarı aktarılamadı: ' . $e;
}
