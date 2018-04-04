{if $post->hasCommentsOpen}
	<div class="comments-link">
		<a href="{$post->commentsUrl}" title="{__ 'Comments on %s'|printf: $post->title}">
			{if $post->commentsNumber > 1}
				<span class="comments-count" title="{__ '%d Comments'|printf: $post->commentsNumber}">
					{$post->commentsNumber} Comments
				</span>
			{elseif $post->commentsNumber == 0}
				<span class="comments-count" title="{__ 'Leave a comment'}">
					0 Comments
				</span>
			{else}
				<span class="comments-count" title="{__ '1 Comment'}">
					1 Comments
				</span>
			{/if}
		</a>
	</div><!-- .comments-link -->
{/if}