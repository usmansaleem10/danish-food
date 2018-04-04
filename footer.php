{var $noEmptyWidgets = 0}
{foreach $wp->widgetAreas(footer) as $widgetArea}
	{if $wp->isWidgetAreaActive($widgetArea)} {var $noEmptyWidgets = $noEmptyWidgets + 1} {/if}
{/foreach}

	<div class="footer-container">
		<footer id="footer" class="footer" role="contentinfo">

			{if $options->layout->general->enableWidgetAreas AND $noEmptyWidgets > 0}
			<div class="footer-widgets">
				<div class="footer-widgets-wrap grid-main">
					<div class="footer-widgets-container">


						{foreach $wp->widgetAreas(footer) as $widgetArea}
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

		</footer><!-- /#footer-widgets -->
		
		<div class="site-footer">
		<div class="site-footer-wrap grid-main">
			{menu footer, depth => 1}
				<div class="footer-text">{!$options->theme->footer->text}</div>
		</div>

		</div><!-- /#site-footer -->
	</div>
</div><!-- /#page -->

{wpFooter}

{!$options->theme->footer->customJsCode}



</body>
</html>
