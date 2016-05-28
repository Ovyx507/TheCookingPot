<? echo $title ?>
<br/>
<div id="add-ingredients-form">
<form name="input" method="post" enctype="multipart/form-data">
	<input type="text" class="form-control" placeholder="Insert ingredient name here" name="name">
	<br/>
	 <input type="number" class="form-control" min="0" step="1" placeholder="Insert calories here for 100g" name="calories">
	<br/>
	<input type="file" name="image">
	<br/>
	<input type="submit" class="btn btn-default" value="Insert Ingredient">
	<?
	if ($vars['success']) {?>
	<div class="alert alert-success">
		<strong>Success!</strong>
	</div>
	<?}?>
	<script> 
	$(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
	});
	</script>
</form>
</div>