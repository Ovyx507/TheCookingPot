<div class="nav">
	<a href="<? echo APP_URL_PRE; ?>useri/profile" class="btn btn-default navbar-btn <? echo $this->_req->self == 'profile' ? 'active' : ''; ?>">Profile</a>
	<a href="<? echo APP_URL_PRE; ?>useri/stats" class="btn btn-default navbar-btn <? echo $this->_req->self == 'stats' ? 'active' : ''; ?>">Stats</a>
	<a href="<? echo APP_URL_PRE; ?>useri/achievements" class="btn btn-default navbar-btn <? echo $this->_req->self == 'achievements' ? 'active' : ''; ?>">Achievements</a>
</div>