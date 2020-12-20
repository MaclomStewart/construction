(function( $ ) {
	'use strict';

	$(document).on("click", '[data-slug="different-menus-in-different-pages"] .deactivate a', function(e){
		e.preventDefault();
	});
})( jQuery );

// External JS: JS Helper Functions
// External JS: Dynamics JS

var btnOpen = select('[data-slug="different-menus-in-different-pages"] .deactivate a');
var btnClose = select('.js-close');
var modal = select('.js-modal');
var full_page_dark = select('.full_page_dark');
var modalChildren = modal.children;

function hideModal() {
  dynamics.animate(modal, {
    opacity: 0,
    translateY: 100
  }, {
    type: dynamics.spring,
    frequency: 50,
    friction: 600,
    duration: 1500
  });
}

function showModal() {
  // Define initial properties
  dynamics.css(modal, {
    opacity: 0,
    scale: .5
  });
  
  // Animate to final properties
  dynamics.animate(modal, {
    opacity: 1,
    scale: 1
  }, {
    type: dynamics.spring,
    frequency: 300,
    friction: 400,
    duration: 1000
  });
}

function showBtn() {
  dynamics.css(btnOpen, {
    opacity: 0
  });
  
  dynamics.animate(btnOpen, {
    opacity: 1
  }, {
    type: dynamics.spring,
    frequency: 300,
    friction: 400,
    duration: 800
  });
}

function showModalChildren() {
  // Animate each child individually
  for(var i=0; i<modalChildren.length; i++) {
    var item = modalChildren[i];
    
    // Define initial properties
    dynamics.css(item, {
      opacity: 0,
      translateY: 30
    });

    // Animate to final properties
    dynamics.animate(item, {
      opacity: 1,
      translateY: 0
    }, {
      type: dynamics.spring,
      frequency: 300,
      friction: 400,
      duration: 1000,
      delay: 100 + i * 40
    });
  } 
}

function toggleClasses() {
  toggleClass(btnOpen, 'is-active');
  toggleClass(modal, 'is-active');
  toggleClass(full_page_dark, 'active');

}

// Open nav when clicking sandwich button
btnOpen.addEventListener('click', function(e) {
  toggleClasses();
  showModal();
  showModalChildren();
});

// Open nav when clicking sandwich button
btnClose.addEventListener('click', function(e) {
  hideModal();
  dynamics.setTimeout(toggleClasses, 500);
  dynamics.setTimeout(showBtn, 500);
});
			
/*	jQuery(document).on("click", '.deactivate_reason',function(){
		if (jQuery('.deactivate_reason #other').is(":checked")) {
			jQuery('#deactivate_reasone_text').css('display', 'block');
		} else {
			jQuery('#deactivate_reasone_text').css('display', 'none');
		}
		
	});	*/

	jQuery(document).on("click", ".full_page_dark", function(){
		jQuery('.js-close').click();
	});

	jQuery(document).on("click", ".plugin-deactivate", function(){
		if ( jQuery('[name="deactivate_reason"]').is(":checked")) {
			
			 var datas = {
			  'site': deactivate_reason.home_url,
			  'reason': jQuery('[name="deactivate_reason"]:checked').val(),
			  'custom_text': jQuery('#deactivate_reasone_text').val(),
			  'plugin_name': 'Different Menu in Different Pages'
			};
			
			jQuery.ajax({
			    url: 'https://myrecorp.com/plugin-auto-update/dmidp_deactivate.php',
			    data: datas,
			    type: 'post',
			
			    beforeSend: function(xhr){
			        
			    },
			    success: function(r){
			    	window.location.href = jQuery('[data-slug="different-menus-in-different-pages"] .deactivate a').attr('href');
			    }, error: function(){
			    	window.location.href = jQuery('[data-slug="different-menus-in-different-pages"] .deactivate a').attr('href');
			  }
			});
		} else {
			jQuery('.select-a-reason').show();
		}
	});