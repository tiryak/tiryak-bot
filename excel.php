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

		$products[$i][$j]['name'] = ucwords($name);
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

		$products[$i][$j]['price'] = $explode[0];
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
	'product_id',
	'name(tr-tr)',
	'categories',
	'sku',
	'upc',
	'ean',
	'jan',
	'isbn',
	'mpn',
	'location',
	'quantity',
	'model',
	'manufacturer',
	'image_name',
	'shipping',
	'price',
	'points',
	'date_added',
	'date_modified',
	'date_available',
	'weight',
	'weight_unit',
	'length',
	'width',
	'height',
	'length_unit',
	'status',
	'tax_class_id',
	'description(tr-tr)',
	'meta_title(tr-tr)',
	'meta_description(tr-tr)',
	'meta_keywords(tr-tr)',
	'stock_status_id',
	'store_ids',
	'layout',
	'related_ids',
	'tags(tr-tr)',
	'sort_order',
	'subtract',
	'minimum'
];

$data = [];

$start = 800;

foreach ($output as $product)
{
	$data[] = [
		'product_id' => $start,
		'name(tr-tr)' => $product['name']
	];
}

echo '<pre>';
print_r($output);
