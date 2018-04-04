{var $headItems = $options->theme->header->headItems}


{if is_array($headItems) AND count($headItems) > 0}
<div class="header-items">
<div class="header-items-wrap">

	

		{foreach $headItems as $item}
			<div class="header-item">

				{capture $headerItem}
					
						<div class="item-icon-font"><i class="{$item->mainIcon}"></i></div>
						<div class="item-icon-info">
							<div class="item-label">{$item->label}</div>
							<!--<div class="item-icon-text">{$item->mainText}</div> -->
						
							
						</div>
				{/capture}


				{if $item->url}

					<a href="{$item->url}">
						{$headerItem|noescape}
					</a>

				{else}

					{$headerItem|noescape}

				{/if}
			</div>
		{/foreach}



</div>
</div>
{/if}