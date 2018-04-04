{* ********************************************************* *}
{* COMMON DATA                                               *}
{* ********************************************************* *}

	{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}

	{var $titleClass = ''}
	{var $titleName = ''}
	{var $editButton = ''}
	{var $titleImage = ''}
	{var $dateIcon = ''}
	{var $dateLinks = ''}
	{var $dateShort = ''}
	{var $dateInterval = ''}
	{var $titleAuthor = ''}
	{var $titleCategory = ''}
	{var $titleComments = ''}
	{var $titleSubDesc = ''}
	{var $titleDesc = $el->option(description)}
	{var $showPager = ''}


{* ********************************************************* *}
{* for 404, SEARCH and WOOCOMMERCE                           *}
{* ********************************************************* *}

{if $wp->is404 or $wp->isSearch or $wp->isWoocommerce()}

	{* CLASS ********** *} {if $wp->is404}				{var $titleClass = "simple-title"} {/if}
	{* CLASS ********** *} {if $wp->isSearch}			{var $titleClass = "simple-title"} {/if}
	{* CLASS ********** *} {if $wp->isWoocommerce()}	{var $titleClass = "simple-title"} {/if}

	{* TITLE ********** *} {if $wp->is404}				{capture $titleName}{__ "This is somewhat embarrassing, isn't it?"}{/capture}			{/if}
	{* TITLE ********** *} {if $wp->isSearch}			{capture $titleName}
															{capture $searchTitle}<span class="title-data">{$wp->searchQuery}</span>{/capture}
															{!__ 'Search Results for: %s'|printf: $searchTitle}
														{/capture}																				{/if}
	{* TITLE ********** *} {if $wp->isWoocommerce()}	{capture $titleName}{? woocommerce_page_title()}{/capture}								{/if}

{* ********************************************************* *}
{* for PAGES, POST DETAIL, IMAGE DETAIL and PORTFOLIO DETAIL *}
{* for LOOP pages only                                       *}
{* ********************************************************* *}

{elseif $wp->isPage or $wp->isSingular(post) or $wp->isSingular(portfolio-item) or $wp->isSingular(event) or $wp->isSingular(job-offer) or $wp->isAttachment}
{loop as $post}

	{* CLASS ********** *} {if $wp->isPage} 					{var $titleClass = "standard-title"} 				{/if}
	{* CLASS ********** *} {if $wp->isSingular(post)} 			{var $titleClass = "post-title"} 					{/if}
	{* CLASS ********** *} {if $wp->isSingular(portfolio-item)} {var $titleClass = "post-title portfolio-title"} 	{/if}
	{* CLASS ********** *} {if $wp->isSingular(event)} 			{var $titleClass = "post-title event-title"} 		{/if}
	{* CLASS ********** *} {if $wp->isSingular(job-offer)} 		{var $titleClass = "post-title job-offer-title"}	{/if}
	{* CLASS ********** *} {if $wp->isAttachment}				{var $titleClass = "post-title attach-title"}		{/if}

	{* META DATA ****** *} {if $wp->isSingular(event)}			{var $meta = $post->meta(event-data)}
						   {elseif $wp->isSingular(job-offer)}	{var $meta = $post->meta(offer-data)}
						   {/if}

	{* TITLE ********** *} {var $titleName = $post->title}
	{* IMAGE ********** *} {var $titleImage = $post->imageUrl}
						   {if $wp->isAttachment or $wp->isSingular(portfolio-item) or $wp->isSingular(job-offer)} {var $titleImage = ''} {/if}
	{* EDIT *********** *} {capture $editButton}{!$post->editLink($editLinkLabel)}{/capture}

	{* DATE ICON ****** *} {if $wp->isSingular(post)} 			{var $dateIcon = $post->rawDate}  		{var $dateLinks = 'yes'}	{var $dateShort = 'no'} {/if}
	{* DATE ICON ****** *} {if $wp->isSingular(portfolio-item)} {var $dateIcon = $post->rawDate} 		{var $dateLinks = 'no'} 	{var $dateShort = 'no'} {/if}
	{* DATE ICON ****** *} {if $wp->isSingular(event)} 			{var $dateIcon = $meta->dateFrom} 		{var $dateLinks = 'no'} 	{var $dateShort = 'no'} {/if}
	{* DATE ICON ****** *} {if $wp->isSingular(job-offer)} 		{var $dateIcon = $meta->validFrom} 		{var $dateLinks = 'no'} 	{var $dateShort = 'no'} {/if}
	{* DATE ICON ****** *} {if $wp->isAttachment} 				{var $dateIcon = $post->rawDate}  		{var $dateLinks = 'no'}		{var $dateShort = 'no'} {/if}

	{* DATE INTERVAL ** *} {if $wp->isSingular(event)}			{capture $intLabel}{__ 'Duration:'}{/capture}
																{var $intFrom = $meta->dateFrom}
																{var $intTo = $meta->dateTo}
																{if $intTo}{var $dateInterval = 'yes'}{/if}
						   {/if}
	{* DATE INTERVAL ** *} {if $wp->isSingular(job-offer)}		{capture $intLabel}{__ 'Validity:'}{/capture}
																{var $intFrom = $meta->validFrom}
																{var $intTo = $meta->validTo}
																{var $dateInterval = 'yes'}
						   {/if}

	{* AUTHOR ********* *} {if $wp->isSingular(post)} 			{var $titleAuthor = 'yes'} {/if}
	{* AUTHOR ********* *} {if $wp->isAttachment} 				{var $titleAuthor = 'yes'} {/if}

	{* CATEGORY ******* *} {if $post->categoryList}				{var $titleCategory = 'yes'} {/if}
	{* COMMENTS ******* *} {if $wp->isSingular(post)}			{var $titleComments = 'yes'} {/if}

	{* PAGER ********** *} {if $wp->isSingular(post)} 			{var $showPager = 'yes'} {/if}
{/loop}

