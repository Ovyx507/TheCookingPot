<style>
.list-group-item {
display:list-item;
}
.classifier{min-width:100px;font-family:Arial;font-weight:600;display:inline-block;}
</style>
</br>
<div class="row">
<div id="titlu" class="text-center">
<h1>Dashboard</h1>
</div>
</div>
<? echo $vars['meniu'];?>
<hr>
<div id="profile">
	<span class="classifier">E-mail:</span><span><? echo $vars['row']['email']; ?></span>
	<br/>
	<span class="classifier">Nume:</span><span><? echo $vars['row']['name']; ?></span>
	<br/>
	<span class="classifier">Prenume:</span><span><? echo $vars['row']['surname']; ?></span>
</div>