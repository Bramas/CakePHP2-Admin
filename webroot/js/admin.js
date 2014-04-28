

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
	adminPanelLoaded();
	adminSetAjaxPageProgress(1);
}
function adminSelectLink(link)
{
	if(!link)
	{
		link = this;
	}
	$('li').removeClass('active');
	$('#jstree').jstree(true).deselect_all();
	$(link).addClass('active');
}
function adminSelectNode(node)
{
	if(!node)
	{
		node = this;
	}
	$('li').removeClass('active');
	$('#jstree').jstree(true).deselect_all();
	$('#jstree').jstree(true).select_node(node);
}
window.onpopstate = function(ev)
{
	if(ev.state)
	{
		adminLoadLayoutContent(ev.state.url);
		if(ev.state.callback)
		{
			window[ev.state.callback].apply(ev.state.context);
		}
		ev.preventDefault();
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
function adminMakeid(length)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
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
		data:{ajax:1, type:'plain'},
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
			adminSetLayoutContent(data)
		}
	});
}

function adminToSlug(str)
{
	return str.replace(/[^a-zA-Z\-\_]/g, '-');
}

function adminPanelLoaded()
{

	adminInitTinyMce();
	$('input[data-admin-toggle=slug]').each(function()
	{
			var id = $(this).attr('data-admin-slug-id');
			var handler =  function(ev){
				$(ev.data).attr('placeholder', adminToSlug($(this).val()));
			};

			$(this).attr('placeholder', adminToSlug($('#'+id).val()));
			$('#'+id).on('change', this, handler);
			$('#'+id).on('keyup', this, handler);
	});
	// dont know why it is not automatic
	$('a[data-toggle=tooltip]').tooltip();
}

jQuery(function($){
	adminPanelLoaded();
	history.replaceState({url:window.location.href})


	$('.nav[data-admin-toggle=ajax] li > a').on('click', function(ev){
		ev.preventDefault();

		var clickId = $(this).parent().attr('admin-menu-click-id');
		if(!clickId)
		{
			clickId = adminMakeid(10);
			$(this).parent().attr('admin-menu-click-id', clickId);
		}
		adminSelectLink('li[admin-menu-click-id='+clickId+']');
		adminLoadLayoutContent({
			url:$(this).attr('href'),
			title:$(this).attr('title'),
			callback:'adminSelectLink',
			context:'li[admin-menu-click-id='+clickId+']'
		});
	})

	$(window).on('scroll', function(d){
		console.log();
		if($(window).scrollTop() > 45)
		{
			$('.admin-panel-header').addClass('fixed');
			if($('.admin-panel-header').length)
			{
				$('.main').addClass('admin-fixed-panel-header');
			}
		}
		else
		{
			$('.admin-panel-header').removeClass('fixed');
			if($('.admin-panel-header').length)
			{
				$('.main').removeClass('admin-fixed-panel-header');
			}
		}
	});
	
});