{* ********************************************************* *}
{* for BLOG PAGE ONLY                                        *}
{* ********************************************************* *}

{elseif $wp->isBlog and $blog}

	{* CLASS ********** *} {var $titleClass = "blog-title"}
	{* TITLE ********** *} {var $titleName = $blog->title}
	{* IMAGE ********** *} {var $titleImage = $blog->imageUrl}
	{* EDIT *********** *} {capture $editButton}{!$blog->editLink($editLinkLabel)}{/capture}

{* ********************************************************* *}
{* for CATEGORY, ARCHIVE, TAG and AUTHOR                     *}
{* ********************************************************* *}

{elseif $wp->isCategory or $wp->isArchive or $wp->isTag or $wp->isAuthor or $wp->isTax(portfolios)}

	{* CLASS ********** *} {var $titleClass = "archive-title"}

	{* TITLE ********** *} {if $wp->isCategory}					{capture $titleName}
																	{capture $categoryTitle}<span class="title-data">{$category->title}</span>{/capture}
																	{!__ 'Category Archives: %s'|printf: $categoryTitle}
																{/capture}
	{* TITLE ********** *} {elseif $wp->isTag}					{capture $titleName}
																	{capture $tagTitle}<span class="title-data">{$tag->title}</span>{/capture}
																	{!__ 'Tag Archives: %s'|printf: $tagTitle}
																{/capture}
	{* TITLE ********** *} {elseif $wp->isPostTypeArchive}		{capture $titleName}
																	{capture $archiveTitle}<span class="title-data">{$archive->title}</span>{/capture}
																	{!__ 'Archives: %s'|printf: $archiveTitle}
																{/capture}
	{* TITLE ********** *} {elseif $wp->isTax}					{capture $titleName}
																	{capture $taxonomyTitle}<span class="title-data">{$taxonomyTerm->title}</span>{/capture}
																	{!__ 'Category Archives: %s'|printf: $taxonomyTitle}
																{/capture}
	{* TITLE ********** *} {elseif $wp->isAuthor}				{capture $titleName}
																	{capture $authorTitle}<span class="title-data">{$author}</span>{/capture}
																	{!__ 'All posts by %s'|printf: $authorTitle}
																{/capture}
	{* TITLE ********** *} {elseif $wp->isArchive}
								{if $archive->isDay}			{capture $titleName}
																	{capture $dayTitle}<span class="title-data">{$archive->date('F j, Y')|dateI18n}</span>{/capture}
																	{!__ 'Daily Archives: %s'|printf: $dayTitle}
																{/capture}
								{elseif $archive->isMonth}		{capture $titleName}
																	{capture $monthFormat}{_x 'F Y', 'monthly archives date format'}{/capture}
																	{capture $monthTitle}<span class="title-data">{$archive->date('F j, Y')|dateI18n: $monthFormat}</span>{/capture}
																	{!__ 'Monthly Archives: %s'|printf: $monthTitle}
																{/capture}
								{elseif $archive->isYear}		{capture $titleName}
																	{capture $yearFormat}{_x 'Y',  'yearly archives date format'}{/capture}
																	{capture $yearTitle}<span class="title-data">{$archive->date('F j, Y')|dateI18n: $yearFormat}</span>{/capture}
																	{!__ 'Yearly Archives: %s'|printf: $yearTitle}
																{/capture}
								{else}							{capture $titleName}{!__ 'Archives:'}{/capture}
								{/if}
						   {/if}

	{* SUBDESC ******** *} {if $wp->isCategory}					{var $titleSubDesc = $category->description} 	{/if}
	{* SUBDESC ******** *} {if $wp->isTag}						{var $titleSubDesc = $tag->description} 		{/if}

