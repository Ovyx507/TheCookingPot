<style>
	p{margin:0;font-family:Arial;}
	.timestamp{color:rgba(0,0,0,0.4);font-family:Arial;font-size:12px;}
</style>
<div class="row">
	<div id="titlu" class="text-center">
		<h1>Realizari</h1>
	</div>
</div>
<? echo $vars['meniu']; ?>
<hr>
<? 
	foreach($vars['rows'] as $row)
	{
		?>
		<p>Ai atins rangul <span class="lead"><? echo $row['a_name']; ?></span> <span class="timestamp">acum <? echo $this->_req->m_recipes->time_since(time() - $row['date_created']); ?></span></p>
		<?
	}
?>