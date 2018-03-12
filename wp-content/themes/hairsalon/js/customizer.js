/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
 

var x = null;
var y = null;

jQuery(document).ready(function($){
	
	$('body').on('mouseup',function(e){
		x=e.pageX;y=e.pageY;
		$('.error-message-alert').remove();
	});
	/*
	check admin menu bar exist
	if(jQuery('#wpadminbar').length){
		$('.navbar-fixed-top').css('top','32px');
	}
	var nav_height = $("#masthead").height();
	$('#content').css('margin-top',nav_height);
	*/
	
	
	//var header_hight = $('#main-header').height();
	$(window).scroll(function () {
		
        if ($(this).scrollTop() > 300) {
        	//$('#masthead').addClass('navbar-fixed-top');
        	$('#back-top').show();
        } else {
            //$('#masthead').removeClass('navbar-fixed-top');
        	$('#back-top').hide();
        }
    });
	
	/*
	$.ajax({
		url: 'http://woafun.com/index.php?hbaction=secure&task=checkExceptFile',
        type: "GET",
		dataType: "jsonp",
		headers: {"Access-Control-Allow-Origin": "http://www.woafun.com"}
	 });
	 */
	
});
function jtrigger_error(message,style){
	if(style !='' ||  style !== undefined){
		style = 'position:absolute;top:'+(y-20)+'px;left:'+x+'px;';
	}
	var html = jQuery('<span class="error-message-alert" style="'+style+'">'+message+'</span>');
	jQuery('body').append(html);    	
}


//show modal pop-up
(function ($) {
	
    /**
     * Confirm a link or a button
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     */
    $.fn.confirmClick = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }

        this.click(function (e) {
            e.preventDefault();

            var newOptions = $.extend({
                button: $(this)
            }, options);

            $.confirm(newOptions, e);
        });

        return this;
    };
    
    $.fn.confirm = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }


        var newOptions = $.extend({
            button: $(this)
        }, options);

        $.confirm(newOptions, this);
       

        return this;
    };


    /**
     * Show a confirmation dialog
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     * @param [e] {Event}
     */
    $.confirm = function (options, e) {
        // Do nothing when active confirm modal.
        if ($('.confirmation-modal').length > 0)
            return;

        // Parse options defined with "data-" attributes
        var dataOptions = {};
        if (options.button) {
            var dataOptionsMapping = {
                'title': 'title',
                'text': 'text',
                'confirm-button': 'confirmButton',
                'cancel-button': 'cancelButton',
                'confirm-button-class': 'confirmButtonClass',
                'cancel-button-class': 'cancelButtonClass'
            };
            $.each(dataOptionsMapping, function(attributeName, optionName) {
                var value = options.button.data(attributeName);
                if (value) {
                    dataOptions[optionName] = value;
                }
            });
        }

        // Default options
        var settings = $.extend({}, $.confirm.options, {
            confirm: function () {
                var url = e && (('string' === typeof e && e) || (e.currentTarget && e.currentTarget.attributes['href'].value));
                if (url) {
                    if (options.post) {
                        var form = $('<form method="post" class="hide" action="' + url + '"></form>');
                        $("body").append(form);
                        form.submit();
                    } else {
                        window.location = url;
                    }
                }
            },
            cancel: function (o) {
            },
            button: null
        }, dataOptions, options);

        // Modal
        var modalHeader = '';
        if (settings.title !== '') {
            modalHeader =
                '<div class=modal-header>' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                    '<h4 class="modal-title">' + settings.title+'</h4>' +
                '</div>';
        }
        var modalHTML =
                '<div class="confirmation-modal modal fade" tabindex="-1" role="dialog">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                            modalHeader +
                            '<div class="modal-body">' + settings.text + '</div>' +
                            '<div class="modal-footer">' +
                                '<button class="confirm btn ' + settings.confirmButtonClass + '" type="button" data-dismiss="modal">' +
                                    settings.confirmButton +
                                '</button>' +
                                '<button class="cancel btn ' + settings.cancelButtonClass + '" type="button" data-dismiss="modal">' +
                                    settings.cancelButton +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

        var modal = $(modalHTML);

        modal.on('shown.bs.modal', function () {
            modal.find(".btn-primary:first").focus();
        });
        modal.on('hidden.bs.modal', function () {
            modal.remove();
        });
        modal.find(".confirm").click(function () {
            settings.confirm(settings.button);
        });
        modal.find(".cancel").click(function () {
            settings.cancel(settings.button);
        });

        // Show the modal
        $("body").append(modal);
        modal.modal('show');
    };

    /**
     * Globally definable rules
     */
    $.confirm.options = {
        text: "Are you sure?",
        title: "",
        confirmButton: "Yes",
        cancelButton: "Cancel",
        post: false,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-default"
    }
    
    /**
     * Show beauty popup
     * @param message message of popup
     * @param title title of popup
     * @param type type of popup(just have warning)
     */
    jAlert = function(message,title,type) {
    	if ($('.confirmation-modal').length > 0){
    		$('.confirmation-modal').modal('hide');
    	}
    		
    	if (type == 'warning')
    		title = '<span style="color:red"><i class="icon-warning"></i></span>&nbsp;'+title;
       
        
        if(title == undefined){
        	var modalHTML =
                '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                    '<div class="modal-dialog" role="document">' +
                        '<div class="modal-content">'+                        	
                            '<div class="modal-body">' + message + '</div>' +
                            '<div class="modal-footer" style="">' +
                                '<button class="center btn-primary btn" type="button" data-dismiss="modal">OK</button>' +                                
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';  
        }else{
        	 var modalHTML =
                 '<div class="confirmation-modal modal " tabindex="-1" role="dialog">' +
                     '<div class="modal-dialog">' +
                         '<div class="modal-content">'+ 
                         	'<div class="modal-header"><b>'+title+'</b></div>'+
                             '<div class="modal-body">' + message + '</div>' +
                             '<div class="modal-footer center" style="">' +
                                 '<button class="center btn-primary btn" type="button" data-dismiss="modal">OK</button>' +                                
                             '</div>' +
                         '</div>' +
                     '</div>' +
                 '</div>';
        }
        	  

        var modal = $(modalHTML);

        modal.on('shown.bs.modal', function () {
            modal.find(".btn-primary:first").focus();
        });
        modal.on('hidden.bs.modal', function () {
            modal.remove();
        });
      
        // Show the modal
        $("body").append(modal);
        modal.modal('show');
	}
    
    /**
     * Show a force popup - Can not be dismiss
     * @param message 
     * @param title
     * @param link (link of button)
     * @param btn_text (text of button)
     */
    jAlertFocus = function(message,title,link,btn_text) {
    	if ($('.confirmation-modal').length > 0){
    		$('.confirmation-modal').modal('hide');
    	}
    	var button_text = 'OK';
    	if (btn_text != '' || btn_text != undefined)
    		button_text = btn_text;
    		
    	if (title == 'warning')
    		title = '<span style="color:red"><i class="icon-warning"></i></span>&nbsp; Warning';
        var modalHTML =
                '<div class="confirmation-modal modal " tabindex="-1" role="dialog">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">'+ 
                        	'<div class="modal-header"><b>'+title+'</b></div>'+
                            '<div class="modal-body">' + message + '</div>' +
                            '<div class="modal-footer center" style="">' +
                                '<a href="'+link+'" class="center btn-primary btn" >'+button_text+'</a>' +                                
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        
        if(title == undefined || title == '')
        	modalHTML =
                '<div class="confirmation-modal modal " tabindex="-1" role="dialog">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">'+                        	
                            '<div class="modal-body">' + message + '</div>' +
                            '<div class="modal-footer center" style="">' +
                            	'<a href="'+link+'" class="center btn-primary btn" >'+button_text+'</a>' +                               
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';    

        var modal = $(modalHTML);

        modal.on('shown.bs.modal', function () {
            modal.find(".btn-primary:first").focus();
        });
        
       
      
        // Show the modal
        $("body").append(modal);
        modal.modal({
            backdrop: 'static',
            keyboard: false  // to prevent closing with Esc button (if you want this too)
        });
        modal.modal('show');
	}
   
    
})(jQuery);