{/if}


{* ********************* *}
{* RESULTS               *}
{* ********************* *}

<div style="display: none;">
{$titleClass}
{!$titleName}
{!$editButton}
{$titleImage}
{$dateIcon}
{$dateLinks}
{$dateShort}

{if $dateInterval == 'yes'}{$intLabel} {$intFrom|dateI18n} - {$intTo|dateI18n}{/if}
{if $titleAuthor == 'yes'}{includePart parts/entry-author}{/if}
{if $titleCategory == 'yes'}{includePart parts/entry-categories}{/if}
{if $titleComments == 'yes'}{includePart parts/comments-link}{/if}
{!$titleSubDesc}
{!$titleDesc}
</div>


<div class="page-title{if $wp->isSingular(post) and !$titleImage} no-thumbnail{/if}">
	<div class="grid-main">
				<header class="entry-header">

			<div class="entry-title {$titleClass}">

				<h1>{!$titleName}</h1>



				<div class="entry-title-wrap">

				{includePart parts/entry-date-format, dateIcon => $dateIcon, dateLinks => $dateLinks, dateShort => $dateShort}

				</div>
			</div>

			{if $titleImage}
				<div class="entry-thumbnail">
					<div class="entry-thumbnail-wrap">
						<a href="{$titleImage}" class="thumb-link">
							<span class="entry-thumbnail-icon">
								<img src="{imageUrl $titleImage, width => 1000, height => 500, crop => 1}" alt="{$titleName}">
							</span>
						</a>
					</div>
					{if $editButton}
						<div class="entry-meta">
							{!$editButton}
						</div>
					{/if}
					<div class="entry-data-wrap">

					{if $dateInterval == 'yes' or $titleAuthor == 'yes' or $titleCategory == 'yes' or $titleComments == 'yes' or $titleSubDesc}
							{if $dateInterval == 'yes'}
							<div class="entry-data">

								<div class="date-interval">
									<span class="date-interval-title"><strong>{$intLabel}</strong></span>
									<time class="event-from" datetime="{$intFrom|date:c}">{$intFrom|dateI18n}</time>
									<span class="date-sep">-</span>
									<time class="event-to" datetime="{$intTo|date:c}">{$intTo|dateI18n}</time>
								</div>


							</div>
							{/if}
					{/if}
						{if $titleAuthor == 'yes'} 		{includePart parts/entry-author}		{/if}
						{if $titleCategory == 'yes'}	{includePart parts/entry-categories}	{/if}
						{if $post->tagList}			<span class="tags">{!$post->tagList}</span> {/if}
						{if $titleComments == 'yes'}	{includePart parts/comments-link}		{/if}
						{if $titleSubDesc}				{!$titleSubDesc}						{/if}
					</div>
				</div>
			{/if}

			{if $titleDesc}
				<div class="page-description">{!$titleDesc}</div>
			{/if}

			{if $showPager}
			<nav class="nav-single" role="navigation">
				{includePart parts/pagination arrow => left}
				{includePart parts/pagination arrow => right}
			</nav>
			{/if}

		</header><!-- /.entry-header -->
	</div>
</div>





{* **************************** *}
{* OLD PAGE TITLE               *}
{* **************************** *}

{*** KYM NIEJE DOKONCENA NOVA HLAVICKA TAK SI PRI POUZITI VSETKO OD TOHTO MIESTA VYSSIE ZMAZTE !!!! ***}



