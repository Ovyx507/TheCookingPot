<style>
.list-group-item {
display:list-item;
}
.classifier{min-width:100px;font-family:Arial;font-weight:600;display:inline-block;}
.hovereffect {
  width: 100%;
  height: 100%;
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
  background: #42b078;
}

.hovereffect .overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
  padding: 50px 20px;
}

.hovereffect img {
  display: block;
  position: relative;
  max-width: none;
  width: calc(100% + 20px);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-10px,0,0);
  transform: translate3d(-10px,0,0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}

.hovereffect:hover img {
  opacity: 0.4;
  filter: alpha(opacity=40);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect h2 {
  text-transform: uppercase;
  color: #fff;
  text-align: center;
  position: relative;
  font-size: 17px;
  overflow: hidden;
  padding: 0.5em 0;
  background-color: transparent;
}

.hovereffect h2:after {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: #fff;
  content: '';
  -webkit-transition: -webkit-transform 0.35s;
  transition: transform 0.35s;
  -webkit-transform: translate3d(-100%,0,0);
  transform: translate3d(-100%,0,0);
}

.hovereffect:hover h2:after {
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect a, .hovereffect p {
  color: #FFF;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(100%,0,0);
  transform: translate3d(100%,0,0);
}

.hovereffect:hover a, .hovereffect:hover p {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}
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
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="hovereffect">
        <img class="img-responsive" src="<? echo APP_URL_PRE; ?>uploads/useri/profilepic/thumbs/<? echo $vars['row']['profilepic'] != null ? $vars['row']['profilepic'] : 'default.jpg'; ?>" alt="">
            <div class="overlay">
				<p> 
					<h2><? echo $vars['row']['username'] != null ? $vars['row']['username'] : 'ceidintai'?></h2>
					<a href="#"><? echo $vars['row']['title'] != null ? $vars['row']['title'] : 'STARTER'?> : <? echo $vars['row']['score'] != null ? $vars['row']['score'] : '0'?>pts</a>
				</p> 
            </div>
    </div>
	</div>
	<span class="classifier">E-mail:</span><span><? echo $vars['row']['email']; ?></span>
	<br/>
	<span class="classifier">Nume:</span><span><? echo $vars['row']['name']; ?></span>
	<br/>
	<span class="classifier">Prenume:</span><span><? echo $vars['row']['surname']; ?></span>
</div>