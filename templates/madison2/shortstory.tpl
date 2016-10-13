<div class="news" itemscope itemtype="http://schema.org/Article">
	<article>
		<div class="border-header clearfix">
			<h3 class="fleft" itemprop="name"><a href="{full-link}" title="{title}">{title}</a></h3>
			<span class="fright">{favorites}</span>
			<span class="fright">[edit]<span class="icon edit-news">&nbsp;</span>[/edit]</span>
		</div>
		<div class="news-info clearfix">
			<span class="icon clock" itemprop="datePublished">{date=d.m.Y}</span> 
			<span class="icon user" itemprop="author">{author}</span> 
			<span class="icon preview">{views}</span> 
			<span class="icon comms" ><a href="{full-link}#comment" itemprop="discussionUrl">{comments-num}</a></span> 
			
			<meta itemprop="interactionCount" content="UserPageVisits:{views}" />
			<meta itemprop="interactionCount" content="UserComments:{comments-num}" />
			[tags]
				<div class="icon tags"> {tags}</div>
			[/tags]						
		</div> <!-- .news-info -->
		<div class="news-text clearfix" itemprop="articleBody">
			{short-story}
		</div> <!-- .news-text -->
		<div class="news-footer clearfix">
			<div class="fleft news-info">
				<span class="ir speedbar-arr">Категория:</span> {link-category}
			</div>
			<span class="fright btn" data-target-self="{full-link}">подробнее</span>
			<div class="short-rating">{rating}</div>
		</div>
	</article>
</div> <!-- .news -->
