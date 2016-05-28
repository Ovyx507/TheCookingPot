<style>
#id-reteta,#recipe-id-user,#recipe-name,#recipe-description,.p{
	display:inline-block;
    font-family: Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;
    font-weight: bold;
    font-style: normal;
    letter-spacing: -1px;
    color: rgba(0, 0, 0, 0.5);
    text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.4);
    font-size: 25px;
    text-decoration: none;
	line-height: 200%;
}
#container-retete{
	text-align: center;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.1), inset 0 0 1px rgba(255, 255, 255, 0.6);
	display:block;
}
#container{
display:inline-block;
}
#id-reteta{
margin-left:2%;
}
.carousel-inner > .item > img {
    margin: 0 auto;
}
h1,h3{
    font-family: Arial, 'Arial Unicode MS', Helvetica, Sans-Serif;
    font-weight: bold;
    font-style: normal;
    letter-spacing: -1px;
    color: rgba(0, 0, 0, 0.5);
    text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.4);
}
</style>
<div class="container">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner " role="listbox">
			  <? foreach($vars['rows'] as $k => $recipe) { ?>
					<div class="item <? echo $k==1 ? 'active' : ''; ?>">
						<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/thumbs/<? echo $recipe['photo']; ?>" alt="Flower">
						<a style="text-decoration:none" href="/thecookingpot/recipes?id=<? echo $recipe['id'] ?>"><div class="carousel-caption">
							<? echo $recipe['name_u']; ?>
							<br/>
							<? echo $recipe['name']; ?>
						</div></a>
					</div>
			<? } ?>
		</div>

		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		</a>
	</div>
</div>