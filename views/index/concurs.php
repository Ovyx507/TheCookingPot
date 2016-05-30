<style>
	.oponent{font-size:20px;font-family:Arial;}
</style>
<h1 class="text-center">Concurs</h1>
<h3 class="text-center">Final concurs - <? echo date('d-m-Y G:i', $vars['recipe']['c_date']+3600*24); ?></h3>

<div class="reteta">
	<h2 class="text-center">Reteta</h2>
	<p class="text-center">
		<span style="font-weight:bold;"><? echo $vars['recipe']['name']; ?></span><br/>
		<img src="<? echo APP_URL_PRE; ?>uploads/recipes/photo/thumbs/<? echo $vars['recipe']['photo']; ?>" alt="Flower" width="280"><br/>
		<? echo $vars['recipe']['description']; ?>
	</p>
</div>
<div class="row">
	<div class="col-sm-6">
		<span class="oponent"><? echo $vars['user_1']['name'].' '.$vars['user_1']['surname']; ?></span><br/>
		<? if($vars['user_1']['id'] == $_SESSION['user_id'])
		{ 
			if(!$vars['user_1']['poza'])
			{
			?>
				<form action="<? echo APP_URL_PRE; ?>useri/concurs_dovezi/<? echo $vars['c']; ?>" method="post" enctype="multipart/form-data">
					<? echo H_form_bs::input_hidden('user', '1'); ?>
					<? echo H_form_bs::input_file('poza','', array('title' => 'Poza')); ?>
					<input type="submit" class="btn btn-default" value="Adauga poza">
				</form>
			<? 
			}
			if($vars['user_1']['poza'])
			{
			?>	
				<img src="<? echo APP_URL_PRE; ?>uploads/concursuri_dovezi/poza/thumbs/<? echo $vars['user_1']['poza']; ?>" alt="Flower"><br/>
				<div class="row">
					<div class="col-sm-6">
						<?
						if(is_array(unserialize($_COOKIE['likes_concurs'])))
						{
							if(!in_array($vars['user_1']['cd_id'], unserialize($_COOKIE['likes_concurs'])))
							{			
						?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_1']['cd_id']; ?>">Like</a>
						<? 
							}
						}
						else
						{
							?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_1']['cd_id']; ?>">Like</a>
							<?
						}
						?>
						 <? echo $vars['user_1']['nr_likes']; ?> likes
					</div>
				</div>
			<?
			}
		}
		else
		{
			if($vars['user_1']['poza'])
			{
			?>
				<img src="<? echo APP_URL_PRE; ?>uploads/concursuri_dovezi/poza/thumbs/<? echo $vars['user_1']['poza']; ?>" alt="Flower" >
				<div class="row">
					<div class="col-sm-6">
						<?
						if(is_array(unserialize($_COOKIE['likes_concurs'])))
						{
							if(!in_array($vars['user_1']['cd_id'], unserialize($_COOKIE['likes_concurs'])))
							{			
						?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_1']['cd_id']; ?>">Like</a>
						<? 
							}
						}
						else
						{
							?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_1']['cd_id']; ?>">Like</a>
							<?
						}
						?>
						  <? echo $vars['user_1']['nr_likes']; ?> likes
					</div>
				</div>
			<?
			}
			else
			{
				?>
					<span style="font-weight:bold;">Userul nu a uploadata nicio poza inca.</span>
				<?
			}
		}
		?>
	</div>
	<div class="col-sm-6 ">
		<span class="oponent"><? echo $vars['user_2']['name'].' '.$vars['user_2']['surname']; ?></span><br/>
		<? if($vars['user_2']['id'] == $_SESSION['user_id'])
		{
			if(!$vars['user_2']['poza'])
			{
			?>
				<form action="<? echo APP_URL_PRE; ?>useri/concurs_dovezi/<? echo $vars['c']; ?>" method="post" enctype="multipart/form-data">
					<? echo H_form_bs::input_hidden('user', '1'); ?>
					<? echo H_form_bs::input_file('poza','', array('title' => 'Poza')); ?>
					<input type="submit" class="btn btn-default" value="Adauga poza">
				</form>
			<?
			}
			if($vars['user_2']['poza'])
			{
			?>
				<img src="<? echo APP_URL_PRE; ?>uploads/concursuri_dovezi/poza/thumbs/<? echo $vars['user_2']['poza']; ?>" alt="Poza">
				<div class="row">
					<div class="col-sm-6">
						<?
						if(is_array(unserialize($_COOKIE['likes_concurs'])))
						{
							if(!in_array($vars['user_2']['cd_id'], unserialize($_COOKIE['likes_concurs'])))
							{			
						?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_2']['cd_id']; ?>">Like</a>
						<?
							}
						}
						else
						{
							?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_2']['cd_id']; ?>">Like</a>
							<?
						}
						?>
						 <? echo $vars['user_2']['nr_likes']; ?> likes
					</div>
				</div>
			<?
			}
		}
		else
		{
			if($vars['user_2']['poza'])
			{
			?>
				<img src="<? echo APP_URL_PRE; ?>uploads/concursuri_dovezi/poza/thumbs/<? echo $vars['user_2']['poza']; ?>" alt="Poza">
				<div class="row">
					<div class="col-sm-6">
						<?
						if(is_array(unserialize($_COOKIE['likes_concurs'])))
						{
							if(!in_array($vars['user_2']['cd_id'], unserialize($_COOKIE['likes_concurs'])))
							{			
						?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_2']['cd_id']; ?>">Like</a>
						<? 
							}
						}
						else
						{
							?>
								<a href="<? echo APP_URL_PRE; ?>useri/concurs_like/<? echo $vars['user_2']['cd_id']; ?>">Like</a>
							<?
						}
						?>
						 <? echo $vars['user_2']['nr_likes']; ?> likes
					</div>
				</div>
			<?
			}
			else
			{
				?>
				<span style="font-weight:bold;">Userul nu a uploadata nicio poza inca.</span>
				<?
			}
		}
		?>


	</div>
</div>