
	{if !$wp->isSingular}

		{if $wp->isSearch}

			{*** SEARCH RESULTS ONLY ***}

			<article {!$post->htmlId} {!$post->htmlClass}>
				<header class="entry-header">

					<div class="entry-title">

						{var $dateIcon = $post->date('c')}
						{var $dateLinks = 'no'}
						{var $dateShort = 'no'}

						{includePart parts/entry-date-format, dateIcon => $dateIcon, dateLinks => $dateLinks, dateShort => $dateShort}

						<div class="entry-title-wrap">

							<h2><a href="{$post->permalink}">{!$post->title}</a></h2>

							{if $post->isInAnyCategory}
								{includePart parts/entry-categories}
							{/if}

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->
				</header><!-- /.entry-header -->

				<div	 class="entry-content loop">
					{!$post->excerpt}
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<a href="{$post->permalink}" class="more">{!__ '%s read more'|printf: '<span class="meta-nav">&rarr;</span>'}</a>
				</footer><!-- /.entry-footer -->
				<div class="blog-line"></div>
			</article>

		{else}

			{*** STANDARD LOOP ***}
			<article {!$post->htmlId} {!$post->htmlClass}>

				<div class="entry-thumbnail">
					{if $post->hasImage}
						<div class="entry-thumbnail-wrap entry-content">
						<a href="{$post->permalink}" class="thumb-link">
							<span class="entry-thumbnail-icon">
								<img src="{imageUrl $post->imageUrl, width => 900, height => 600, crop => 1}">
							</span>
						</a>
						</div>
					{/if}

					<div class="entry-meta">
						{if $post->isSticky and !$wp->isPaged and $wp->isHome}
							<span class="featured-post">{__ 'Featured post'}</span>
						{/if}

						{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
      					{!$post->editLink($editLinkLabel)}
					</div><!-- /.entry-meta -->
				</div>

				<div class="post-right-wrap">
					<header class="entry-header {if !$post->hasImage}nothumbnail{/if}">


						<div class="entry-title">

							<div class="entry-title-wrap">

								<h2><a href="{$post->permalink}">{!$post->title}</a></h2>

							</div><!-- /.entry-title-wrap -->

						</div><!-- /.entry-title -->
						
						<div class="entry-data">

							{var $dateIcon = $post->date('c')}
							{var $dateLinks = 'no'}
							{var $dateShort = 'no'}

							{includePart parts/entry-date-format, dateIcon => $dateIcon, dateLinks => $dateLinks, dateShort => $dateShort}

							{if $post->tagList}
								<span class="tags">
									{__ ''} <span class="tags-links">{!$post->tagList}</span>
								</span>
							{/if}

							{if $post->type == post}
								{includePart parts/entry-author}
							{/if}

							{includePart parts/comments-link}

						</div>						

					</header><!-- /.entry-header -->


					<div class="entry-content loop">
						{!$post->excerpt(100)}
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<a href="{$post->permalink}" class="more">{!__ ' read more'}</a>
					</footer><!-- .entry-footer -->
					<div class="blog-line"></div>
				</div>

			</article>
		{/if}

	{else}

		{*** POST DETAIL ***}

		<article {!$post->htmlId} class="content-block">

			<div class="entry-content">
				{!$post->content}
				{!$post->linkPages}
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				{if $wp->isSingle and $post->author->bio and $post->author->isMulti}
					{includePart parts/author-bio}
				{/if}
			</footer><!-- .entry-footer -->
		</article>

	{/if}
