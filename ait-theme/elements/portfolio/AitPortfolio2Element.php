<?php

/*
 * AIT WordPress Theme Framework
 *
 * Copyright (c) 2013, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */

/**
 * Portfolio Element
 */
class AitPortfolio2Element extends AitElement
{
	public function getHtmlClasses($asString = true)
	{
		$classes = parent::getHtmlClasses(false);
		$classes[] = 'elm-item-organizer-main';

		return $asString ? implode(' ', $classes) : $classes;
	}



	public function getContentPreviewOptions()
	{
		$layout  = $this->option('layout');
		$columns = $this->option(!empty($layout) ? $layout . 'Columns' : 'columns');
		$rows    = $this->option(!empty($layout) ? $layout . 'Rows' : 'rows');

		return array(
			'layout' => !empty($layout) ? $layout : 'box',
			'columns' => !empty($columns) ? $columns : 4,
			'rows' => !empty($rows) ? $rows : 1,
			'content' => false
		);
	}
}
