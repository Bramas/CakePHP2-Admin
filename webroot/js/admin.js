

var adminConnected = true;
function adminInitTinyMce()
{
	tinymce.init({
	    selector: "textarea.tinymce-editor",
	    theme: "modern",
	    height: 300,
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    language_url : AdminBaseUrl+'js/tinymce/langs/fr_FR.js',
	});
	//console.log(tinymce);
	//tinymce.EditorManager.createEditor('PageContent');
}

function adminSetAjaxPageProgress(p)
{
	if(p==1 && $('#ajaxPageProgressBar').hasClass('finished'))
	{
		return;
	}
	if(p == 1)
	{
		$('#ajaxPageProgressBar > span').animate(
			{'width':'100%'},
			200,
			function(){ $('#ajaxPageProgressBar').addClass('finished') });
		return;
	}
	
	$('#ajaxPageProgressBar').removeClass('finished');
	$('#ajaxPageProgressBar > span').css('width', (p*100)+'%');

}



function adminSetLayoutContent(content)
{
	tinymce.remove();
	$('#layoutContent').html(content);
	adminInitTinyMce();
	adminSetAjaxPageProgress(1);
}
function activate_node()
{
	$('#jstree').jstree(true).deselect_all();
	$('#jstree').jstree(true).select_node(this);
}
window.onpopstate = function(ev)
{
	if(ev.state)
	{
		adminLoadLayoutContent(ev.state.url);
		window[ev.state.callback].apply(ev.state.context);
		ev.preventDefault();
	}
	else
	{
		adminLoadLayoutContent(AdminFirstUrl);
	}
}
function adminConnexionLost()
{
	adminConnected = false;
	$('#admin-connexion-status').html("La connexion à été perdu.").show('fast');
}
function adminConnexionWin()
{
	if(adminConnected)
	{
		return;
	}
	adminConnected = true;
	$('#admin-connexion-status').hide('fast');
}

function adminLoadLayoutContent(state)
{
	if(state.url && state.url == window.location.pathname)
	{
		return;
	}
	url = state.url ? state.url : state;

	adminSetAjaxPageProgress(0.05);
	$.ajax({
		url: url,
		type:'GET',
		data:{ajax:1},
		xhrFields: {
			onprogress: function (e) {
				if (e.lengthComputable) {
					adminSetAjaxPageProgress(e.loaded / e.total)
				}
				else
				{
					adminSetAjaxPageProgress(0.25);
				}
			}
		},
		context: state,
		error: function(){
			adminSetAjaxPageProgress(1);
			adminConnexionLost();
		},
		success:function(data)
		{
			if(state.url)
			{
				history.pushState(this, this.title, this.url);
			}
			adminSetAjaxPageProgress(1);
			adminSetLayoutContent(data)
		}
	});
}


jQuery(function($){
	adminInitTinyMce();
});
