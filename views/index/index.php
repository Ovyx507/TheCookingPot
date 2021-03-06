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
.carousel-control 			 { width:  4%; }
.carousel-control.left,.carousel-control.right {margin-left:15px;background-image:none;}
@media (max-width: 767px) {
	.carousel-inner .active.left { left: -100%; }
	.carousel-inner .next        { left:  100%; }
	.carousel-inner .prev		 { left: -100%; }
	.active > div { display:none; }
	.active > div:first-child { display:block; }

}
@media (min-width: 767px) and (max-width: 992px ) {
	.carousel-inner .active.left { left: -50%; }
	.carousel-inner .next        { left:  50%; }
	.carousel-inner .prev		 { left: -50%; }
	.active > div { display:none; }
	.active > div:first-child { display:block; }
	.active > div:first-child + div { display:block; }
}
@media (min-width: 992px ) {
	.carousel-inner .active.left { left: -25%; }
	.carousel-inner .next        { left:  25%; }
	.carousel-inner .prev		 { left: -25%; }	
}

.carousel-caption {
	background-color: rgba(0,0,0,0.55);
	right: 0 !important;
	left: 5.5% !important;
	bottom: 0 !important;
	width: 98.3%;
	height: 28%;
}

</style>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-type="multi" data-interval="3000">
		<div class="carousel-inner" role="listbox">
			  <? foreach($vars['rows'] as $k => $recipe) { ?>
					<div class="item <? echo $k==1 ? 'active' : ''; ?>">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/thumbs/<? echo $recipe['photo']; ?>" alt="Flower" width="280" height="280">
							<a style="text-decoration:none" href="/thecookingpot/recipes?id=<? echo $recipe['id'] ?>"><div class="carousel-caption">
								<h4>
									<? echo $recipe['name']; ?>
								</h4>
								<? echo $recipe['username'] != null ? $recipe['username'] : $recipe['name_u']; ?>
							</div></a>
						</div>
					</div>
			<? } ?>
		</div>

		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		</a>

		<script> 
			$('.carousel[data-type="multi"] .item').each(function(){
  			var next = $(this).next();
  			if (!next.length) {
   			 	next = $(this).siblings(':first');
  			}
  			next.children(':first-child').clone().appendTo($(this));
  
  			for (var i=0;i<2;i++) {
    			next=next.next();
    			if (!next.length) {
    			next = $(this).siblings(':first');
  			}
    
    		next.children(':first-child').clone().appendTo($(this));
  			}
			});
		</script>
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col-lg-4" style="padding-right:20px;border-right:1px solid #ccc;">
			 <p>
			 	<h4 style="text-align:center">
			 		<span class="glyphicon glyphicon-calendar"></span> TOP THIS WEEK
			 	</h4>
			 	<?foreach($vars['rows'] as $k => $row) {?>
  					<li class="list-group-item">
  						<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/micro/<? echo $row['photo']; ?>" alt="Flower">
						<a style="text-decoration:none" href="/thecookingpot/recipes?id=<? echo $row['id'] ?>"><? echo $row['name']?> - <? echo $row['username'] != null ? $row['username'] : $row['name_u']; ?></a>
						<div class="recipe-headerfooter">
						Created at <? echo date("d/m/Y",$row['date_created']) ?>, <? echo $row['nr_likes'] == 1 ? $row['nr_likes'].' person likes this' : $row['nr_likes'].' people like this'; ?> recipe
						</div>
  					</li>
 				<?}?>
			 </p>
		</div>
		<div class="col-lg-4" style="padding-right:20px;border-right:1px solid #ccc;">
			 <p>
			 	<h4 style="text-align:center">
			 		<span class="glyphicon glyphicon-fire"></span> HOT
			 	</h4>
			 	<?foreach($vars['rows'] as $k => $row) {?>
  					<li class="list-group-item">
  						<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/micro/<? echo $row['photo']; ?>" alt="Flower">
						<a style="text-decoration:none" href="/thecookingpot/recipes?id=<? echo $row['id'] ?>"><? echo $row['name']?> - <? echo $row['username'] != null ? $row['username'] : $row['name_u']; ?></a>
						<div class="recipe-headerfooter">
						Created <? echo $this->_req->m_recipes->time_since(time() - $row['date_created'])?> ago, <? echo $row['nr_likes'] == 1 ? $row['nr_likes'].' person likes this' : $row['nr_likes'].' people like this'; ?> recipe
						</div>
  					</li>
 				<?}?>
			 </p>
		</div>
		<div class="col-lg-4">
			 <p>
			 	<h4 style="text-align:center">
			 		<span class="glyphicon glyphicon-cutlery"></span> BEST POTTERS
			 	</h4>
			 	<ol class="list-group" type="1">
					 <?foreach($vars['useri'] as $user) {?>
 						<li class="list-group-item">
						<? echo $user['name'] ?> - <span style="font-weight:bold;"><? echo $user['title'] ? $user['title'] : 'n/a'; ?></span>
						<span class="badge"><? echo $user['score'] ?></span>
						<? 
						if($user['id'] != $_SESSION['user_id'] && $_SESSION['loggedin'])
						{
							?>		
							<a href="<? echo APP_URL_PRE; ?>useri/concurs_start/<? echo $user['id']; ?>" style="float:right;margin-right:15px;text-decoration:none;cursor:pointer;" class="glyphicon glyphicon-screenshot"></a>
							<? 
						}
						?>
  						</li>
					<?}?>
				</ol>
			 </p>
		</div>
	</div>
</div>