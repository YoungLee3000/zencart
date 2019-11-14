/**PZENTEMPLATE_BRAND**/

function init()
{
	cssjsmenu('navbar');
	if (document.getElementById)
	{
	  var kill = document.getElementById('hoverJS');
	  kill.disabled = true;
	}
	if (typeof _editor_url == "string")
	{
		HTMLArea.replaceAll();
	}
}
	
function getproductstatus(status)
  {
	 if(status==1)
	 { document.getElementById('parent_name').disabled=false;document.getElementById('product_discount').disabled=true;}
	 else
	 {document.getElementById('parent_name').disabled=true;
	  
	 }
	 
  }
  
function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

/*For Selected  color picker  */
function createForm() { document.getElementById("formContainer").innerHTML = '<input type="text" id="cinput2" class="color" value="#fff" />'; MC.ColorPicker.reload(); }

//innersection show action
$(document).ready(function(){
	$(".innersec_action").click(function(){
		var tar=$(this).attr("data-target");
		if($(this).val()!=0){
			$("#"+tar).show();
		}else{$("#"+tar).hide();}
	});
});
$(document).ready(function(){
	$(".lnk_action").click(function(){
		var tar=$(this).attr("data-target");
		var tarlnk=$(this).attr("data-tarlnk");
		if (typeof tar !== typeof undefined && tar !== false) {
			$('.'+tarlnk).hide();
			$("#"+tar).show();
		}else{$('.'+tarlnk).hide();}
	});
});	
$(document).ready(function(){
	$("ul.tabs > li > a").on("click",function(){
		setCookie("pzen_accordian",0,-1);
		accordian_actiive_first();
	});
});
$(window).load(function(){
	//Set default open/close settings
	if(getCookie("pzen_accordian")){
		$('.tab-content .block > .block-content').hide(); //Hide/close all containers
		$('.tab-content[style="display: block;"] section.block').each(function(index){
			if(index==(getCookie("pzen_accordian"))){
				$(this).addClass("active");
				$(this).find('.block-header').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
			}
		});
	}else{
		accordian_actiive_first();
	}
});
$(document).ready(function($){
	$('.tab-content').each(function(index){
		var last=parseInt($(this).find('.block').length)-1;
		$(this).find('.block').each(function(index){
			if(index==0){$(this).addClass('first');}
			if(index==last){$(this).addClass('last');}
		});
	});
	if(!getCookie("pzen_accordian")){
		accordian_actiive_first();
	}
	//On Click
	$('.tab-content section.block .block-header').click(function(){
		setCookie("pzen_accordian",$(this).parent("section.block").index(),'20');
		if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
			$('.tab-content .block>.block-header').removeClass('active').next().slideUp(); //Remove all .accordian-header classes and slide up the immediate next container
			$(this).toggleClass('active').next().slideDown(); //Add .accordian-header class to clicked trigger and slide down the immediate next container
		}
		return false; //Prevent the browser jump to the link anchor
	});	
});
function accordian_actiive_first(){
	$('.tab-content .block > .block-content').hide(); //Hide/close all containers
	$('.tab-content .block.first > .block-header').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
}