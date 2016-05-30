<style>
	p{margin:0;font-family:Arial;}
	.timestamp{color:rgba(0,0,0,0.4);font-family:Arial;font-size:12px;}
</style>
<div class="row">
	<div id="titlu" class="text-center">
		<h1>Cupoane</h1>
	</div>
</div>
<? echo $vars['meniu']; ?>
<hr>
<ol>
<? if (is_array($vars['rows']) || is_object($vars['rows'])) {
	foreach($vars['rows'] as $row)
	{
		?>
		<div class="col-lg-4">
			<li class="list-group-item" style="background:url('<? echo APP_URL_PRE; ?>uploads/coupons/thumbs/<? echo $row['coupon_pic']; ?>');height:200px;background-size:100% 100%;">
				<p>Ai atins rangul <span class="lead"><? echo $row['a_name']; ?></span> <span class="timestamp">acum <? echo $this->_req->m_recipes->time_since(time() - $row['date_created']); ?></span></p>
			</li>
		</div>
		<?
	}
}
?>