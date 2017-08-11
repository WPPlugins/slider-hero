(function( $ ) {
 
 
		//Slider Preview Option//
	$('.qchero_preview').on ("click", function(e){
		e.preventDefault();
		jQuery(".qchero_save_all").click();
		id = $(this).data('id');
		setTimeout(
					function() {
					$.post(
						ajaxurl,
						{
							action : 'qcld_show_preview_items',
							sid : id,
							
						},
						function(data){
							
							$('#wpwrap').append(data);
							
						}
					)
		}, 1000);

	})
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
    });
	
	$('#qchero-fullwidth').on("click", function(){
		 $('#qchero-fullscreen').removeAttr('checked');
	})
	
	$('#qchero-fullscreen').on("click", function(){
		 $('#qchero-fullwidth').removeAttr('checked');
	})
	
	$(document).on( 'click', '.modal-content .close', function(){
        $(this).parent().parent().remove();
    });
	$(document).on( 'click', '.botmclose', function(){
        $(this).parent().parent().parent().remove();
    });
	
/*	$('.myElements').each(function() {
	var elem = $(this);

	   // Save current value of element
	   elem.data('oldVal', elem.val());

	   // Look for changes in the value
	   elem.bind("propertychange change click keyup input paste", function(event){
		  // If value has changed...
		  if (elem.data('oldVal') != elem.val()) {
		   
			$('#preview_qchero').attr('needsave','1');   
		   
		   
		 }
	   });
	 });*/
//==============================================//	

//code for create button //
	$(document).on( 'click', '.qcheroitem-add-btn1', function(){
		
		var parelem = $(this).closest("li").prop("id");
		var exdata = $('#'+parelem+' .qcheroitem-add-btn').val();
		$.post(
			ajaxurl,
			{
				action : 'qcld_show_arrow_items',
				elem : parelem,
				btnval: exdata
			},
			function(data){
				
				$('#wpwrap').append(data);
				$('.color-field').wpColorPicker();
			}
		)
		
	 })
	 
	$(document).on( 'click', '.modal-content #cancel_the_button', function(){
		
		$('#'+$('.modal-content').data('elem')+' .qcheroitem-add-btn').val('');
		
		$('#'+$('.modal-content').data('elem')+' .qcheroitem-add-btn1').val('Add A Button');
		//alert($('.modal-content').data('self'));
		$(this).parent().parent().parent().parent().remove();
		
	})
	
	$(document).on( 'click', '.modal-content #add_the_button', function(){
		var btntxt = $('#hero_button_text').val();
		var btnurl = $('#hero_button_url').val();
		var tgt = $('#hero_button_target').val();

		var btnbdr = $('input[name=hero_button_border]:checked').val();
		var btnstyle = $('input[name=hero_button_style]:checked').val();
		var btnfontweight = $('#hero_button_font_weight').val();
		var btnfontsize = $('#hero_button_font_size').val();
		var btnletterspacing = $('#hero_button_letter_spacing').val();
		var btntcolor = $('#hero_button_text_color').val();
		var btnthovercolor = $('#hero_button_text_hover_color').val();
		var btnbgcolor = $('#hero_button_bg_color').val();
		var btnbghovercolor = $('#hero_button_bg_hover_color').val();
		
		var data = {
			button_text : btntxt,
			button_url : btnurl,
			button_target : tgt,
			button_border : btnbdr,
			button_style : btnstyle,
			button_font_weight : btnfontweight,
			button_font_size : btnfontsize,
			button_letter_spacing : btnletterspacing,
			button_color : btntcolor,
			button_hover_color : btnthovercolor,
			button_background_color : btnbgcolor,
			button_background_hover_color : btnbghovercolor
			
		}
	
		var d = JSON.stringify(data)
		
		$('#'+$('.modal-content').data('elem')+' .qcheroitem-add-btn').val(d);
		$(this).parent().parent().parent().parent().remove();
	})
	 

	
})( jQuery );