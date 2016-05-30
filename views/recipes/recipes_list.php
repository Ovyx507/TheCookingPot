<style>
.list-group-item {
display:list-item;
}
</style>
</br>
<div class="row">
<div id="titlu" class="text-center">
<h1>Toate Retetele</h1>
</div>
</div>
<hr>
<div class="row">
<div class="ladder">
 <ol class="list-group" type="1">
 <?foreach($vars['rows'] as $k => $row) {?>
  <li class="list-group-item">
  	<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/thumbs/<? echo $row['photo']; ?>" alt="Flower" width="280" height="280">
	<a style="text-decoration:none" href="/thecookingpot/recipes?id=<? echo $row['id'] ?>"><? echo $row['name']?> - <? echo $row['username'] != null ? $row['username'] : $row['name_u']; ?></a>
	<div class="recipe-headerfooter">
	Last modified at <? echo date("Y-m-d H:i:s",$row['date_modified']) ?>, <? echo $row['nr_likes'] == 1 ? $row['nr_likes'].' person likes this' : $row['nr_likes'].' people like this'; ?> recipe
	</div>
  </li>
 <?}?>
</ol>
</div>