[searchposts]
[fullresult]
<div class="base shortstory">
	<div class="dpad">
		<h2 itemprop="name">[full-link]{title}[/full-link]</h2>
		<div class="bhinfo">

		[not-group=5]
<div class="icons">	
	<div class="btn-group pull-right">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <span class="icon-cog"></span> <span class="caret"></span> </a>
			<ul class="dropdown-menu">
				<li class="edit-icon"> [edit]Редактировать[/edit] </li>
			</ul>
	</div>	
</div>
			</ul>
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

										<strong><dd class="category">
				<span class="icon-calendar"></span>
				<time itemprop="datePublished">
					Категория: {link-category}		</time>
			</dd>			</strong>
					
			
						</dl>


		</div><br>
		<div class="maincont">
			{short-story}
			<div class="clr"></div>
		</div>
	</div>











	<div class="rt-block fp-roksprocket-headlines box2" style="padding-bottom: 3px;">
	<div class="module-title" style="vertical-align: middle;">
		<span style="position: absolute" class="btn">[full-link]<b>Подробнее</b>[/full-link]</span>
		<p style="text-align: right; margin: 2 auto;">Просмотров: <strong>{views}</strong> | Комментариев: <strong>{comments-num}</strong></p>
	</div>
	</div>
</div>
[/fullresult]
[shortresult]

<div class="dpad searchitem">
	<h3>[full-link]{title}[/full-link]</h3>
	<b>[day-news]{date}[/day-news]</b> | {link-category} | Автор: {author}
</div>
[/shortresult]
[/searchposts]
[searchcomments]
[fullresult]

<div class="bcomment">
	<div class="dtop">
		<div class="lcol"><span><img src="{foto}" alt=""/></span></div>
		<div class="rcol">
			<span class="btn" style="float: right; margin-top:15px;">[fast]<b>Цитата</b>[/fast]</span>
			<ul class="reset">
				<li><h4>{author}</h4></li>
			</ul>
			<ul class="cmsep reset">
				<li>Группа: {group-name}</li>
				<li>{date}</li>
			</ul>
		</div>
		<div class="clr"></div>
	</div>
	<div class=""><div class="">
		[not-group=5]
		<div class="comedit">
			<div class="selectmass">{mass-action}</div>

			<ul class="reset">
				<li>[spam]Спам[/spam]</li>
				<li>[complaint]Жалоба[/complaint]</li>
				<li>[com-edit]Изменить[/com-edit]</li>
				<li>[com-del]Удалить[/com-del]</li>
			</ul>
		</div>
		[/not-group]

	</div>
	<span class="thide">^</span>
	</div>
	<br><br>
	<div class="dcont">
		[aviable=lastcomments]<h3 style="margin-bottom: 0.4em;">{news_title}</h3>[/aviable]
		{comment}
		[signature]<br clear="all" /><div class="signature">--------------------</div><div class="slink">{signature}</div>[/signature]
		<div class="clr"></div>
	</div>
</div>
[/fullresult]
[shortresult]
<div class="dpad searchitem">
	<h3 style="margin-bottom: 0.4em;">{news_title}</h3>
	<b>{date}</b> | Автор: {author}
</div>
[/shortresult]
[/searchcomments]