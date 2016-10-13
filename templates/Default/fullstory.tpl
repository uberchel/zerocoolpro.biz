<div class="base shortstory">
	<div class="dpad">
		<h2 itemprop="name">[full-link]{title}[/full-link]</h2>
		<div class="bhinfo">

		[not-group=5]
	<div class="btn pull-right">
		<span>[edit]Редактировать[/edit]</span>

	</div>	
			
		[/not-group]

<dl class="article-info  muted">

		
			<dt class="article-info-term">
													Подробности							</dt>

							<dd class="createdby" itemprop="author">
					Автор: {author}	</dd>
			
			
			
										<dd class="published">
				<span class="icon-calendar"></span>
				<time itemprop="datePublished">
					Опубликовано: [day-news]{date}[/day-news]		</time>
			</dd>			

										<dd class="category">
				<span class="icon-calendar"></span>
				<time itemprop="datePublished">
					<strong>Категория: {link-category}</strong>		</time>
			</dd>			
					
			
						</dl>


		</div><br><br>
		<div class="maincont">
			{full-story}
			<div class="clr"></div>
		</div>
	</div>


[related-news]<div class="items-more" style="padding-left: 15px;">
	
<div class="dtop"><span><b>Другие новости по теме:</b></span></div>		
<ol class="nav nav-tabs nav-stacked">
	<li>
		
			{related-news}
	</li>
</ol>
</div>[/related-news]


	<div class="rt-block fp-roksprocket-headlines box2" style="padding-bottom: 3px;">
	<div class="module-title" style="vertical-align: middle;">
		[tags]<span style="position: absolute">Теги: {tags}</span>[/tags]
		<p style="text-align: right; margin: 2 auto;">Просмотров: <strong>{views}</strong> | Комментариев: <strong>{comments-num}</strong></p>
	</div>
	</div>
</div>

<a class="readon" href="#" onclick="$('#addcform').toggle();return false;" style="margin-left: 15px;"><b>Оставить комментарий</b></a>

{addcomments}
<br>
{comments}
{navigation}