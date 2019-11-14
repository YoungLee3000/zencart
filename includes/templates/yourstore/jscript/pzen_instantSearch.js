var runningRequest = false;
var request;
var autoPosition = false;
var inputboxCurrent;
$(document).ready(function () {
    var inputBox = $('input[name="keyword"]');
	inputBox.before('<div class="resultsContainer"></div>');
	inputBox.attr('autocomplete', 'off');
	if (autoPosition == true){
		inputBox.each(function (index) {
			var offset = $(this).offset();
			$(this).prev().css("left", offset.left + "px");
			$(this).prev().css("top", ($(this).outerHeight(true) + offset.top) + "px");
		});
	}
    inputBox.blur(function () {
        if (inputboxCurrent) {
            var resultsContainer = inputboxCurrent.prev();
            resultsContainer.delay(300).slideUp(200);
        }
    });
    inputBox.focus(function () {
        if (inputboxCurrent) {
            var resultsContainer = inputboxCurrent.prev();
            resultsContainer.delay(300).slideDown(200);
        }
    });
	$(window).resize(function() {
        if (inputboxCurrent) {
            var resultsContainer = inputboxCurrent.prev();
            resultsContainer.hide();
        }
	});
    inputBox.keyup(function () {
        inputboxCurrent = $(this);
        var resultsContainer = $(this).prev();
        var searchWord = $(this).val();
		var replaceWord = searchWord;
        searchWord = searchWord.replace(/^\s+/, "");
        searchWord = searchWord.replace(/  +/g, ' ');
        if (searchWord == "") {
            resultsContainer.hide();
        } else {
            if (runningRequest) {request.abort();}
            runningRequest = true;
            request = $.getJSON('pzen_searches.php', {query: searchWord}, function (data) {
                if (data.length > 0) {
                    var resultHtml = '';
                    $.each(data, function (i, item) {
                        resultHtml += '<li><a href="' + generateLink(item.pc,item.l) + '">' + '<div class="image">' + item.img + '</div><div class="desc"><span class="product-name">' + highlightWord(replaceWord,item.q) + '</span>' + item.pm + '<span class="product-price price-box">' + formatNumber(item.c) + '</span></div></a></li>';
                    });
                    resultsContainer.html('<ul>'+resultHtml+'</ul>');
                    if (!resultsContainer.is(':visible')) {
						if (autoPosition == true){
							autoPositionContainer(inputboxCurrent, resultsContainer);
						}
                        resultsContainer.slideDown(100);
                    }
                } else {
                    resultsContainer.hide();
                }

                runningRequest = false;
            });
        }
    });
});
function autoPositionContainer(inputBoxCurr, resltsContainer){
	var offsetInput = inputBoxCurr.offset();
	var overFlow = offsetInput.left + resltsContainer.outerWidth(true);
	var winWidth = $(document).width();
	
	if (overFlow > winWidth){ // this checks to see if the container overflows on the right of the window
		var dif = overFlow - winWidth;
		
		if ((offsetInput.left - dif) < 0){// this checks to see if the container overflows on the left of the window
			resltsContainer.css("left", 0 + "px");
		}else{
			resltsContainer.css("left", (offsetInput.left - dif) + "px");
		}
	}else{
		resltsContainer.css("left", offsetInput.left + "px");
	}
	resltsContainer.css("top", (inputBoxCurr.outerHeight(true) + offsetInput.top) + "px");
}
function generateLink(productORcategory, productCategoryID){
	var l = "";
	if (productORcategory == "p"){
		l = "index.php?main_page=product_info&products_id=" + productCategoryID;
	}else{
		l = "index.php?main_page=index&cPath=" + productCategoryID;
	}
	return l;

}
function highlightWord(findTxt,replaceTxt){
	var f = findTxt.toLowerCase();
	var r = replaceTxt.toLowerCase();
	var regex = new RegExp('(' + f + ')', 'i');
	return r.replace(regex, '<span class="thinFont color">' + f + '</span>')
	
}
function formatNumber(num){
	return num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}