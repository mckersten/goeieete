<?php
/**
 * The template for displaying the footer.
 *
 * @package OceanWP WordPress theme
 */ ?>

        </main><!-- #main -->

        <?php do_action( 'ocean_after_main' ); ?>

        <?php do_action( 'ocean_before_footer' ); ?>

        <?php
        // Elementor `footer` location
        if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>

            <?php do_action( 'ocean_footer' ); ?>
            
        <?php } ?>

        <?php do_action( 'ocean_after_footer' ); ?>
                
    </div><!-- #wrap -->

    <?php do_action( 'ocean_after_wrap' ); ?>

</div><!-- #outer-wrap -->

<?php do_action( 'ocean_after_outer_wrap' ); ?>

<?php
// If is not sticky footer
if ( ! class_exists( 'Ocean_Sticky_Footer' ) ) {
    get_template_part( 'partials/scroll-top' );
} ?>

<?php
// Search overlay style
if ( 'overlay' == oceanwp_menu_search_style() ) {
    get_template_part( 'partials/header/search-overlay' );
} ?>

<?php
// If sidebar mobile menu style
if ( 'sidebar' == oceanwp_mobile_menu_style() ) {
    
    // Mobile panel close button
    if ( get_theme_mod( 'ocean_mobile_menu_close_btn', true ) ) {
        get_template_part( 'partials/mobile/mobile-sidr-close' );
    } ?>

    <?php
    // Mobile Menu (if defined)
    get_template_part( 'partials/mobile/mobile-nav' ); ?>

    <?php
    // Mobile search form
    if ( get_theme_mod( 'ocean_mobile_menu_search', true ) ) {
        get_template_part( 'partials/mobile/mobile-search' );
    }

} ?>

<?php

// If full screen mobile menu style
if ( 'fullscreen' == oceanwp_mobile_menu_style() ) {
    get_template_part( 'partials/mobile/mobile-fullscreen' );
}?>


<div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">X</div>
        <p>Selecteer enkele productopties voordat u dit product aan uw winkelwagentje toevoegt.</p>
    </div>
</div>
<style>.sidr-class-dropdown-menu li.dk>a>.sidr-class-dropdown-toggle:before {
    content: '-';
}</style>
<?php 
/*if((is_checkout()) || (get_the_ID()==29925 || get_the_ID()==29877 || get_the_ID()==7)){?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCu_gQvJq7238E-ILpfhilYXAM-lxFPcD4&callback=initMap&language=nl&region=NL"
  type="text/javascript"></script>
 <script src="https://maps.googleapis.com/maps/api/js"></script><?php }*/ ?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/mobile-slider.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-33084765-1', 'auto');
  ga('send', 'pageview');
 
