<!doctype html>
<!--[if IE 8]>
<html {languageAttributes}  class="lang-{$currentLang->locale} {$options->layout->custom->pageHtmlClass} ie ie8">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)]><!-->
<html {languageAttributes} class="lang-{$currentLang->locale} {$options->layout->custom->pageHtmlClass}">
<!--<![endif]-->
<head>
	<meta charset="{$wp->charset}">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="{$wp->pingbackUrl}">

	{if $options->theme->general->favicon != ""}
		<link href="{$options->theme->general->favicon}" rel="icon" type="image/x-icon" />
	{/if}

	{includePart parts/seo}

	{googleAnalytics $options->theme->google->analyticsTrackingId}

	{wpHead}

	{!$options->theme->header->customJsCode}
</head>
<body {!$wp->bodyHtmlClass}>
	{* usefull for inline scripts like facebook social plugins scripts, etc... *}
	{doAction ait-html-body-begin}

	

	<div id="page" class="hfeed page-container">

		<div class="site-header-main">
			<div class="site-header-wrap">

			<header id="masthead" class="site-header" role="banner">

				<div class="site-logo">
					{if $options->theme->header->logo}
					<a href="{$homeUrl}" title="{$wp->name}" rel="home"><img src="{$options->theme->header->logo}" alt="logo"></a>
					{else}
					<div class="site-title"><a href="{$homeUrl}" title="{$wp->name}" rel="home">{$wp->name}</a></div>
					{/if}
				</div>
				<div class="site-desc-wrap">
					<p class="site-description">{$wp->description}</p>
				</div>



			</header><!-- #masthead -->

			
			{includePart parts/header-items}
			
			
			<div class="woo-and-lang-wrapper">
				
				{includePart parts/languages-switcher}
				{includePart "parts/woocommerce-cart"}
			</div>
			
			<div class="menu-container">
				<nav class="main-nav" role="navigation">
					<a class="assistive-text" href="#content" title="{__ 'Skip to content'}">{__ 'Skip to content'}</a>
					<div class="main-nav-wrap">
						<h3 class="menu-toggle">{__ 'Menu'}</h3>
						{menu main}
					</div>
				</nav>
			</div>



			<div class="sticky-menu menu-container" >
				<div class="grid-main">
					<div class="site-logo">
						{if $options->theme->header->logo}
						<a href="{$homeUrl}" title="{$wp->name}" rel="home"><img src="{$options->theme->header->logo}" alt="logo"></a>
						{else}
						<div class="site-title"><a href="{$homeUrl}" title="{$wp->name}" rel="home">{$wp->name}</a></div>
						{/if}
					</div>
					<nav class="main-nav">
						<!-- wp menu here -->
					</nav>
				</div>
			</div>
			<div class="site-tools">
				<div class="grid-main">
					{includePart parts/social-icons}
				</div>
			</div>
		</div><!-- .site-header-wrap -->
		
			{if $options->layout->general->enableWidgetArea}
			<div id="header-secondary-left" class="header-widgets" >
				<div class="header-widget-button"></div>
				<div class="header-widgets-wrap ">
					<div class="header-widgets-container">
						
						{foreach $wp->widgetAreas(header) as $widgetArea}
							{* uncomment condition to hide empty widget areas completely *}
							{* {if $wp->isWidgetAreaActive($widgetArea)} *}
							<div class="widget-area {$widgetArea} widget-area-{$iterator->counter}">
								{widgetArea $widgetArea}
							</div>
							{* {/if} *}
						{/foreach}

					</div>
				</div>
			</div>
			{/if}