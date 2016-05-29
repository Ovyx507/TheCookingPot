<link rel="stylesheet" type="text/css" href="/thecookingpot/css/recipe.css">

<div class="recipe">
	<div class="panel panel-default">
		<div class="panel-heading bg-bluegrey">
			<h2>
				<? echo $vars['row']['name'] ?>
			</h2>
			<div class="recipe-headerfooter">Posted by <em> <? echo $vars['row']['username'] ?> </em> at <? echo	date("Y-m-d H:i:s", $vars['row']['date_created']) ?></div>
		</div>
		<div class="panel-body bg-grey">
			
			<div class="recipe-description">
				<? echo $vars['row']['description'] ?>
			</div>
		</div>
		<div class="panel-footer bg-bluegrey">
			<div class="row">
				<div class="col-md-8 recipe-headerfooter">
					Last modified at <? echo date("Y-m-d H:i:s",$vars['row']['date_modified']) ?>, <? echo $vars['row']['nr_likes'] == 1 ? $vars['row']['nr_likes'].' person likes this' : $vars['row']['nr_likes'].' people like this'; ?> recipe
				</div>
				<div class ="col-md-4 recipe-buttons">
					<div class="pull-right">
						<?
						if(is_array(unserialize($_COOKIE['likes'])))
						{
							if(!in_array($vars['row']['id'], unserialize($_COOKIE['likes'])))
							{
						?>
								<a href="<? echo APP_URL_PRE; ?>recipes/like/<? echo $vars['row']['id']; ?>" class="btn btn-primary" style="margin-right:10px">Like</a>
						<? 
							}
						}
						else
						{
						?>
							<a href="<? echo APP_URL_PRE; ?>recipes/like/<? echo $vars['row']['id']; ?>" class="btn btn-primary" style="margin-right:10px">Like</a>
						<?
						}
						?>
						<button type="button" class="btn btn-primary">Comment</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.widget-area {
		background-color: #fff;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		-o-border-radius: 4px;
		border-radius: 4px;
		border-top:1px solid #F5F5F5;
		border-left:1px solid #F5F5F5;
		border-right:1px solid #F5F5F5;
		float: left;
		margin-top: 30px;
		padding: 25px 30px;
		position: relative;
		width: 100%;
		}
		.widget-area input[name="name"]{border:1px solid #F5F5F5;padding-left:20px;}
		.status-upload {
		background: none repeat scroll 0 0 #f5f5f5;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		-o-border-radius: 4px;
		border-radius: 4px;
		float: left;
		width: 100%;
		}
		.status-upload form {
		float: left;
		width: 100%;
		}
		.status-upload form textarea {
		background: none repeat scroll 0 0 #fff;
		border: medium none;
		-webkit-border-radius: 4px 4px 0 0;
		-moz-border-radius: 4px 4px 0 0;
		-ms-border-radius: 4px 4px 0 0;
		-o-border-radius: 4px 4px 0 0;
		border-radius: 4px 4px 0 0;
		color: #777777;
		float: left;
		font-family: Arial;
		font-size: 14px;
		height: 142px;
		letter-spacing: 0.3px;
		padding: 20px;
		width: 100%;
		resize:vertical;
		outline:none;
		border: 1px solid #F2F2F2;
		}

		.status-upload ul {
		float: left;
		list-style: none outside none;
		margin: 0;
		padding: 0 0 0 15px;
		width: auto;
		}
		.status-upload ul > li {
		float: left;
		}
		.status-upload ul > li > a {
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		-o-border-radius: 4px;
		border-radius: 4px;
		color: #777777;
		float: left;
		font-size: 14px;
		height: 30px;
		line-height: 30px;
		margin: 10px 0 10px 10px;
		text-align: center;
		-webkit-transition: all 0.4s ease 0s;
		-moz-transition: all 0.4s ease 0s;
		-ms-transition: all 0.4s ease 0s;
		-o-transition: all 0.4s ease 0s;
		transition: all 0.4s ease 0s;
		width: 30px;
		cursor: pointer;
		}
		.status-upload ul > li > a:hover {
		background: none repeat scroll 0 0 #606060;
		color: #fff;
		}
		.status-upload form button {
		border: medium none;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		-o-border-radius: 4px;
		border-radius: 4px;
		color: #fff;
		float: right;
		font-family: Arial;
		font-size: 14px;
		letter-spacing: 0.3px;
		margin-right: 9px;
		margin-top: 9px;
		margin-bottom:9px;
		padding: 6px 15px;
		}
		.dropdown > a > span.green:before {
		border-left-color: #2dcb73;
		}
		.status-upload form button > i {
		margin-right: 7px;
		}
	</style>
	<div class="panel panel-default">
		<div class="widget-area no-padding blank">
			<div class="status-upload">
				<form action="<? echo  APP_URL_PRE; ?>recipes/recipe_comment" method="post">
					<? echo H_form_bs::input_text('name', '', array('stripped' => true), array('placeholder' => 'Name')); ?>
					<input type="hidden" name="id_recipe" value="<? echo $vars['row']['id']; ?>" >
					<? echo H_form_bs::textarea('comment', '', array('stripped' => true), array('placeholder' => 'Comment')); ?>
					<button type="submit" name="submit" class="btn btn-success green"></i>Send comment</button>
				</form>
			</div><!-- Status Upload  -->
		</div><!-- Widget Area -->
	</div>
	
	<style>
		.pnl{width:100%;background:white;overflow:auto;border-left:1px solid #F5F5F5;border-right:1px solid #F5F5F5}
		.pnl .post-heading{width:100%;float:left;padding:20px 0px 0px 20px;}
		.pnl .post-description{float:left;width:100%;padding:20px 0px 0px 20px;}
		.pnl .post-heading .meta{padding:0px 0px 0px 20px;}
	</style>
	<div class="row">
		<?
		if(is_array($vars['comments']) && !empty($vars['comments']))
		{
			foreach($vars['comments'] as $comment)
			{
			?>
			<div class="col-sm-12">
				<div class="pnl">
					<div class="post-heading">
						<div class="pull-left image">
							<img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image">
						</div>
						<div class="pull-left meta">
							<div class="title h5">
								<a href="#"><b><? echo $comment['name']; ?></b></a>
								made a comment.
							</div>
							<h6 class="text-muted time"><? echo $this->_req->m_recipes->time_since(time() - $comment['date_created']); ?> ago</h6>
						</div>
					</div> 
					<div class="post-description"> 
						<p><? echo $comment['comment']; ?></p>
					</div>
				</div>
			</div>
			<?
			}
		}
		else
		{
			?>
			<p>Nu sunt comentarii</p>
			<?
		}
		?>
	</div>
</div>