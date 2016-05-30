<style>
.list-group-item {
display:list-item;
}
</style>
</br>
<div class="row">
<div id="titlu" class="text-center">
<h1>Score Ladder</h1>
</div>
</div>
<hr>
<div class="row">
<div class="ladder">
 <ol class="list-group" type="1">
 <?foreach($vars['useri'] as $user) {?>
  <li class="list-group-item">
	<? echo $user['name'] ?> - <span style="font-weight:bold;"><? echo $user['title'] ? $user['title'] : 'n/a'; ?></span>
	<span class="badge"><? echo $user['score'] ?></span>
	<? 
		if($user['id'] != $_SESSION['user_id'])
		{
	?>		
			<a href="<? echo APP_URL_PRE; ?>useri/concurs_start/<? echo $user['id']; ?>" style="float:right;margin-right:15px;text-decoration:none;cursor:pointer;" class="glyphicon glyphicon-screenshot"></a>
	<? 
		}
	?>
  </li>
 <?}?>
</ol>
</div>