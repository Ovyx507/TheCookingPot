<link rel="stylesheet" type="text/css" href="../css/recipe.css">
<br/>
<div id="add-recipe-form">
<form name="input" method="post" enctype="multipart/form-data">
	<input type="text" class="form-control" placeholder="Insert title here" name="name">
	<br/>
	<textarea class="form-control" rows="3" placeholder="Insert Description here" name="description"></textarea>
	<br/>
	<textarea class="form-control" rows="6" placeholder="Insert ingredients here" name="ingredients"></textarea>
	<br/>
	<? echo H_form_bs::input_file('photo','', array('title' => 'Photo')); ?>
	<br/>
	<input type="submit" class="btn btn-default" value="Match Ingredients">
	<input type="submit" class="btn btn-default" value="Insert Recipe">
</form>
</div>

<? if (!empty($vars['matched_ingredient_list'])) { ?>
<div id="matched-ingredient-list-form">
<form name="matched-ingredient-list" method="get">
	<ul>
		<? foreach ($vars['matched_ingredient_list'] as $ingredient) { ?>
			<li>
			<section class="matched-ingredient">
				<svg height="50" width="50">
				  <g transform="scale(0.5)">
				    <? if ($ingredient['success']) { ?>
						<polygon points="20,40 33,62 80,20 30,80" style="fill:green"/>
					<? } else { ?>
						<polygon points="20,20 50,43 80,20 57,50 80,80 50,57 20,80 43,50" style="fill:red"/>
					<? } ?>
				  </g>
				</svg>
				<? if ($ingredient['success']) { ?>
					<p><? echo $ingredient['info']['name']; ?></p>
				<? } else { ?>
					<p><? echo $ingredient['info']; ?></p>
				<? } ?>
			</section>
			</li>
		<? } ?>
	</ul>
</form>
</div>
<? } ?>