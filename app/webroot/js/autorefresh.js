// script: autorefresh.js
// desc: refresh location
function init(sec)
{
    autoRefresh(sec);
}

function autoRefresh(sec)
{
	var t=null;

	t=setTimeout(function(){location.reload(true);}, (sec*1000) );
}
