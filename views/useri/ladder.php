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
  <li class="list-group-item"><span class="badge"><? echo $user['score'] ?></span><? echo $user['name'] ?></li>
 <?}?>
</ol>
</div>