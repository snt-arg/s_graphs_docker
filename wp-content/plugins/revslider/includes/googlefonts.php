<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2020 ThemePunch
 * @since 	  5.1.0
 * @lastfetch 13.01.2022
 */
 
if(!defined('ABSPATH')) exit();

/**
*** CREATED WITH SCRIPT SNIPPET AND DATA TAKEN FROM https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&fields=items(family%2Csubsets%2Cvariants%2Ccategory)&key={YOUR_API_KEY}

$list_raw = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&fields=items(family%2Csubsets%2Cvariants%2Ccategory)&key={YOUR_API_KEY}');

$list = json_decode($list_raw, true);
$list = $list['items'];

echo '<pre>';
foreach($list as $l){
	echo "'".$l['family'] ."' => array("."\n";
	echo "'variants' => array(";
	foreach($l['variants'] as $k => $v){
		if($k > 0) echo ", ";
		if($v == 'regular') $v = '400';
		echo "'".$v."'";
	}
	echo "),\n";
	echo "'subsets' => array(";
	foreach($l['subsets'] as $k => $v){
		if($k > 0) echo ", ";
		echo "'".$v."'";
	}
	echo "),\n";
	echo "'category' => '". $l['category'] ."'";
	echo "\n),\n";
}
echo '</pre>';
**/

