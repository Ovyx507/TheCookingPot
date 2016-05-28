<? echo $title ?>
<br/>
<div id="titlu" class="text-center">
<h1>Ingredients List</h1>
</div>
<div id="list-ingredients">
<ul class="list-group">
<? foreach($vars['rows'] as $ingredient) { ?>
  <li class="list-group-item">
	<div class="col-sm-2"> <? echo $ingredient['name'] ?> </div>
    <div class="col-sm-2"><span class="label label-default label-pill">KCal : <? echo $ingredient['calories'] ?></span> </div>
	<a href="<? echo APP_URL_PRE; ?>admin/show_edit_ingredient?id=<? echo $ingredient['id'];?>" class="btn btn-warning">Edit</a>
	<button type="button" class="btn btn-danger">Delete</button>
  </li>
<? } ?>
</ul>
</div>