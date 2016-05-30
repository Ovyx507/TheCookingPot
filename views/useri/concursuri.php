<style>
.list-group-item {
display:list-item;
}
</style>
</br>
<div class="row">
<div id="titlu" class="text-center">
<h1>Concursuri active</h1>
</div>
</div>
<hr>
<div class="row">
<div class="ladder">
 <ol class="list-group" type="1">
 <?foreach($vars['rows'] as $k => $row) {?>
  <li class="list-group-item">
	<a href="<? echo APP_URL_PRE.'useri/concurs/'.$row['id']; ?>">Concurs #<? echo $k; ?></a>
  </li>
 <?}?>
</ol>
</div>