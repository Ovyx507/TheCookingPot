<div class="login">
	<form class="jqv" method="post">
		<? echo H_form_bs::input_text('name', '', array('title' => 'Nume', 'required' => true)); ?>
		<? echo H_form_bs::input_text('surname', '', array('title' => 'Prenume', 'required' => true)); ?>
		<? echo H_form_bs::input_text('email', '', array('title' => 'Email', 'required' => true)); ?>
		<? echo H_form_bs::input_text('username', '', array('title' => 'Username', 'required' => true)); ?>
		<? echo H_form_bs::input_password('password', '', array('title' => 'Parola', 'required' => true)); ?>
		<div class="text-center">
			<? echo H_form_bs::input_submit('submit', 'Register', '', array('class' => 'btn btn-primary btn-md')); ?>
		</div>
	</form>
	<? 
		if($vars['erori'])
		{
	?>
			<div class="alert alert-danger text-center">
				<? echo $vars['erori']; ?>
			</div>
	<?
		}
		if($vars['succes'])
		{
	?>
			<div class="alert alert-success text-center">
				<? echo $vars['succes']; ?>
			</div>
	<?
		}
	?>
</div>