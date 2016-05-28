<div class="login">
	<form method="post">
		<? echo H_form_bs::input_text('email', '', array('title' => 'Email')); ?>
		<? echo H_form_bs::input_password('password', '', array('title' => 'Password')); ?>
		<div class="text-center">
			<? echo H_form_bs::input_submit('submit', 'Login', '', array('class' => 'btn btn-primary btn-md')); ?>
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
	?>
</div>