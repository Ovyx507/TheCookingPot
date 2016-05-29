<input type="hidden" value="<? echo APP_URL_PRE; ?>" id="aup">
<div class="LS-topHolder">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="logo">
					<? echo H_html::aimg(APP_URL_PRE.'public/standard/cuts/logo.png', APP_URL_PRE); ?>
				</div>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Retete <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?
							if($_SESSION['loggedin'] == 1)
							{
								?>
								<li><a href="<? echo APP_URL_PRE; ?>recipes/add">Adauga reteta</a></li>
							<? } ?>
								<li><a href="<? echo APP_URL_PRE; ?>index">Vezi retete</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ingrediente <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?
							if($_SESSION['loggedin'] == 1)
							{
								?>
								<li><a href="<? echo APP_URL_PRE; ?>admin/add_ingredient">Adauga ingredient</a></li>
							<? } ?>
								<li><a href="<? echo APP_URL_PRE; ?>admin/list_ingredients">Vezi ingrediente</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
				
					<?
						if($_SESSION['loggedin'] == 1)
						{
							?>	<li>
									<img class="logo" src="<? echo APP_URL_PRE;?>uploads/useri/profilepic/micro/<? echo $_SESSION['profilepic'] != null ? $_SESSION['profilepic'] : 'default.jpg'; ?>" height="42" width="42">
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><? echo $_SESSION['username'] != null ? $_SESSION['username'] : 'ceidintai'?> <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="<? echo APP_URL_PRE; ?>useri/profile">Profile</a></li>
										<li role="separator" class="divider"></li>
										<li><a href="<? echo APP_URL_PRE; ?>useri/logout">Logout</a></li>
									</ul>
								</li>
							<?
						}
						else
						{
							?>
								<li><a href="<? echo APP_URL_PRE; ?>useri">Login</a></li>
								<li><a href="<? echo APP_URL_PRE; ?>useri/register">Register</a></li>
							<?
						}
					?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</div>

<div class="container-fluid page-container">