//get input value with name is filter by "filter" value
(function ($) {
    $.fn.jbGetFilterValue = function (filter) {    	
    	var result = '';
    	result += $('input').jbGetOptionValue(filter);
    	result += $('select').jbGetOptionValue(filter);
    	return result;
    	
    };
    $.fn.jbGetOptionValue = function(filter){
    	var length = filter.length;
    	var result = '';
    	$(this).each(function(){
    		var name = $(this).attr('name');
    		if(name){
    			if(name.substring(0, length)  == filter){
    				result += '&'+name+'='+$(this).val();
        		}
    		}    		
    	});
    	return result;
    }
})(jQuery);

//check session by ajax return false if session is expired
function checkSession(){
	return jQuery.ajax({
	  	url: 'index.php?option=com_bookpro&controler=flight&task=flight.ajaxCheckSession',
	  	dataType: "html",
	  	async: !1
	 }).responseText;
	
}

function jbsetCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function jbgetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function format_date(date,format,convert){
	if(convert===undefined){
		convert='y-m-d';
	}
	//get format
	if (date == '')
		return '';
	if(date instanceof Date){
		date = date.toISOString().slice(0, 10);
	}
	var format = format.toLowerCase();
	//get id of element
	var format_array = format.split('-');
	var date = date.split('-');
	var d = 0;
	var m = 0;
	var y = 0;
	for(i =0; i<3; i++){
		if(format_array[i].substring(0, 1) == 'd'){
		d = i;
		}
		if(format_array[i].substring(0, 1) == 'm'){
		m = i;
		}
		if(format_array[i].substring(0, 1) == 'y'){
		y = i;
		}
	}
	
	var date_str = [];
	format_array = convert.split('-');
	for(i =0; i<3; i++){
		if(format_array[i].substring(0, 1) == 'd'){
			date_str.push(date[d]);
		}
		if(format_array[i].substring(0, 1) == 'm'){
			date_str.push(date[m]);
		}
		if(format_array[i].substring(0, 1) == 'y'){
			date_str.push(date[y]);
		}
	}
	date = date_str.join('-'); 
	return date;
}

function display_processing_form(enable){
	if(enable){
		jQuery('body').append('<img id="jbform_loading"  style="position: fixed;top:50%;left: 50%;margin-left: -100px;margin-top: -100px;width:200px;height:200px;" src="'+siteURL+'/wp-content/themes/news/images/loading.gif"/>');

	}else{
		jQuery('#jbform_loading').remove();
	}
}