<div class="page-title" style="display: none">
	<div class="grid-main">
		<header class="entry-header">

		{* ********************************************************* *}
		{* for 404, SEARCH and WOOCOMMERCE                           *}
		{* ********************************************************* *}

		{if $wp->is404 or $wp->isSearch or $wp->isWoocommerce()}

			<div class="entry-title simple-title">
				<div class="entry-title-wrap">

					<h1>
						{if $wp->is404} 			{__ "This is somewhat embarrassing, isn't it?"} {/if}
						{if $wp->isSearch} 			{__ 'Search Results for: %s'|printf: $wp->searchQuery} {/if}
						{if $wp->isWoocommerce()}	{? woocommerce_page_title()} {/if}
					</h1>

				</div><!-- /.entry-title-wrap -->
			</div><!-- /.entry-title -->

		{* ********************************************************* *}
		{* for PAGES, POST DETAIL, IMAGE DETAIL and PORTFOLIO DETAIL *}
		{* for LOOP pages only                                       *}
		{* ********************************************************* *}

		{elseif $wp->isPage or $wp->isAttachment or $wp->isSingular(post) or $wp->isSingular(portfolio-item) or $wp->isSingular(event) or $wp->isSingular(job-offer)}

			{loop as $post}

				{* ********************* *}
				{* for PAGE ONLY         *}
				{* ********************* *}

				{if $wp->isPage}

					<div class="entry-title standard-title">
						<div class="entry-title-wrap">

							<h1>{!$post->title}</h1>

							<div class="entry-meta">
								{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
								{!$post->editLink($editLinkLabel)}
							</div><!-- /.entry-meta -->

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->

					<div class="entry-thumbnail">
						{if $post->hasImage}
							<a href="{$post->imageUrl}" class="thumb-link">
								<span class="entry-thumbnail-icon">
									<img src="{imageUrl $post->imageUrl, width => 1000, height => 500, crop => 1}">
								</span>
							</a>
						{/if}
					</div>
				{/if}

				{* ***************************************** *}
				{* for POST DETAIL and PORTFOLIO DETAIL ONLY *}
				{* ***************************************** *}

				{if $wp->isSingular(post) or $wp->isSingular(portfolio-item) or $wp->isSingular(event) or $wp->isSingular(job-offer)}

					<div class="entry-title post-title">
						{includePart parts/entry-date}
						<div class="entry-title-wrap">

							{if $wp->isSingular(event)}
								{var $meta = $post->meta(event-data)}
								<h1>{!$post->title}</h1>
							{elseif $wp->isSingular(job-offer)}
								{var $meta = $post->meta(offer-data)}
								<h1>{!$post->title}</h1>
							{else}
								<h1>{!$post->title}</h1>
							{/if}

							<div class="entry-data">
								{if $wp->isSingular(event)}
									{var $meta = $post->meta(event-data)}
									{if $meta->dateTo != ''}
										<div class="event-duration">
											<span class="event-dur-title"><strong>{__ 'Duration:'}</strong></span>
											<time class="event-from" datetime="{$meta->dateFrom|date:c}">{$meta->dateFrom|dateI18n}</time>
											<span class="date-sep">-</span>
											<time class="event-to" datetime="{$meta->dateTo|date:c}">{$meta->dateTo|dateI18n}</time>
										</div>
									{/if}
								{/if}

								{if $wp->isSingular(job-offer)}
									{var $meta = $post->meta(offer-data)}
									<div class="offer-duration">
										<span class="offer-dur-title"><strong>{__ 'Validity:'}</strong></span>
										<time class="offer-from" datetime="{$meta->validFrom|date:c}">{$meta->validFrom|dateI18n}</time>
										<span class="date-sep">-</span>
										<time class="offer-to" datetime="{$meta->validTo|date:c}">{$meta->validTo|dateI18n}</time>
									</div>
								{/if}

								{if $post->type == post}
									{includePart parts/entry-author}
								{/if}

								{if $post->categoryList}
									{includePart parts/entry-categories}
								{/if}

								{includePart parts/comments-link}
							</div>

							<div class="entry-meta">
								{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
								{!$post->editLink($editLinkLabel)}
							</div><!-- /.entry-meta -->

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->

					{if $wp->isSingular(portfolio-item) or $wp->isSingular(job-offer)}

					{else}
					<div class="entry-thumbnail">
						{if $post->hasImage}
							<div class="entry-thumbnail-wrap">
								<a href="{$post->imageUrl}" class="thumb-link">
									<span class="entry-thumbnail-icon">
										<img src="{imageUrl $post->imageUrl, width => 1000, height => 500, crop => 1}" alt="{!$post->title}">
									</span>
								</a>
							</div>
						{/if}
					</div>
					{/if}
				{/if}

				{* ********************* *}
				{* for IMAGE DETAIL ONLY *}
				{* ********************* *}

				{if $wp->isAttachment}

					<div class="entry-title attach-title">
						<div class="entry-title-wrap">

							<h1>{!$post->title}</h1>

							{if $post->attachment->isImage or $post->attachment->isVideo or $post->attachment->isAudio}
							<div class="entry-data">
								{!__ '
									<span class="meta-prep meta-prep-entry-date">Published</span>
									<time class="meta-date" datetime="%1$s">%2$s</time>
									at
									<a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in
									<a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>.
								'|printf:
										$post->date('c'),
										$post->dateI18n,
										$post->attachment->url,
										$post->attachment->width,
										$post->attachment->height,
										$post->parent->permalink,
										$post->parent->title
								}
							</div><!-- .entry-data -->
							{/if}

							<div class="entry-meta">
								{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
								{!$post->editLink($editLinkLabel)}
							</div><!-- /.entry-meta -->

							{if $post->attachment->isImage}
							<nav id="image-navigation" class="navigation" role="navigation">
								{capture $prev}{!__ '&larr; Previous'}{/capture}
								{capture $next}{!__ 'Next &rarr;'}{/capture}

								<span class="previous-image">{prevImageLink false, $prev}</span>
								<span class="next-image">{nextImageLink false, $next}</span>
							</nav><!-- #image-navigation -->
							{/if}

						</div><!-- /.entry-title-wrap -->
					</div><!-- /.entry-title -->

				{/if}

			{/loop}

		{* ********************************************************* *}
		{* for BLOG PAGE ONLY                                        *}
		{* ********************************************************* *}

		{elseif $wp->isBlog and $blog}

			<div class="entry-title blog-title">
				<div class="entry-title-wrap">

					<h1>{!$blog->title}</h1>

					<div class="entry-meta">
						{capture $editLinkLabel}<span class="edit-link">{!__ 'Edit'}</span>{/capture}
						{!$blog->editLink($editLinkLabel)}
					</div><!-- /.entry-meta -->

				</div><!-- /.entry-title-wrap -->
			</div><!-- /.entry-title -->

			<div class="entry-thumbnail">
				{if $blog->hasImage}
					<a href="{$post->imageUrl}" class="thumb-link">
						<span class="entry-thumbnail-icon">
							<img src="{imageUrl $post->imageUrl, width => 1000, height => 500, crop => 1}">
						</span>
					</a>
				{/if}
			</div>

		{* ********************************************************* *}
		{* for CATEGORY, ARCHIVE, TAG and AUTHOR                     *}
		{* ********************************************************* *}

		{elseif $wp->isCategory or $wp->isArchive or $wp->isTag or $wp->isAuthor or $wp->isTax(portfolios)}

			<div class="entry-title archive-title">
				<div class="entry-title-wrap">

					<h1>
						{if $wp->isCategory}		{__ 'Category Archives: %s'|printf: $category->title}

						{elseif $wp->isTag}			{__ 'Tag Archives:'} <span>{$tag->title}</span>

						{elseif $wp->isPostTypeArchive}	{__ 'Archives: %s'|printf: $archive->title}

						{elseif $wp->isAuthor}			{capture $authorTitle}
														<span class="vcard">
															<a class="url fn n" href="{$author->postsUrl}" title="{$author}" rel="me">{$author}</a>
														</span>
													{/capture}
													{!__ 'All posts by %s'|printf: $authorTitle}

						{elseif $wp->isArchive}		{if $archive->isDay}		{__ 'Daily Archives: %s'|printf:''}{$archive->date|dateI18n}
													{elseif $archive->isMonth}	{capture $monthFormat}{_x 'F Y', 'monthly archives date format'}{/capture}
																				{__ 'Monthly Archives: %s'|printf: ''}{$archive->date|dateI18n: $monthFormat}
													{elseif $archive->isYear}	{capture $yearFormat}{_x 'Y',  'yearly archives date format'}{/capture}
																				{__ 'Yearly Archives: %s'|printf: ''}{$archive->date|dateI18n: $yearFormat}
													{/if}
						{/if}
					</h1>

					{if $wp->isCategory and $category->description}
						<div class="entry-data">{!$category->description}</div>
					{/if}

					{if $wp->isTag and $tag->description}
						<div class="entry-data">{!$tag->description}</div>
					{/if}

				</div><!-- /.entry-title-wrap -->
			</div><!-- /.entry-title -->

		{/if}

		{if $el->option(description)}
			<div class="page-description">
				{!$el->option(description)}
			</div>
		{/if}

		</header><!-- /.entry-header -->
	</div>
</div>