$googlefonts = array(
'Roboto' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Open Sans' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans JP' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('japanese', 'latin'),
'category' => 'sans-serif'
),
'Lato' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Montserrat' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Source Sans Pro' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Roboto Condensed' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Poppins' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Oswald' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Roboto Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Noto Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'devanagari', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Raleway' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ubuntu' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'PT Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nunito' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Merriweather' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Roboto Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Playfair Display' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Inter' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans KR' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Rubik' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Open Sans Condensed' => array(
'variants' => array('300', '300italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Lora' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Work Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Nunito Sans' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans TC' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('chinese-traditional', 'latin'),
'category' => 'sans-serif'
),
'Quicksand' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Nanum Gothic' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Fira Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'PT Serif' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Titillium Web' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Siliguri' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Barlow' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Karla' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inconsolata' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Heebo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Oxygen' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Libre Franklin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'PT Sans Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Source Code Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Libre Baskerville' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'IBM Plex Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Arimo' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Dosis' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bebas Neue' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Josefin Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans SC' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'sans-serif'
),
'Mulish' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'EB Garamond' => array(
'variants' => array('400', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cabin' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bitter' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Lobster' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Anton' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Dancing Script' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Source Serif Pro' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'DM Sans' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cairo' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Yanone Kaffeesatz' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Hind' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Prompt' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Varela Round' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans HK' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('chinese-hongkong', 'latin'),
'category' => 'sans-serif'
),
'Fjalla One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Abel' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Kanit' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Barlow Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Comfortaa' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Exo 2' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Catamaran' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Pacifico' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Merriweather Sans' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Saira Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Barlow Semi Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Arvo' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Maven Pro' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Manrope' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Shadows Into Light' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Teko' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Signika Negative' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Hind Madurai' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Architects Daughter' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Indie Flower' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Asap' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Overpass' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Abril Fatface' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif JP' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('japanese', 'latin'),
'category' => 'serif'
),
'Slabo 27px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Cormorant Garamond' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Assistant' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'IBM Plex Serif' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Padauk' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'myanmar'),
'category' => 'sans-serif'
),
'Balsamiq Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Questrial' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fira Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Secular One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Caveat' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Permanent Marker' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Archivo Narrow' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ubuntu Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Rajdhani' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Patrick Hand' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Exo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Tajawal' => array(
'variants' => array('200', '300', '400', '500', '700', '800', '900'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Staatliches' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Domine' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Play' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Acme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Zilla Slab' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Signika' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'M PLUS Rounded 1c' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Satisfy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Archivo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'ABeeZee' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Public Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Spartan' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bree Serif' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Amatic SC' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Jost' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Myeongjo' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'Alfa Slab One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Space Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Cookie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Righteous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Crete Round' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Martel' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Vollkorn' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Space Grotesk' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gothic A1' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Amiri' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Fredoka One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sarabun' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Chakra Petch' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'M PLUS 1p' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Patua One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Red Hat Display' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cinzel' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Alegreya Sans' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Yantramanav' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Antic Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Courgette' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Ubuntu Condensed' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Didact Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'IBM Plex Mono' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Alegreya' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Great Vibes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'PT Sans Caption' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lobster Two' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tinos' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Prata' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'serif'
),
'Archivo Black' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Russo One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Almarai' => array(
'variants' => array('300', '400', '700', '800'),
'subsets' => array('arabic'),
'category' => 'sans-serif'
),
'Spectral' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Kaushan Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Frank Ruhl Libre' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'DM Serif Display' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kalam' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Parisienne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Cardo' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Kufi Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic'),
'category' => 'sans-serif'
),
'Noticia Text' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Bangers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Baloo 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Francois One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Encode Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Old Standard TT' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Gelasio' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Changa' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sacramento' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Asap Condensed' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Montserrat Alternates' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Luckiest Guy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Quattrocento Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Faustina' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Concert One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Pathway Gothic One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Volkhov' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Orbitron' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cuprum' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gloria Hallelujah' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Advent Pro' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rokkitt' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Playfair Display SC' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Passion One' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cormorant' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Special Elite' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Khand' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Chivo' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Eczar' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Saira' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif TC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('chinese-traditional', 'latin'),
'category' => 'serif'
),
'PT Mono' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Crimson Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cantarell' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'News Cycle' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Paytone One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Josefin Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Unna' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Monda' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Sawarabi Mincho' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Press Start 2P' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'display'
),
'Hammersmith One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fira Sans Extra Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Quattrocento' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Vidaloka' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Ropa Sans' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'El Messiri' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Poiret One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Itim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Alata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Be Vietnam Pro' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Sanchez' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ultra' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Philosopher' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'sans-serif'
),
'Yellowtail' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Neuton' => array(
'variants' => array('200', '300', '400', 'italic', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Sigmar One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Handlee' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Playball' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Tangerine' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Viga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Titan One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'DM Serif Text' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ruda' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Marcellus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mali' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Arapey' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Mitr' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Istok Web' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Alice' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Aleo' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gochi Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sawarabi Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Lusitana' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Serif KR' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'Recursive' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Taviraj' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Yeseva One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sora' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gudea' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Allura' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bungee' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Lexend Deca' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Economica' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Monoton' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nanum Pen Script' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Homemade Apple' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Jura' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'kayah-li', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif SC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'serif'
),
'Karma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Adamina' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Gentium Basic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Merienda' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Nanum Gothic Coding' => array(
'variants' => array('400', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'monospace'
),
'Cabin Condensed' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Actor' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Amaranth' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Arima Madurai' => array(
'variants' => array('100', '200', '300', '400', '500', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Khula' => array(
'variants' => array('300', '400', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pragati Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Neucha' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Varela' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Vadodara' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Saira Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'BenchNine' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bai Jamjuree' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Alef' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Oleo Script' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Carter One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cousine' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Unica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fugaz One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ramabhadra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Palanquin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pangolin' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Sen' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Abhaya Libre' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'serif'
),
'Mate SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Armata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Julius Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Share Tech Mono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Kosugi Maru' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pontano Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'IM Fell English SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Audiowide' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Alex Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Nothing You Could Do' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Creepster' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Rock Salt' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Bad Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Sriracha' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Courier Prime' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Lilita One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Marck Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Suez One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Red Hat Text' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tenor Sans' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gentium Book Basic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Sarala' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Mono One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta Malar' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Gruppo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Damion' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Forum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Aclonica' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Arsenal' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Allerta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Lalezar' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Quantico' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Rufina' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bubblegum Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Commissioner' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Shadows Into Light Two' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Black Han Sans' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Sorts Mill Goudy' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Electrolize' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Rasa' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Syncopate' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cantata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Black Ops One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mandali' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Martel Sans' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Reenie Beanie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Italianno' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Castoro' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Niramit' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'IBM Plex Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Krub' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Sintony' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Changa One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Literata' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Basic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fredericka the Great' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fira Mono' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'PT Serif Caption' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Overlock' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mada' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Coda' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Glegoo' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Candal' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Mr Dafoe' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Squada One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sansita' => array(
'variants' => array('400', 'italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Antic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Spinnaker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Baskervville' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Caveat Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Blinker' => array(
'variants' => array('100', '200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Chewy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Encode Sans Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Jaldi' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rancho' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Bodoni Moda' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Yrsa' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Shrikhand' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Voltaire' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Days One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Pinyon Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Enriqueta' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Lemonada' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Telex' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Anonymous Pro' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'greek', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Lateef' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'handwriting'
),
'Average' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kreon' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Alegreya Sans SC' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Lexend' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Six Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Michroma' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Noto Sans Tamil' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('tamil'),
'category' => 'sans-serif'
),
'Mate' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Annie Use Your Telescope' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Hind Guntur' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'sans-serif'
),
'Markazi Text' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Belgrano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Naskh Arabic' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic'),
'category' => 'serif'
),
'Kameron' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Pridi' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Darker Grotesque' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Holtwood One SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cabin Sketch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Mrs Saint Delafield' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Boogaloo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Stint Ultra Condensed' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bowlby One SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Niconne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Palanquin Dark' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Amethysta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Reem Kufi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Norican' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Aldrich' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Allerta Stencil' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Georama' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Graduate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Covered By Your Grace' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Judson' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Scada' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Leckerli One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Racing Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bevan' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'VT323' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Berkshire Swash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Londrina Solid' => array(
'variants' => array('100', '300', '400', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Laila' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rozha One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Jua' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Coming Soon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Gilda Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Herr Von Muellerhoff' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Alatsi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alike Angular' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cinzel Decorative' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Arizonia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Epilogue' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Kosugi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rambla' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Libre Caslon Text' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Saira Extra Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Charm' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Copse' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Knewave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Rye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Athiti' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Just Another Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Skranji' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Share' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Caudex' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'GFS Didot' => array(
'variants' => array('400'),
'subsets' => array('greek'),
'category' => 'serif'
),
'Amita' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Lustria' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kristi' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Jockey One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta Vaani' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Overpass Mono' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Rochester' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Allan' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Comic Neue' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'K2D' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Carme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Bungee Inline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Magra' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Seaweed Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nanum Brush Script' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Alike' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Miriam Libre' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nobile' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari'),
'category' => 'sans-serif'
),
'Krona One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Delius' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Alegreya SC' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Capriola' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Biryani' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bowlby One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Suranna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Yesteryear' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Trocchi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Cedarville Cursive' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Oranienbaum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Trirong' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Fauna One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Coustard' => array(
'variants' => array('400', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Corben' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Marcellus SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Fira Code' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Nixie One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Merienda One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sunflower' => array(
'variants' => array('300', '500', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Arbutus Slab' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('thai'),
'category' => 'sans-serif'
),
'Average Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'NTR' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'JetBrains Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Podkova' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Big Shoulders Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Chonburi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'display'
),
'Petit Formal Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Contrail One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Belleza' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Antonio' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pattaya' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Kumbh Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cambay' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Molengo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cormorant Infant' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Outfit' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Do Hyeon' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Halant' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Wallpoet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Amiko' => array(
'variants' => array('400', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Grand Hotel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Ovo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'La Belle Aurore' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mr De Haviland' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Schoolbell' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Averia Serif Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Mallanna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Carrois Gothic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Slabo 13px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Cutive Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Grandstander' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Esteban' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Calligraffitti' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'BioRhyme' => array(
'variants' => array('200', '300', '400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Spectral SC' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Encode Sans Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Rammetto One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kite One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Sniglet' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Shippori Mincho' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Aladin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rosario' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Hanuman' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'Marmelad' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Metrophobic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bellefair' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Manjari' => array(
'variants' => array('100', '400', '700'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'sans-serif'
),
'Kelly Slab' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Oxygen Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'IM Fell DW Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Libre Barcode 39' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Malayalam' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('malayalam'),
'category' => 'sans-serif'
),
'Maitree' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Radley' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gugi' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Qwigley' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Cutive' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Poller One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Averia Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Duru Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sue Ellen Francisco' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Monsieur La Doulaise' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Harmattan' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Thasadith' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Poly' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'David Libre' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Marvel' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Atkinson Hyperlegible' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'STIX Two Text' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Montez' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Dawning of a New Day' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Euphoria Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Hepta Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Lemon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nova Mono' => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin'),
'category' => 'monospace'
),
'Baloo Tamma 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('kannada', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Stardos Stencil' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Brawler' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Goudy Bookletter 1911' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'IM Fell English' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Sans Telugu' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('telugu'),
'category' => 'sans-serif'
),
'Gabriela' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin'),
'category' => 'serif'
),
'Kurale' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'IM Fell Double Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Zeyada' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Fanwood Text' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bentham' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cormorant SC' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Syne' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Chelsea Market' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Inknut Antiqua' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Oxanium' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Pompiere' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Give You Glory' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Quando' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Proza Libre' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Irish Grover' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kadwa' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Grenze Gotisch' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'McLaren' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Anaheim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bungee Shade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Trykker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Megrim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Doppio One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Farro' => array(
'variants' => array('300', '400', '500', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hi Melody' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'UnifrakturMaguntia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Original Surfer' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dokdo' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Convergence' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'ZCOOL QingKe HuangYou' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'display'
),
'Ranchers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Tenali Ramakrishna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Mansalva' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Sans Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew'),
'category' => 'sans-serif'
),
'Love Ya Like A Sister' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Turret Road' => array(
'variants' => array('200', '300', '400', '500', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Kannada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('kannada'),
'category' => 'sans-serif'
),
'Short Stack' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sarpanch' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Happy Monkey' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Emilys Candy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Calistoga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Baloo Da 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('bengali', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Gurajada' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Buenard' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Livvic' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Limelight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Azeret Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Henny Penny' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'B612 Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Expletus Sans' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Oleo Script Swash Caps' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Oregano' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ceviche One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sedgwick Ave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Coda Caption' => array(
'variants' => array('800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Homenaje' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Mirza' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Andika' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Waiting for the Sunrise' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Major Mono Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Gravitas One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Federo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Urbanist' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rouge Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Atma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'display'
),
'Big Shoulders Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Inder' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Over the Rainbow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Vast Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cormorant Upright' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Freckle Face' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Finger Paint' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tillana' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Geo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Baloo Thambi 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Mountains of Christmas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Share Tech' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Vollkorn SC' => array(
'variants' => array('400', '600', '700', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Clicker Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rakkas' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Faster One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Raleway Dots' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Oriya' => array(
'variants' => array('100', '400', '700', '900'),
'subsets' => array('oriya'),
'category' => 'sans-serif'
),
'Galada' => array(
'variants' => array('400'),
'subsets' => array('bengali', 'latin'),
'category' => 'display'
),
'Cambo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Meddon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Battambang' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Vesper Libre' => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Meera Inimai' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tamil'),
'category' => 'sans-serif'
),
'Noto Sans Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic'),
'category' => 'sans-serif'
),
'Della Respira' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Katibeh' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Walter Turncoat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Sans Mandaic' => array(
'variants' => array('400'),
'subsets' => array('mandaic'),
'category' => 'sans-serif'
),
'Wendy One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Reggae One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Fraunces' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Sans Gujarati' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gujarati'),
'category' => 'sans-serif'
),
'Fondamento' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Antic Didone' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Sans Gurmukhi' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gurmukhi'),
'category' => 'sans-serif'
),
'Ledger' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Unkempt' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Baumans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'ZCOOL XiaoWei' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'serif'
),
'DM Mono' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Metamorphous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Comforter Brush' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Caladea' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Fjord One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Montserrat Subrayada' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Notable' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Noto Sans Bengali' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('bengali'),
'category' => 'sans-serif'
),
'B612' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Orienta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Patrick Hand SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Lekton' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Timmana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Coiny' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Lexend Zetta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ruslan Display' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'RocknRoll One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Goblin One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Mochiy Pop One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'sans-serif'
),
'Montaga' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Prosto One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Aguafina Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Shojumaru' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Overlock SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Chau Philomene One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kiwi Maru' => array(
'variants' => array('300', '400', '500'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mouse Memoirs' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Odibee Sans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Balthazar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Italiana' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Nova Round' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Frijole' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Crafty Girls' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Aref Ruqaa' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bellota Text' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Ma Shan Zheng' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Arya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Eater' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Road Rage' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Numans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Port Lligat Sans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Codystar' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bubbler One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Headland One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mukta Mahee' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sail' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yatra One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Amarante' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sansita Swashed' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Praise' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Almendra' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Delius Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Source Sans 3' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Port Lligat Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Strait' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Bilbo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Loved by the King' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Dynalight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Encode Sans Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Tienne' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Elsie' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Shalimar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Ranga' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Pavanam' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Varta' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Baloo Chettan 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'malayalam', 'vietnamese'),
'category' => 'display'
),
'Stalemate' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'MuseoModerno' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Spicy Rice' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Goldman' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Salsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Yusei Magic' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Averia Sans Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Style Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Artifika' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bilbo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Baloo Bhai 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Baloo Paaji 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Englebert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fahkwang' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Carrois Gothic SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Nova Square' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Sinhala' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('sinhala'),
'category' => 'sans-serif'
),
'Flamenco' => array(
'variants' => array('300', '400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kodchasan' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Iceland' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Newsreader' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Mako' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'The Girl Next Door' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Asul' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'The Nautigal' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Life Savers' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Imprima' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mina' => array(
'variants' => array('400', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Spline Sans' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Just Me Again Down Here' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'League Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Libre Barcode 39 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Wire One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Medula One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'KoHo' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Orelega One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Voces' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Germania One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Encode Sans Semi Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Luxurious Roman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Scope One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Fresca' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gaegu' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Cherry Swash' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Slackey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Delius Unicase' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Baloo Tammudu 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'telugu', 'vietnamese'),
'category' => 'display'
),
'Peralta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Gafata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Solway' => array(
'variants' => array('300', '400', '500', '700', '800'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Vibur' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Nosifer' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cormorant Unicase' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Island Moments' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Song Myung' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'Tauri' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Baloo Bhaina 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'oriya', 'vietnamese'),
'category' => 'display'
),
'Cherry Cream Soda' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dela Gothic One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Snippet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Manuale' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Charmonman' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'UnifrakturCook' => array(
'variants' => array('700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Denk One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Saira Stencil One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Shippori Mincho B1' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Asar' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Shanti' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cantora One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Chango' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Puritan' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Sonsie One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Pirata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lily Script One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Prociono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Sarina' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kranky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Stoke' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Buda' => array(
'variants' => array('300'),
'subsets' => array('latin'),
'category' => 'display'
),
'Modak' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Macondo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Caslon Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mystery Quest' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lexend Exa' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gamja Flower' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'IM Fell French Canon' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Trade Winds' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Paprika' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Habibi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Tomorrow' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Glory' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'MedievalSharp' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Libre Barcode 39 Extended Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bellota' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Averia Gruesa Libre' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Besley' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ibarra Real Nova' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Fontdiner Swanky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ribeye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Moon Dance' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Yeon Sung' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Lovers Quarrel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Julee' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Stint Ultra Expanded' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Akronim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kulim Park' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Engagement' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'DotGothic16' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inika' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Chicle' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sulphur Point' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Khmer' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Ramaraja' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Stylish' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Donegal One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Londrina Outline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dekko' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Farsan' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'ZCOOL KuaiLe' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'display'
),
'Croissant One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Piazzolla' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Rosarivo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rationale' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Uncial Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Scheherazade New' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Lakki Reddy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'handwriting'
),
'Autour One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sumana' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'East Sea Dokdo' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Cute Font' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Zilla Slab Highlight' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nova Flat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Quintessential' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Jomhuria' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Milonga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Underdog' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Tourney' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Simonetta' => array(
'variants' => array('400', 'italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Libre Barcode 128' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Mochiy Pop P One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'sans-serif'
),
'Fenix' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'IM Fell French Canon SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Iceberg' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Text Me One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Crushed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nokora' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Noto Nastaliq Urdu' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic'),
'category' => 'serif'
),
'Shippori Antique' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Condiment' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Big Shoulders Stencil Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Kufam' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'New Rocker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Almendra SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Ruluko' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kotta One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gotu' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Piedra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Vampiro One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Petrona' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Swanky and Moo Moo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Cagliostro' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Allison' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gayathri' => array(
'variants' => array('100', '400', '700'),
'subsets' => array('latin', 'malayalam'),
'category' => 'sans-serif'
),
'Tulpen One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Andika New Basic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Eagle Lake' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sancreek' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bigelow Rules' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'IM Fell Great Primer' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kumar One' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Readex Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Hachi Maru Pop' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Poor Story' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Angkor' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Maiden Orange' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Offside' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sree Krushnadevaraya' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Monofett' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Potta One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Gorditas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sirin Stencil' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'IM Fell DW Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Elsie Swash Caps' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kavivanar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'handwriting'
),
'Margarine' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sura' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Zen Maru Gothic' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rowdies' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Red Rose' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Inria Serif' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Chathura' => array(
'variants' => array('100', '300', '400', '700', '800'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Moul' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Kantumruy' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('khmer'),
'category' => 'sans-serif'
),
'Content' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Griffy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'MonteCarlo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Akaya Kanadaka' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'display'
),
'Meie Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Londrina Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Rhodium Libre' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ruthie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Sahitya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Rum Raisin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Dorsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Libre Barcode 39 Extended' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ravi Prakash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'display'
),
'Barrio' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Junge' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Licorice' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Chilanka' => array(
'variants' => array('400'),
'subsets' => array('latin', 'malayalam'),
'category' => 'handwriting'
),
'Viaoda Libre' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Mrs Sheppards' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Redressed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rubik Beastly' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Modern Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kaisei Tokumin' => array(
'variants' => array('400', '500', '700', '800'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Miniver' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ephesis' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Kavoon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Stick' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Metal Mania' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Train One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Asset' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Arbutus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Wellfleet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Marko One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Jomolhari' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tibetan'),
'category' => 'serif'
),
'Molle' => array(
'variants' => array('italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Ribeye Marrow' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Spirax' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bayon' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Zen Old Mincho' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mogra' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Qwitcher Grypen' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Brygada 1918' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Felipa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Hanalei Fill' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Linden Hill' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Akaya Telivigala' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'display'
),
'Beth Ellen' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Caesar Dressing' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Inria Sans' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif Bengali' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('bengali'),
'category' => 'serif'
),
'Zen Dots' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Zen Antique' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Diplomata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'IBM Plex Sans Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Joti One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Jolly Lodger' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lexend Mega' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Galdeano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Revalia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'WindSong' => array(
'variants' => array('400', '500'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Dongle' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Koulen' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Noto Sans Georgian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('georgian'),
'category' => 'sans-serif'
),
'Montagu Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Romanesco' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Girassol' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Barriecito' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Risque' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Gemunu Libre' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Zen Kaku Gothic New' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Zen Kaku Gothic Antique' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Peddana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Srisakdi' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'display'
),
'Lancelot' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Purple Purse' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fascinate Inline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dangrek' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Unlock' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bigshot One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kumar One Outline' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Glass Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Galindo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Grenze' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Fuzzy Bubbles' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'GFS Neohellenic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek'),
'category' => 'sans-serif'
),
'Gupter' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bahianita' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Diplomata SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Odor Mean Chey' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'Lexend Giga' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bahiana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Smythe' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ewert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Emblema One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Devonshire' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Princess Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Jim Nightshade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Oldenburg' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Jacques Francois Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Truculenta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gowun Batang' => array(
'variants' => array('400', '700'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Libre Barcode 128 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kirang Haerang' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Gwendolyn' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Serif Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Londrina Sketch' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bona Nova' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Sans Myanmar' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('myanmar'),
'category' => 'sans-serif'
),
'Zhi Mang Xing' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Flavors' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Keania One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Plaster' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Festive' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Karantina' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Siemreap' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Dr Sugiyama' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'IM Fell Great Primer SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Otomanopee One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'IBM Plex Sans Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Jacques Francois' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Big Shoulders Stencil Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Armenian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('armenian'),
'category' => 'sans-serif'
),
'Nova Slim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chela One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Almendra Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Zen Loop' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Atomic Age' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Single Day' => array(
'variants' => array('400'),
'subsets' => array('korean'),
'category' => 'display'
),
'Miss Fajardose' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Kaisei Opti' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Hina Mincho' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Hanalei' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bungee Outline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Mr Bedfort' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Combo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Vibes' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'display'
),
'Macondo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Fascinate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Metal' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Noto Sans Symbols' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('symbols'),
'category' => 'sans-serif'
),
'Butterfly Kids' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Vujahday Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Klee One' => array(
'variants' => array('400', '600'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Kaisei Decol' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Freehand' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Erica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Chenla' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Passero One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yomogi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Rampart One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Preahvihear' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Dhurjati' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Nerko One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Kdam Thmor' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Texturina' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Corinthia' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Long Cang' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Hahmlet' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Sedgwick Ave Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Sunshiney' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Black And White Picture' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Liu Jian Mao Cao' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Andada Pro' => array(
'variants' => array('400', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Astloch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Syne Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'IBM Plex Sans KR' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Suwannaphum' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'IM Fell Double Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Benne' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bungee Hairline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Federant' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Tamil Supplement' => array(
'variants' => array('400'),
'subsets' => array('tamil-supplement'),
'category' => 'sans-serif'
),
'Seymour One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Snowburst One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bonbon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Miltonian Tattoo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'BioRhyme Expanded' => array(
'variants' => array('200', '300', '400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Yaldevi' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Fruktur' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lexend Tera' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bokor' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Trochut' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gidugu' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Kaisei HarunoUmi' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Lacquer' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Smokum' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Fuggles' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Supermercado One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Serif Tamil' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('tamil'),
'category' => 'serif'
),
'Stalinist One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Twinkle Star' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Suravaram' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Bakbak One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Butcherman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Geostar Fill' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Oooh Baby' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Ruge Boogie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Taprom' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Alumni Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Sofadi One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Carattere' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Miltonian' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nova Cut' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Aubrey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Stick No Bills' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Moulpali' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Nova Oval' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sevillana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nova Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'New Tegomin' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Zen Kurenaido' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gowun Dodum' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mea Culpa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Gothic' => array(
'variants' => array('400'),
'subsets' => array('gothic'),
'category' => 'sans-serif'
),
'Baloo Bhaijaan 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Encode Sans SC' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Waterfall' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gluten' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Murecho' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Langar' => array(
'variants' => array('400'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'display'
),
'Imbue' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Birthstone' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Source Serif 4' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif Malayalam' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('malayalam'),
'category' => 'serif'
),
'Love Light' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Ballet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bonheur Royale' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Lexend Peta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Comforter' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Ole' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'M PLUS 1' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fasthand' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Luxurious Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Birthstone Bounce' => array(
'variants' => array('400', '500'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Moo Lah Lah' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Libre Barcode EAN13 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Big Shoulders Inline Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'M PLUS 2' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Estonia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Zen Antique Soft' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mohave' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kenia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Xanh Mono' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Genos' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cherokee', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Imperial Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Kolker Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Trispace' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Geostar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Serif Sinhala' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('sinhala'),
'category' => 'serif'
),
'Zen Tokyo Zoo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Red Hat Mono' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Petemoss' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Qahiri' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Inspiration' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Meow Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Smooch' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'M PLUS 1 Code' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Grechen Fuemen' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Are You Serious' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Warnes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Hurricane' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Yuji Syuku' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Shizuru' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'Shippori Antique B1' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cherish' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Oi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Flow Circular' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Uchen' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tibetan'),
'category' => 'serif'
),
'Kings' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Flow Rounded' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('thai'),
'category' => 'serif'
),
'Syne Tactile' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Georgian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('georgian'),
'category' => 'serif'
),
'Noto Serif Armenian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('armenian'),
'category' => 'serif'
),
'Flow Block' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Coptic' => array(
'variants' => array('400'),
'subsets' => array('coptic'),
'category' => 'sans-serif'
),
'M PLUS Code Latin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fleur De Leah' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Big Shoulders Inline Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Puppies Play' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Grey Qo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Rock 3D' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'IBM Plex Sans Thai Looped' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Yuji Boku' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Passions Conflict' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gideon Roman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Lao' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('lao'),
'category' => 'sans-serif'
),
'Sassy Frass' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'IBM Plex Sans Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Koh Santepheap' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Yuji Mai' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Tai Viet' => array(
'variants' => array('400'),
'subsets' => array('tai-viet'),
'category' => 'sans-serif'
),
'Noto Serif Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari'),
'category' => 'serif'
),
'Noto Sans Symbols 2' => array(
'variants' => array('400'),
'subsets' => array('symbols'),
'category' => 'sans-serif'
),
'Palette Mosaic' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'Caramel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'IBM Plex Sans Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Explora' => array(
'variants' => array('400'),
'subsets' => array('cherokee', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Deseret' => array(
'variants' => array('400'),
'subsets' => array('deseret'),
'category' => 'sans-serif'
),
'Yuji Hentaigana Akari' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Sans Khmer' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('khmer'),
'category' => 'sans-serif'
),
'Noto Serif Ethiopic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('ethiopic'),
'category' => 'serif'
),
'Yuji Hentaigana Akebono' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Redacted Script' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Javanese' => array(
'variants' => array('400', '700'),
'subsets' => array('javanese'),
'category' => 'sans-serif'
),
'Noto Serif Khmer' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('khmer'),
'category' => 'serif'
),
'Noto Sans Brahmi' => array(
'variants' => array('400'),
'subsets' => array('brahmi'),
'category' => 'sans-serif'
),
'Noto Sans Thai Looped' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('thai'),
'category' => 'sans-serif'
),
'Noto Sans Tagalog' => array(
'variants' => array('400'),
'subsets' => array('tagalog'),
'category' => 'sans-serif'
),
'Noto Sans Imperial Aramaic' => array(
'variants' => array('400'),
'subsets' => array('imperial-aramaic'),
'category' => 'sans-serif'
),
'Noto Sans Caucasian Albanian' => array(
'variants' => array('400'),
'subsets' => array('caucasian-albanian'),
'category' => 'sans-serif'
),
'Noto Sans Ol Chiki' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('ol-chiki'),
'category' => 'sans-serif'
),
'Noto Sans Tai Tham' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('tai-tham'),
'category' => 'sans-serif'
),
'Redacted' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Cherokee' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cherokee'),
'category' => 'sans-serif'
),
'Noto Serif Kannada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('kannada'),
'category' => 'serif'
),
'Noto Serif Lao' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('lao'),
'category' => 'serif'
),
'Noto Sans Multani' => array(
'variants' => array('400'),
'subsets' => array('multani'),
'category' => 'sans-serif'
),
'Noto Sans Old Turkic' => array(
'variants' => array('400'),
'subsets' => array('old-turkic'),
'category' => 'sans-serif'
),
'Noto Sans Thaana' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('thaana'),
'category' => 'sans-serif'
),
'Noto Serif Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew'),
'category' => 'serif'
),
'Noto Sans Cham' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cham'),
'category' => 'sans-serif'
),
'Noto Serif Gujarati' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gujarati'),
'category' => 'serif'
),
'Noto Rashi Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew'),
'category' => 'serif'
),
'Noto Sans Canadian Aboriginal' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('canadian-aboriginal'),
'category' => 'sans-serif'
),
'Noto Sans Saurashtra' => array(
'variants' => array('400'),
'subsets' => array('saurashtra'),
'category' => 'sans-serif'
),
'Noto Serif Myanmar' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('myanmar'),
'category' => 'serif'
),
'Noto Sans Tai Le' => array(
'variants' => array('400'),
'subsets' => array('tai-le'),
'category' => 'sans-serif'
),
'Noto Sans Meetei Mayek' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('meetei-mayek'),
'category' => 'sans-serif'
),
'Noto Sans Anatolian Hieroglyphs' => array(
'variants' => array('400'),
'subsets' => array('anatolian-hieroglyphs'),
'category' => 'sans-serif'
),
'Noto Serif Tibetan' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('tibetan'),
'category' => 'serif'
),
'Noto Serif Gurmukhi' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gurmukhi'),
'category' => 'serif'
),
'Noto Sans N Ko' => array(
'variants' => array('400'),
'subsets' => array('nko'),
'category' => 'sans-serif'
),
'Noto Sans Balinese' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('balinese'),
'category' => 'sans-serif'
),
'Noto Sans Sora Sompeng' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('sora-sompeng'),
'category' => 'sans-serif'
),
'Noto Sans Osmanya' => array(
'variants' => array('400'),
'subsets' => array('osmanya'),
'category' => 'sans-serif'
),
'Noto Music' => array(
'variants' => array('400'),
'subsets' => array('music'),
'category' => 'sans-serif'
),
'Noto Serif Telugu' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('telugu'),
'category' => 'serif'
),
'Noto Sans Tifinagh' => array(
'variants' => array('400'),
'subsets' => array('tifinagh'),
'category' => 'sans-serif'
),
'Noto Serif Nyiakeng Puachue Hmong' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('nyiakeng-puachue-hmong'),
'category' => 'serif'
),
'Noto Sans Old Hungarian' => array(
'variants' => array('400'),
'subsets' => array('old-hungarian'),
'category' => 'sans-serif'
),
'Noto Serif Yezidi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('yezidi'),
'category' => 'serif'
),
'Noto Sans Carian' => array(
'variants' => array('400'),
'subsets' => array('carian'),
'category' => 'sans-serif'
),
'Noto Sans Sundanese' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('sundanese'),
'category' => 'sans-serif'
),
'Noto Sans Mongolian' => array(
'variants' => array('400'),
'subsets' => array('mongolian'),
'category' => 'sans-serif'
),
'Noto Sans Adlam' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('adlam'),
'category' => 'sans-serif'
),
'Noto Sans Adlam Unjoined' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('adlam'),
'category' => 'sans-serif'
),
'Noto Sans Medefaidrin' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('medefaidrin'),
'category' => 'sans-serif'
),
'Noto Sans Kayah Li' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('kayah-li'),
'category' => 'sans-serif'
),
'Noto Sans Old Italic' => array(
'variants' => array('400'),
'subsets' => array('old-italic'),
'category' => 'sans-serif'
),
'Noto Sans Hanifi Rohingya' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('hanifi-rohingya'),
'category' => 'sans-serif'
),
'Noto Sans Bamum' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('bamum'),
'category' => 'sans-serif'
),
'Noto Sans Grantha' => array(
'variants' => array('400'),
'subsets' => array('grantha'),
'category' => 'sans-serif'
),
'Noto Sans Egyptian Hieroglyphs' => array(
'variants' => array('400'),
'subsets' => array('egyptian-hieroglyphs'),
'category' => 'sans-serif'
),
'Noto Sans Lisu' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('lisu'),
'category' => 'sans-serif'
),
'Noto Sans Cypriot' => array(
'variants' => array('400'),
'subsets' => array('cypriot'),
'category' => 'sans-serif'
),
'Noto Sans Samaritan' => array(
'variants' => array('400'),
'subsets' => array('samaritan'),
'category' => 'sans-serif'
),
'Noto Sans Linear B' => array(
'variants' => array('400'),
'subsets' => array('linear-b'),
'category' => 'sans-serif'
),
'Noto Sans Syriac' => array(
'variants' => array('100', '400', '900'),
'subsets' => array('syriac'),
'category' => 'sans-serif'
),
'Noto Sans Psalter Pahlavi' => array(
'variants' => array('400'),
'subsets' => array('psalter-pahlavi'),
'category' => 'sans-serif'
),
'Noto Sans Inscriptional Parthian' => array(
'variants' => array('400'),
'subsets' => array('inscriptional-parthian'),
'category' => 'sans-serif'
),
'Noto Sans Inscriptional Pahlavi' => array(
'variants' => array('400'),
'subsets' => array('inscriptional-pahlavi'),
'category' => 'sans-serif'
),
'Noto Sans Hanunoo' => array(
'variants' => array('400'),
'subsets' => array('hanunoo'),
'category' => 'sans-serif'
),
'Noto Sans Kaithi' => array(
'variants' => array('400'),
'subsets' => array('kaithi'),
'category' => 'sans-serif'
),
'Noto Sans Old South Arabian' => array(
'variants' => array('400'),
'subsets' => array('old-south-arabian'),
'category' => 'sans-serif'
),
'Noto Sans Math' => array(
'variants' => array('400'),
'subsets' => array('math'),
'category' => 'sans-serif'
),
'Noto Sans Old Persian' => array(
'variants' => array('400'),
'subsets' => array('old-persian'),
'category' => 'sans-serif'
),
'Noto Sans Indic Siyaq Numbers' => array(
'variants' => array('400'),
'subsets' => array('indic-siyaq-numbers'),
'category' => 'sans-serif'
),
'Noto Serif Balinese' => array(
'variants' => array('400'),
'subsets' => array('balinese'),
'category' => 'serif'
),
'Noto Sans Cuneiform' => array(
'variants' => array('400'),
'subsets' => array('cuneiform'),
'category' => 'sans-serif'
),
'Noto Serif Ahom' => array(
'variants' => array('400'),
'subsets' => array('ahom'),
'category' => 'serif'
),
'Noto Sans Newa' => array(
'variants' => array('400'),
'subsets' => array('newa'),
'category' => 'sans-serif'
),
'Noto Sans Batak' => array(
'variants' => array('400'),
'subsets' => array('batak'),
'category' => 'sans-serif'
),
'Noto Sans Yi' => array(
'variants' => array('400'),
'subsets' => array('yi'),
'category' => 'sans-serif'
),
'Noto Sans Old North Arabian' => array(
'variants' => array('400'),
'subsets' => array('old-north-arabian'),
'category' => 'sans-serif'
),
'Noto Serif Grantha' => array(
'variants' => array('400'),
'subsets' => array('grantha'),
'category' => 'serif'
),
'Noto Sans Lycian' => array(
'variants' => array('400'),
'subsets' => array('lycian'),
'category' => 'sans-serif'
),
'Noto Sans Avestan' => array(
'variants' => array('400'),
'subsets' => array('avestan'),
'category' => 'sans-serif'
),
'Noto Sans Phoenician' => array(
'variants' => array('400'),
'subsets' => array('phoenician'),
'category' => 'sans-serif'
),
'Noto Serif Dogra' => array(
'variants' => array('400'),
'subsets' => array('dogra'),
'category' => 'serif'
),
'Noto Sans Siddham' => array(
'variants' => array('400'),
'subsets' => array('siddham'),
'category' => 'sans-serif'
),
'Noto Serif Tangut' => array(
'variants' => array('400'),
'subsets' => array('tangut'),
'category' => 'serif'
),
'Noto Traditional Nushu' => array(
'variants' => array('400'),
'subsets' => array('nushu'),
'category' => 'sans-serif'
),
'Noto Sans Zanabazar Square' => array(
'variants' => array('400'),
'subsets' => array('zanabazar-square'),
'category' => 'sans-serif'
),
'Noto Sans Runic' => array(
'variants' => array('400'),
'subsets' => array('runic'),
'category' => 'sans-serif'
),
'Noto Sans Elbasan' => array(
'variants' => array('400'),
'subsets' => array('elbasan'),
'category' => 'sans-serif'
),
'Noto Sans Buginese' => array(
'variants' => array('400'),
'subsets' => array('buginese'),
'category' => 'sans-serif'
),
'Noto Sans New Tai Lue' => array(
'variants' => array('400'),
'subsets' => array('new-tai-lue'),
'category' => 'sans-serif'
),
'Noto Sans Mahajani' => array(
'variants' => array('400'),
'subsets' => array('mahajani'),
'category' => 'sans-serif'
),
'Noto Sans Mayan Numerals' => array(
'variants' => array('400'),
'subsets' => array('mayan-numerals'),
'category' => 'sans-serif'
),
'Noto Sans Hatran' => array(
'variants' => array('400'),
'subsets' => array('hatran'),
'category' => 'sans-serif'
),
'Noto Sans Bassa Vah' => array(
'variants' => array('400'),
'subsets' => array('bassa-vah'),
'category' => 'sans-serif'
),
'Noto Sans Bhaiksuki' => array(
'variants' => array('400'),
'subsets' => array('bhaiksuki'),
'category' => 'sans-serif'
),
'Noto Sans Gunjala Gondi' => array(
'variants' => array('400'),
'subsets' => array('gunjala-gondi'),
'category' => 'sans-serif'
),
'Noto Sans Syloti Nagri' => array(
'variants' => array('400'),
'subsets' => array('syloti-nagri'),
'category' => 'sans-serif'
),
'Noto Sans Palmyrene' => array(
'variants' => array('400'),
'subsets' => array('palmyrene'),
'category' => 'sans-serif'
),
'Noto Sans Marchen' => array(
'variants' => array('400'),
'subsets' => array('marchen'),
'category' => 'sans-serif'
),
'Noto Sans Old Permic' => array(
'variants' => array('400'),
'subsets' => array('old-permic'),
'category' => 'sans-serif'
),
'Noto Sans Ugaritic' => array(
'variants' => array('400'),
'subsets' => array('ugaritic'),
'category' => 'sans-serif'
),
'Noto Sans Wancho' => array(
'variants' => array('400'),
'subsets' => array('wancho'),
'category' => 'sans-serif'
),
'Noto Sans Vai' => array(
'variants' => array('400'),
'subsets' => array('vai'),
'category' => 'sans-serif'
),
'Noto Sans Masaram Gondi' => array(
'variants' => array('400'),
'subsets' => array('masaram-gondi'),
'category' => 'sans-serif'
),
'Noto Sans Tagbanwa' => array(
'variants' => array('400'),
'subsets' => array('tagbanwa'),
'category' => 'sans-serif'
),
'Noto Sans Rejang' => array(
'variants' => array('400'),
'subsets' => array('rejang'),
'category' => 'sans-serif'
),
'Noto Sans Khojki' => array(
'variants' => array('400'),
'subsets' => array('khojki'),
'category' => 'sans-serif'
),
'Noto Sans Warang Citi' => array(
'variants' => array('400'),
'subsets' => array('warang-citi'),
'category' => 'sans-serif'
),
'Noto Sans Limbu' => array(
'variants' => array('400'),
'subsets' => array('limbu'),
'category' => 'sans-serif'
),
'Noto Sans Glagolitic' => array(
'variants' => array('400'),
'subsets' => array('glagolitic'),
'category' => 'sans-serif'
),
'Noto Sans Nushu' => array(
'variants' => array('400'),
'subsets' => array('nushu'),
'category' => 'sans-serif'
),
'Noto Sans Tirhuta' => array(
'variants' => array('400'),
'subsets' => array('tirhuta'),
'category' => 'sans-serif'
),
'Noto Sans Lydian' => array(
'variants' => array('400'),
'subsets' => array('lydian'),
'category' => 'sans-serif'
),
'Noto Sans Sharada' => array(
'variants' => array('400'),
'subsets' => array('sharada'),
'category' => 'sans-serif'
),
'Noto Sans Old Sogdian' => array(
'variants' => array('400'),
'subsets' => array('old-sogdian'),
'category' => 'sans-serif'
),
'Noto Sans Meroitic' => array(
'variants' => array('400'),
'subsets' => array('meroitic'),
'category' => 'sans-serif'
),
'Noto Sans Miao' => array(
'variants' => array('400'),
'subsets' => array('miao'),
'category' => 'sans-serif'
),
'Noto Sans Shavian' => array(
'variants' => array('400'),
'subsets' => array('shavian'),
'category' => 'sans-serif'
),
'Noto Sans Soyombo' => array(
'variants' => array('400'),
'subsets' => array('soyombo'),
'category' => 'sans-serif'
),
'Noto Sans Linear A' => array(
'variants' => array('400'),
'subsets' => array('linear-a'),
'category' => 'sans-serif'
),
'Noto Sans Lepcha' => array(
'variants' => array('400'),
'subsets' => array('lepcha'),
'category' => 'sans-serif'
),
'Noto Sans Chakma' => array(
'variants' => array('400'),
'subsets' => array('chakma'),
'category' => 'sans-serif'
),
'Noto Sans Modi' => array(
'variants' => array('400'),
'subsets' => array('modi'),
'category' => 'sans-serif'
),
'Noto Sans Sogdian' => array(
'variants' => array('400'),
'subsets' => array('sogdian'),
'category' => 'sans-serif'
),
'Noto Sans Phags Pa' => array(
'variants' => array('400'),
'subsets' => array('phags-pa'),
'category' => 'sans-serif'
),
'Noto Sans Buhid' => array(
'variants' => array('400'),
'subsets' => array('buhid'),
'category' => 'sans-serif'
),
'Noto Sans Pau Cin Hau' => array(
'variants' => array('400'),
'subsets' => array('pau-cin-hau'),
'category' => 'sans-serif'
),
'Noto Sans Mro' => array(
'variants' => array('400'),
'subsets' => array('mro'),
'category' => 'sans-serif'
),
'Noto Sans Osage' => array(
'variants' => array('400'),
'subsets' => array('osage'),
'category' => 'sans-serif'
),
'Noto Sans Manichaean' => array(
'variants' => array('400'),
'subsets' => array('manichaean'),
'category' => 'sans-serif'
),
'Noto Sans Khudawadi' => array(
'variants' => array('400'),
'subsets' => array('khudawadi'),
'category' => 'sans-serif'
),
'Noto Sans Nabataean' => array(
'variants' => array('400'),
'subsets' => array('nabataean'),
'category' => 'sans-serif'
),
'Noto Sans Duployan' => array(
'variants' => array('400'),
'subsets' => array('duployan'),
'category' => 'sans-serif'
),
'Noto Sans Elymaic' => array(
'variants' => array('400'),
'subsets' => array('elymaic'),
'category' => 'sans-serif'
),
'Noto Sans Pahawh Hmong' => array(
'variants' => array('400'),
'subsets' => array('pahawh-hmong'),
'category' => 'sans-serif'
),
'Noto Sans Kharoshthi' => array(
'variants' => array('400'),
'subsets' => array('kharoshthi'),
'category' => 'sans-serif'
),
'Noto Sans Takri' => array(
'variants' => array('400'),
'subsets' => array('takri'),
'category' => 'sans-serif'
),
'Noto Sans Ogham' => array(
'variants' => array('400'),
'subsets' => array('ogham'),
'category' => 'sans-serif'
),
'Neonderthaw' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
)
);