</script> 
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '2374181639306374');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2374181639306374&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script>
jQuery('#user_pickup_location').change(function(){
		
		var location_val=jQuery(this).val();
		
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		 jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                            action: 'Change_pckpulocation',
                            location_val : location_val,
                    },
                    success : function( response ) {
                            jQuery('.chng_location').html(response);
                    }
        
		});
		
	});
        jQuery('.ajax_add_to_cart').click(function(){

		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		 jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                            action: 'wp_wcmenucartmy',
                    },
                    success : function( response ) {
                        var strwc = response;
strwc = strwc.slice(0, -1);
                            jQuery('.wcmenucart-details').text('');
                            jQuery('.wcmenucart-details').text(strwc);
                    }
        
		});
		
	});
        
       function uptkrt(){

		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		 jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                            action: 'wp_wcmenucartmy',
                    },
                    success : function( response ) {
                        var strwc = response;
strwc = strwc.slice(0, -1);
                            jQuery('.wcmenucart-details').text('');
                            jQuery('.wcmenucart-details').text(strwc);
                    }
        
		});		
	}
       <?php if((is_checkout()) || (get_the_ID()==29925 || get_the_ID()==29877 || get_the_ID()==7)){?>
	function initialize() {
		jQuery('#loc_address').hide();
		
		var map = new google.maps.Map(document.getElementById("loc_address"));
		var geocoder = new google.maps.Geocoder();
		jQuery("#user_pickup_location").change(function() {
			jQuery('#loc_address').show();
			var addresstext = jQuery("#user_pickup_location :selected")[0].text;

			addressval = jQuery("#user_pickup_location :selected").val();
			VP = jQuery("#user_pickup_location option[name="+addressval+"_vP]").val();
			address=addresstext+' :'+VP;
			
			console.log(VP);
			geocodeAddress(address, geocoder, map);
		});

		//var address = jQuery("#user_pickup_location :selected")[0].text;
		var addresstext = jQuery("#user_pickup_location :selected")[0].text;

		var	addressval = jQuery("#user_pickup_location :selected").val();
		var VP = jQuery("#user_pickup_location option[name="+addressval+"_vP]").val();
		var address=addresstext+' :'+VP;


		
		geocodeAddress(address, geocoder, map);
		/* marker = new google.maps.Marker({
				position: new google.maps.LatLng(48.427519,-123.365695),
				map: map,
		}); */
	   
	}
	google.maps.event.addDomListener(window, "load", initialize);
	
	function geocodeAddress(address, geocoder, resultsMap) {
            if (typeof address !== "undefined") {
	  document.getElementById('info').innerHTML = 'Nog geen afhaallocatie geselecteerd';
            }else{                 
                 document.getElementById('info').innerHTML = address;
            }
	  geocoder.geocode({
		'address': address
	  }, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
		  resultsMap.fitBounds(results[0].geometry.viewport);
		  
		   var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
			//alert(address);
			var result_A = address.split(':');
			
			
			var title=result_A[0];
			var content=result_A[1];
			var content1=content.split(',');
			console.log(content1);
			
			document.getElementById('info').innerHTML = "<span class='maptitle'>" + title + "</span><br/>";
			
			jQuery.each( content1, function( key, value ) {
			 // alert( key + " " + value );
			 jQuery('#info').append(value+',<br/>');
			 // document.getElementById('info').innerHTML =  "<br/>" + value;
			});
			
			
		  
		  //document.getElementById('info').innerHTML += "<br>" + results[0].geometry.location.toUrlValue(6);
		 
		} else {
		 // alert('Geocode was not successful for the following reason: ' + status);
		}
	  });
	  
	  
	  
	}
       <?php } ?>
	
	
	jQuery(document).ready(function(){
		//alert();
		setTimeout(function(){ jQuery('.sidr-class-mobile-searchform').attr('action','/bestellen/'); }, 1500);
                <?php  if((is_checkout()) || (get_the_ID()==29925 || get_the_ID()==29877 || get_the_ID()==7)){?>
                initMap();
                <?php } ?>
	});
	var tagdrop = jQuery('.tagswrapper');

	if(tagdrop.length){
		console.log('found');
		jQuery("<select />").appendTo(".tagswrapper");
	  	// Create default option "Go to..."
	  	jQuery("<option />", {
	    	selected: "selected",
		    value: "",
		    text: "DIRECT NAAR"
	  	}).appendTo(".tagswrapper select");

	  	// Populate dropdown with menu items
	  	jQuery(".tagswrapper ul li a").each(function() {
		    var el = jQuery(this);
		    jQuery("<option />", {
		      value: el.attr("href"),
		      text: el.text()
		    }).appendTo(".tagswrapper select");
	  	});

	  	jQuery(".tagswrapper select").addClass("tagselect");
	  	// To make dropdown actually work
  		// To make more unobtrusive: https://css-tricks.com/4064-unobtrusive-page-changer/
	  	jQuery(".tagswrapper select").change(function() {
		    window.location = jQuery(this)
	      	.find("option:selected")
	      	.val();
	  	});
	}



jQuery('.single_add_to_cart_button').click(function(){
	
	var variation_id = jQuery('.variation_id').val();
		jQuery('.single_add_to_cart_button').removeClass('wc-variation-selection-needed');
	
		if(variation_id == 0 )
		{
			jQuery('.hover_bkgr_fricc').show();
		} 
		else {
			jQuery('.hover_bkgr_fricc').hide();
		}
	
	
});

jQuery('.popupCloseButton').click(function(){
	jQuery('.hover_bkgr_fricc').hide();
	
});
jQuery('.mobile-menu').click(function(){
	jQuery('#sidr-id-menu-item-75').addClass('dk');
    });
jQuery('.sidr-class-dropdown-toggle').click(function(){
	jQuery('#sidr-id-menu-item-75').removeClass('dk');
    });
	
</script>




<?php wp_footer(); ?>
</body>
</html>