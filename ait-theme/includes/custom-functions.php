<?php

function hasElements($elements)
{
	$disabledColumns = array();
	global $post;
	$opts = aitOptions()->getOptionsByType('layout');
	if ($opts['@sidebars']['right']['sidebar'] != 'none') return true;
	foreach ($elements as $element) {
		if($element->id == 'sidebars-boundary-start' || $element->id == 'sidebars-boundary-end') continue;
		elseif($element->id == 'comments' && $post == null) continue;
		elseif($element->id == 'comments' && !comments_open($post->ID) && get_comments_number($post->ID) == 0) continue;
		elseif($element->id == 'page-title' && $element->display) return true;
		elseif($element->id == 'columns' && !$element->display) {
			array_push($disabledColumns, str_replace('elm-columns-', '', $element->getHtmlId()));
			continue;
		}
		elseif ($element->sortable && $element->display) {
			$elOptions = $element->getOptions();
			$colId = $elOptions['@columns-element-index'];
			if ($colId && in_array($colId, $disabledColumns)) {
				continue;
			}
			else {
				return true;
			}
		}
	}
	return false;
}



add_filter( 'post_class', 'aitAddCustomPostClass', 10 );
function aitAddCustomPostClass($classes)
{
	global $post;
	if (!has_post_thumbnail( $post->ID )) {
		$classes[] = 'no-thumbnail';
	}
	return $classes;
}



add_filter('body_class', 'addCustomBodyClass', 10, 2);
function addCustomBodyClass($classes, $class)
{
	$oid = aitOptions()->getOid();
	$o = aitOptions()->getOptions($oid);
	$elements = aitManager('elements')->createElementsFromOptions($o['elements'], $oid, true);

	if (!hasElements($elements)) {
		$classes[] = 'empty-page';
	}
	return $classes;
}



function getSidebarTitle($id)
{
	$sidebarManager = AitTheme::getManager('sidebars');
	$sidebars = $sidebarManager->getSidebars();
	return AitLangs::getCurrentLocaleText($sidebars[$id]['name'], '');
}


function mydump($variables)
{
  if (!is_array($variables)) {

    $variables = (array)$variables;
  }
  ob_clean();
  foreach ($variables as $variable) {
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
  }
  exit();
}


 ?>