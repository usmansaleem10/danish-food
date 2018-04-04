{getHeader}

	{if $elements->unsortable[revolution-slider]->display}
		{includeElement $elements->unsortable[revolution-slider]}
	{/if}

	</div><!-- .site-header-main -->

	{if $elements->unsortable[background-slider]->display}
		{includeElement $elements->unsortable[background-slider]}
	{/if}
	{if $options->theme->general->mainbgImg}
	<div class="main-bg-image">
		{$options->layout->custom->pageHtmlClass}
	</div>
	{/if}
<div id="main" class="elements">

	<div class="page-sections">
	{if $elements->unsortable[page-title]->display}
		{includeElement $elements->unsortable[page-title]}
	{/if}

	{includePart parts/breadcrumbs}

	<div class="main-sections">
	{foreach $elements->sortable as $element}

		{if $element->id == sidebars-boundary-start}

		<div class="elements-with-sidebar">
			<div class="elements-sidebar-wrap">
				{if $wp->hasSidebar(left)}
					{getSidebar left}
				{/if}
				<div class="elements-area">

		{elseif $element->id == sidebars-boundary-end}

				</div><!-- .elements-area -->
				{if $wp->hasSidebar(right)}
					{getSidebar}
				{/if}
				</div><!-- .elements-sidebar-wrap -->
			</div><!-- .elements-with-sidebar -->

		{else}
			{? global $post}
			{if $element->id == 'comments' && $post == null}
				<!-- COMMENTS DISABLED - IS NOT SINGLE PAGE -->
			{elseif $element->id == 'comments' && !comments_open($post->ID) && get_comments_number($post->ID) == 0}
				<!-- COMMENTS DISABLED -->
			{else}
				<section n:if="$element->display" id="{$element->htmlId}-main" class="{$element->htmlClasses}">

					<div class="elm-wrapper {$element->htmlClass}-wrapper">

						{includeElement $element}

					</div><!-- .elm-wrapper -->

				</section>
			{/if}
		{/if}
	{/foreach}
	</div><!-- .main-sections -->
	</div>

</div><!-- #main .elements -->
			
<div class="site-iconmenu">
	<div class="iconmenu-container {if $options->theme->iconmenu->enableIcons and $options->theme->iconmenu->Icons}iconmenu-on{else}iconmenu-off{/if}">

		{if $options->theme->iconmenu->enableIcons and $options->theme->iconmenu->Icons}
			<div class="iconmenu">
				<ul class="iconmenu-items">
					{foreach $options->theme->iconmenu->Icons as $icon}
						{var $class = $iterator->counter == 1 ? 'iconmenu-box-active' : ''}
						<li class="iconmenu-box {$class}">
							{if $icon->url}<a href="{$icon->url}">{/if}
								<span class="item-color" {if $icon->color}style="background-color: {!$icon->color};"{/if}>
									{if $icon->title}<h6 class="i-title"{if $icon->color}style="color: {!$icon->titleColor};"{/if}>{!$icon->title}</h6>{/if}
								</span>
								<div class="iconmenu-wrap">

									{if $icon->icon}
									<div class="i-thumb">
										<div class="i-thumbnail">
										<img src="{imageUrl $icon->icon, width => 300, height => 300, crop => 1}" class="i-thumb-img" alt="{$icon->title}" />
										</div>
									</div>
									{/if}
									{if $icon->text}<p class="i-text">{!$icon->text}</p>{/if}
								</div>
							{if $icon->url}</a>{/if}
						</li>
					{/foreach}
				</ul>
				<div class="item-navigation">
					<a href="#" class="item-navigation-prev"></a>
					<a href="#" class="item-navigation-next"></a>
				</div>
			</div>
		{/if}

	</div>
</div>

{getFooter}