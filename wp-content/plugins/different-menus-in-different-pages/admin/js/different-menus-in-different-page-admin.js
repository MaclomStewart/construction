(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).on("click", ".add_different_menu", function(event){
	 	event.preventDefault();

	 	var menu_items = jQuery(this).closest('td').children('.different_menus_list').children(".menu_items").length;
	 	
	 	//console.log(menu_items);
	 	if (menu_items < 6) {
	 		jQuery(this).closest('td').children('.different_menus_list').append(jQuery('.all_menu_options').html());
	 	} else {
	 		$.notify({
					// options
					message: 'You can\'t add more than 3 different menu in a location in free version! Please upgrade to pro.' 
				},{
					// settings
					type: 'danger',
					placement: {
						from: "top",
						align: "center"
					},
					animate:{
						enter: "animated fadeInDown",
						exit: "animated fadeOutUp"
					}
				}

				);
	 	}
	 	
	 });

	$(document).on("click", ".different_menus_list .setup", function(event){
	 	event.preventDefault();
	 
		 var attr = $(this).attr('conditions');

	// For some browsers, `attr` is undefined; for others,
	// `attr` is false.  Check for both.
		if (typeof attr !== typeof undefined && attr !== false) {
		    var checked_items = $(this).attr('conditions');

		 	checked_items = checked_items.replace(/\[name='/g, "");
		 	checked_items = checked_items.replace(/'\]/g, "");

		 	$('.checked_items').html(checked_items + ",");
		}

	});


$(document).on("show.bs.modal", function(){
	$("#set_conditions.modal .modal-dialog").addClass("animated");
});

      $("#set_conditions.modal").each(function (l) {$(this).on("show.bs.modal", function (l) {var o = $(this).attr("data-easein");"shake" == o ? $(".modal-dialog").velocity("callout." + o) : "pulse" == o ? $(".modal-dialog").velocity("callout." + o) : "tada" == o ? $(".modal-dialog").velocity("callout." + o) : "flash" == o ? $(".modal-dialog").velocity("callout." + o) : "bounce" == o ? $(".modal-dialog").velocity("callout." + o) : "swing" == o ? $(".modal-dialog").velocity("callout." + o) : $(".modal-dialog").velocity("transition." + o);});});
      //# sourceURL=pen.js
    
    $(function() {
  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });
});


$(document).on("click", ".different_menus_list .setup.button", function(event){
	//.setup_active_menu

	var theme_location = $(this).closest('tr').children('td[location]').attr('location');
	var assigned_menu = $(this).siblings('.assigned_menu').children(':selected').val();

	$('.different_menus_list .setup.button').removeClass('active');
	$(this).addClass("active");

	var disable_conditions = $(this).closest('.different_menus_list').find('.setup').not($(this));

	$(disable_conditions).each(function(){
		var disable = $(this).attr('conditions');
		console.log(disable);

		$(disable).each(function(){
			$(this).parent().addClass("disabled");
		});
		

		$(disable).attr("disabled", "disabled");
	});

	//$('[type="checkbox"]:disabled').tooltip('enable');
	  $('#tab-items [type="checkbox"]:disabled').tooltip({
	  	title: 'This item already using other different menu !',
	  });
	//$('[type="checkbox"]').tooltip('enable');
	//console.log(theme_location + "|" + assigned_menu);

	$('.setup_active_menu').attr('theme_location', theme_location).attr('assigned_menu', assigned_menu);

	if (assigned_menu) {
	 $('#set_conditions').modal('show');

	 if ($('.different_menus_list .setup[conditions]').length) {
		var condition_checked = $(this).attr('conditions');
	 		$(condition_checked).attr('checked', 'checked')
	 }
	}
});



$(document).on("click", "#set_conditions .save_conditions", function(){

	var conditions = [];
	var main = new Object();
	var name = [];
	//var value = [];

	var theme_location = $('.setup_active_menu').attr('theme_location');
	var assigned_menu = $('.setup_active_menu').attr('assigned_menu');


	var checked_items = $('.checked_items').html();
	checked_items = checked_items.replace(/,\s*$/, "");

	checked_items = checked_items.split(",");

	

	for (var i = 0; i < checked_items.length; i++) {
		name.push(checked_items[i]);
	}


	var changed 				= false;
	var changed_menu 			= "";
	var changed_theme_location 	= "";

	if( $(".change_selected_menu[changed_menu]").length ){
		changed 				= true;
		changed_menu 			= $(".change_selected_menu[changed_menu]").attr("changed_menu");;
		changed_theme_location 	= $(".change_selected_menu[changed_menu]").attr("theme_location");;
	}
	 var datas = {
	  'action'			: 'save_different_menu_conditions',
	  'name'			: name,
	  //'value': value,
	  'theme_location'	: theme_location,
	  'assigned_menu'	: assigned_menu,

	  //if menu has changed
	  'changed'					: changed,
	  'changed_menu'			: changed_menu,
	  'changed_theme_location'	: changed_theme_location,
	  'nonce'					: dmfdp.nonce

	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	$('.different_menus_list .setup.button.active').attr('conditions', r);
	    	$('.different_menus_list .setup.button.active').closest('.menu_items').addClass('active_now');

	    	if(!$('.different_menus_list .setup.button.active').parent().children('.menu-delete').length){
	    		$('.different_menus_list .setup.button.active').parent().append('<button type="button" class="close menu-delete float-left" aria-label="Close" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove this menu"><span aria-hidden="true">×</span></button>');
	    	}

	
	    	if(!$('.different_menus_list .setup.button.active').parent().children('.badge-success').length){
	    		//setTimeout(function() {	
		    		$('.different_menus_list .setup.button.active').parent().append('<span class="badge badge-success">Saved!</span>');
		    		
		    		setTimeout(function() {
		    			$('.badge-success').remove();
		    		}, 5000);
				//}, 5000);
	    	}	

	    	if(!$('.different_menus_list .setup.button.active').parent().children('.badge-success').length){
	    		$('.different_menus_list .setup.button.active').parent().append('<span class="badge badge-success">Success</span>');
	    		
	    		setTimeout(function() {
	    			$('.badge-success').remove();
	    		}, 5000);
	    	}

	    	//<span class="badge badge-success">Success</span>
	    	$('#set_conditions').modal('hide');

	    	$.notify({
					// options
					message: 'Successfully saved the menu!' 
				},{
					// settings
					type: 'success',
					placement: {
						from: "top",
						align: "center"
					},
					animate:{
						enter: "animated fadeInDown",
						exit: "animated fadeOutUp"
					},
					delay: 2000
				}

				);

	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

$(document).on("hidden.bs.modal", function(){
	$('#set_conditions [type="checkbox"]:checked').removeAttr('checked');
	$('.different_menus_list .setup.button').removeClass("active");
	$('#set_conditions [type="checkbox"]:disabled').removeAttr("disabled");


	$('.change_selected_menu').removeAttr("changed_menu");
	$('.change_selected_menu').removeAttr("theme_location");

	//$('[type="checkbox"]').tooltip('disable');
});

$(document).on("click", ".assigned_menu", function(){
	var all_menus = $(this).closest('.different_menus_list').find($('.assigned_menu'));
	var this_ = $(this);
		this_.children('option').removeAttr('disabled');
	$(all_menus).each(function(){
		if ($(this).children(":selected").val() !== "") {
			var valu = $(this).children(':selected').val();

			this_.children('[value="'+valu+'"]').attr('disabled', 'disabled');
			this_.children('[value="'+this_.closest('td').children('.default_menu').children('.assigned_menu').children(':selected').val()+'"]').attr('disabled', 'disabled');
		}
	});
});

$(document).on("click", ".remove_diff_menus", function(){
	 var datas = {
	  'action'	: 'remove_all_different_menus',
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	console.log(r);
	    	$('#resetDifferentMenusConditions').modal("hide");

	    	$.notify({
					// options
					message: 'The settings has removed! The page will reload soon' 
				},{
					// settings
					type: 'danger',
					placement: {
						from: "top",
						align: "center"
					},
					animate:{
						enter: "animated fadeInDown",
						exit: "animated fadeOutUp"
					},
					delay: 2000
				});
	    
	    	setTimeout(function() {
	    		window.location.reload();
	    	}, 5000);
	    	
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

$(document).on("click", ".btn-backup_settings", function(){
	 var datas = {
	  'action'	: 'backup_different_menus_data',
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){  
			exportToCsv('different-menus-backup '+recorpGetDateTime()+'.csv', r);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

function exportToCsv(filename, rows) {
        var processRow = function (row) {
            var finalVal = '';
            for (var j = 0; j < row.length; j++) {
                var innerValue = row[j] === null ? '' : row[j].toString();
                if (row[j] instanceof Date) {
                    innerValue = row[j].toLocaleString();
                };
                var result = innerValue.replace(/"/g, '""');
                if (result.search(/("|,|\n)/g) >= 0)
                    result = '"' + result + '"';
                if (j > 0)
                    finalVal += ',';
                finalVal += result;
            }
            return finalVal + '\n';
        };

        var csvFile = '';
        for (var i = 0; i < rows.length; i++) {
            //csvFile += processRow(rows[i]);
        }
        csvFile = rows;
        var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }
    
function recorpGetDateTime() {
        var now     = new Date(); 
        var year    = now.getFullYear();
        var month   = now.getMonth()+1; 
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds(); 
        if(month.toString().length == 1) {
             month = '0'+month;
        }
        if(day.toString().length == 1) {
             day = '0'+day;
        }   
        if(hour.toString().length == 1) {
             hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
             minute = '0'+minute;
        }
        if(second.toString().length == 1) {
             second = '0'+second;
        }   
        var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
         return dateTime;
    }


$(document).on("change", "#restore_settings", function(){
	//console.log(openFile($(this).val()));

	  if (this.files && this.files[0]) {
    var myFile = this.files[0];
    var reader = new FileReader();
    
    reader.addEventListener('load', function (e) {
      $('.restore_settings_data_as_txt').html(e.target.result);
    });
    
    reader.readAsBinaryString(myFile);
  } 

});


$(document).on("click", ".btn-restore_settings", function(){
	var settings = $('.restore_settings_data_as_txt').html();

	//console.log(settings);

	 var datas = {
	  'action'	: 'restore_different_menus_settings_data',
	  'settings': settings,
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	console.log(r);

	    	$('#backupAndRestore').modal('hide');

	    	$.notify({
					// options
					message: '<span class="text-center">Successfully restored the settings! The page will reload soon.</span>' 
				},{
					// settings
					type: 'success',
					placement: {
						from: "top",
						align: "center"
					},
					animate:{
						enter: "animated fadeInDown",
						exit: "animated fadeOutUp"
					},
					delay: 2000
				}
			);

			setTimeout(function() {
				window.location.reload();
			}, 5000);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip({
  	//container: 'body',
  	delay: { "show": 500, "hide": 100 }
  })
});


$(document).on("click", ".menu-delete", function(){
	$('[data-toggle="tooltip"]').tooltip('hide');

	var theme_location = $(this).closest('tr').children('td[location]').attr('location');
	var assigned_menu = $(this).siblings('.assigned_menu').children(':selected').val();
	$('.setup_active_menu').attr('theme_location', theme_location).attr('assigned_menu', assigned_menu);

	//console.log(theme_location + "|" + assigned_menu);
	$('#removeMenu').modal("show");

	$('.menu_items').removeClass("active_now");
	$(this).closest('.menu_items').addClass("active_now");

});


$(document).on("click", ".remove_diff_menu", function(){
	var theme_location = $('.setup_active_menu').attr('theme_location');
	var assigned_menu = $('.setup_active_menu').attr('assigned_menu');

	 var datas = {
	  'action'			: 'remove_different_menu',
	  'theme_location'	: theme_location,
	  'assigned_menu'	: assigned_menu,
	  'nonce'			: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	$('#removeMenu').modal("hide");

	    	setTimeout(function() {
	    		$('.menu_items.active_now').css({'background-color': '#f00e0e'});
	    	}, 500);

	    	setTimeout(function() {
	    		$('.menu_items.active_now').remove();
	    	}, 700);

	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

$(document).on("mouseenter", "#set_conditions #tab-items label", function(e){
	if ($(this).children(":disabled").length) {
		var this_ = $(this);
		this_.children(":disabled").tooltip("show");
	}

	$(e.target).mouseout(function(){
    	$(this).children(":disabled").tooltip("hide");
    });
});

$(document).on("change", ".assigned_menu[selected_menu]", function(){
	var changed_menu = $(this).attr("selected_menu");
	var theme_location = $(this).closest('tr').children('td[location]').attr('location');

	$('.change_selected_menu').attr("changed_menu", changed_menu);
	$('.change_selected_menu').attr("theme_location", theme_location);
});

$(document).on("click", ".add_different_menu", function(){
	$('.change_selected_menu').removeAttr("changed_menu");
	$('.change_selected_menu').removeAttr("theme_location");
});

$(document).on("click", "#pages .page-link", function(e){
	e.preventDefault();

	var paged = $(this).attr("page_id");

	 var datas = {
	  'action'	: 'ajax_paged_change',
	  'paged'	: paged,
	  'key'		: 'page',
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	$('#pages').html(r);
	    	//console.log(r);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});


$(document).on("click", "#categories .page-link", function(e){
	e.preventDefault();

	var paged = $(this).attr("page_id");

	 var datas = {
	  'action'	: 'ajax_paged_change',
	  'paged'	: paged,
	  'key'		: 'category',
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	$('#categories').html(r);
	    	//console.log(r);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});



$(document).on("click", "#post_types .page-link", function(e){
	e.preventDefault();

	var paged = $(this).attr("page_id");
	var post_type = $(this).closest('[post_type]').attr('post_type');
	var this_ = $(this);

	 var datas = {
	  'action': 'ajax_paged_change',
	  'paged': paged,
	  'key': 'post_types',
	  'post_type': post_type,
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	this_.closest('[post_type]').html(r);
	    	//console.log(r);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});

$(document).on("click", "#taxonomies .page-link", function(e){
	e.preventDefault();

	var paged = $(this).attr("page_id");
	var tax = $(this).closest('[tax]').attr('tax');
	var this_ = $(this);

	 var datas = {
	  'action'	: 'ajax_paged_change',
	  'paged'	: paged,
	  'key'		: 'tax',
	  'tax'		: tax,
	  'nonce'	: dmfdp.nonce
	};
	
	$.ajax({
	    url: dmfdp.ajax_url,
	    data: datas,
	    type: 'post',
	
	    success: function(r){
	    	this_.closest('[tax]').html(r);
	    	//console.log(r);
	    }, error: function(){
	    	alert('Something went wrong !');
	  }
	});
});


$(function () {
  $('[data-toggle="popover"]').popover({
  	placement: "top",
  	container: "body"
  });
})

$(document).on("mouseover", ".backup-restore", function(e){
  $('[data-toggle="popover"]').popover("show");

  $(e.target).mouseout(function(){
  	$('[data-toggle="popover"]').popover("hide");
  });
});



$(document).on("change", '#set_conditions [type="checkbox"]', function(){

	if ($(this).is(":checked")) {
		var names = $(this).attr('name');
		$('.checked_items').html($('.checked_items').html() + names + ",");
	} else {
		var names = $(this).attr('name') + ",";
		var pages_checked_pagi_html = $('.checked_items').html();
		pages_checked_pagi_html = pages_checked_pagi_html.replace(names, "");
		$('.checked_items').html(pages_checked_pagi_html);
	}

});



  jQuery(document).on("click", ".btn.duplicate", function(){
   		var selected_menu = jQuery("#menus.selected_menu").val();
   		var new_menu_name = jQuery("#new_menu.new_menu_name").val();

   		 var datas = {
   		  "action"			: "create_duplicate_menu",
   		  "selected_menu"	: selected_menu,
   		  "new_menu_name"	: new_menu_name,
   		  "nonce"			: dmfdp.nonce
   		
   		};

   		var this_ = jQuery(this);
   		
   		jQuery.ajax({
   		    url: dmfdp.ajax_url,
   		    data: datas,
   		    type: "post",
			
			  beforeSend: function( xhr ) {
			    this_.html("Duplicate <i class=\"fa fa-spinner fa-spin\" style=\"font-size:16px;\"></i>");
			  },

   		
   		    success: function(r){
   		    	//console.log(r);

   		    	this_.html("Duplicate");
   		    	jQuery("#new_menu.new_menu_name").val("");

   		    	jQuery("[data-dismiss=\"modal\"]").click();

   		    	jQuery.notify({
                    // options
                    message: "Manu has been duplicated successfully." 
                },{
                    // settings
                    type: "success",
                    placement: {
                        from: "top",
                        align: "center"
                    },
                    animate:{
                        enter: "animated fadeInDown",
                        exit: "animated fadeOutUp"
                    },
                    delay: 5000
                }

                );

   		    }, error: function(){
   		    	alert("Something went wrong !");
   		  }
   		});
  }); 


$(document).on("click", ".check_all", function(){
	if ($('#check_all').is(":checked")) {
		$('#tab-items input[type="checkbox"]').prop("checked", true).change();
	} else {
		$('#tab-items input[type="checkbox"]').prop("checked", false).change();
	}
});

$(document).on("click", ".parent_cat .parent input", function(){
	var this_ = $(this);
	setTimeout(function() {
		if (!this_.is(":checked")) {
			this_.closest('.parent_cat').find('input').prop("checked", false);
		} else {
			this_.closest('.parent_cat').find('input').prop("checked", true);
		}
	}, 100);
});

$(document).on("click", ".parent_cat .child_cat input", function(){
	var this_ = $(this);
	setTimeout(function() {
		if (!this_.is(":checked")) {
			this_.closest('.child_cats').find('input').prop("checked", false);
		} else {
			this_.closest('.child_cats').find('input').prop("checked", true);
		}
	}, 100);
});

$(document).on("click", ".parent_page .parent input", function(){
	var this_ = $(this);
	setTimeout(function() {
		if (!this_.is(":checked")) {
			this_.closest('.parent_page').find('input').prop("checked", false);
		} else {
			this_.closest('.parent_page').find('input').prop("checked", true);
		}
	}, 100);
});

$(document).on("click", ".parent_page .child_page input", function(){
	var this_ = $(this);
	setTimeout(function() {
		if (!this_.is(":checked")) {
			this_.closest('.child_pages').find('input').prop("checked", false);
		} else {
			this_.closest('.child_pages').find('input').prop("checked", true);
		}
	}, 100);
});

})( jQuery );


