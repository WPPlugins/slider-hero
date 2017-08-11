<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit

function qcld_sliderhero_edit_slider_view( $_row, $_id, $_slider ) {
    function qcldsliderherodeleteSpacesNewlines( $str ) {
        return preg_replace( array( '/\r/', '/\n/' ), '', $str );
    }

    $style   = json_decode( $_slider[0]->style );
    $params  = json_decode( $_slider[0]->params );
    $customs = json_decode( ( $_slider[0]->custom ) );

	
    $paramsJson = qcldsliderherodeleteSpacesNewlines( $_slider[0]->params );
    $styleJson  = qcldsliderherodeleteSpacesNewlines( $_slider[0]->style );
    $customJson = qcldsliderherodeleteSpacesNewlines( $_slider[0]->custom );

    $count = 0;
    foreach ( $_row as $slide ) {
        if ( $slide->published == 0 ) {
            continue;
        }
        $count ++;
    }; 
	//print_r($_slider[0]->bg_gradient);exit;

	?>
    <script>
        

        // initialize slider values in slider admin page
        var qcheror = {
            id: '<?php echo $_id;?>',
            name: '<?php echo $_slider[0]->title;?>',
            params: JSON.parse('<?php echo $paramsJson;?>'),
            style: JSON.parse('<?php echo $styleJson;?>'),
            custom: JSON.parse('<?php echo $customJson;?>'),
            count: parseInt('<?php echo $count;?>'),
            length: 0,

            slides: {}
        };
        <?php
        $Slidecount = 0;
        foreach ($_row as $row) {
        $Slidecount ++;
        $customSlideJson = qcldsliderherodeleteSpacesNewlines( $row->custom );
        $image_link = esc_js( html_entity_decode( $row->image_link, ENT_COMPAT, 'UTF-8' ) );
        $description = esc_js( html_entity_decode( $row->description, ENT_COMPAT, 'UTF-8' ) );
        $title = esc_js( html_entity_decode( $row->title, ENT_COMPAT, 'UTF-8' ) );
        ?>
        // initialize slider's slides's values in slider admin page
        qcheror['slides']['slide' + '<?php echo $row->id;?>'] = {};
        qcheror['slides']['slide' + '<?php echo $row->id;?>']['id'] = '<?php echo $row->id;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['title'] = '<?php echo $title;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['description'] = '<?php echo $description;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['image_link'] = '<?php echo $image_link;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['url'] = '<?php echo $row->thumbnail;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['type'] = '<?php echo $row->type;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['published'] = +'<?php echo $row->published;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['ordering'] = +'<?php echo $row->ordering;?>';
        qcheror.slides['slide' + '<?php echo $row->id;?>']['custom'] = JSON.parse('<?php echo $customSlideJson;?>');
        <?php
        }?>
        qcheror.length = +'<?php echo $Slidecount;?>';
    </script>
    <div class="qchero_slider_view_wrapper">
        <div id="qchero_slider_view">
            <div class="add_slide_container">
                <a id="add_image"><span><?php _e( 'Add Slide', 'qchero' ); ?></span><span><i style="color:#000" class="fa fa-plus"
                                                                 aria-hidden="true"></i></span></a>
            </div>

            <div class="qchero_slider_images_list_wrapper">
                <ul id="qchero_slider_images_list">
                    <?php if ( ! count( $_row ) ) {
                        ; ?>
                        <li class="noimage">
							<span class="noimage-add" href="#">No Slides!</span>
                        </li>
                        <?php
                    }
                    foreach ( $_row as $rows ) {
                        switch ( $rows->type ) {

                            default: ?>
                                <li id="qcheroitem_<?php echo $rows->id; ?>" class="qcheroitem">
                                    <div class="qcheroitem-img-container">
										<div class="qcheroitem-image">
											<div class="slide_image_container">
											<?php if(isset($rows->image_link) and $rows->image_link!=''): ?>
												<img src="<?php echo $rows->image_link; ?>" />
												<span class="qchero_slide_image_remove" data-slide-id="<?php echo $rows->id; ?>" title="Remove image">X</span>
											<?php else: ?>
												<button class="qchero_slide_image_upload" data-slide-id="<?php echo $rows->id; ?>">browse</button>
											<?php endif; ?>
											</div>
										</div>
                                        <div class="qcheroitem-properties">
                                            <b><a href="#" class="quick_edit"
                                                  data-slide-id="<?php echo esc_attr($rows->id); ?>"><i
                                                        class="fa fa-compress" aria-hidden="true"></i><span>Collapse</span></a></b>
                                            </a>
                                            <b><a href="#" class="qchero_remove_image"
                                                  data-slide-id="<?php echo esc_attr($rows->id); ?>"><i class="fa fa-remove"
                                                                                              aria-hidden="true"></i><span>Remove</span></a></b>
                                            <b><label href="#" class="qchero_on_off_image"><input style="margin-top: 0px;"
                                                        data-slide-id="<?php echo $rows->id; ?>"
                                                        class="slide-checkbox" <?php if ( $rows->published == 1 ) {
                                                        echo 'checked  value="1"';
														}else{echo 'value="0"';} ?>
                                                        type="checkbox"/><span><span style="margin-top: 2px;">Published</span></label></b>
											<b style="margin-right:10px;cursor:move"><i class="fa fa-arrows" aria-hidden="true"></i><span>Move</span></b>
                                        </div>
                                        <form class="qchero-nodisplay">
                                            <input type="text" class="qcheroitem-edit-title"
                                                   value="<?php echo wp_unslash( $rows->title ); ?>">
                                            <textarea
                                                class="qcheroitem-edit-description"><?php echo ($rows->description==''?'Subtitle':qchero_text_sanitize( $rows->description )); ?></textarea>
											<input type="hidden" class="qcheroitem-add-btn"
                                                   value="<?php echo wp_unslash( esc_js($rows->btn) ); ?>" placeholder="Add Button">
											<input type="button" class="qcheroitem-add-btn1" style="width: 99%;border: 1px solid #ddd;" value="<?php echo (isset($rows->btn)&&strlen($rows->btn)>10)?'Edit Button':'Add A Button';?>" />  
											<input type="hidden" class="qcheroitem-add-url" value="<?php echo esc_attr($rows->image_link); ?>">
                                            <input type="hidden" class="qcheroitem-ordering"
                                                   value="<?php echo esc_attr($rows->ordering); ?>">
                                        </form>
										</div>
                                </li>
                                <?php
                        }
                    } ?>
                </ul>
                <button id="save_slider">Save Slide Changes</button>
            
			</div>
        </div>
        
		
        <div id="qchero_slider_edit">
		
			<div class="sliderhero_menu_title" style="margin-left: 1.5%;margin-bottom: 10px;width: 95.3%;margin-top: 7px;">
				<h2 style="font-size: 26px;text-align:center;"><?php 
					if($_slider[0]->type=='torus'){
						echo 'Torus of Cubes';
					}elseif($_slider[0]->type=='no_effect'){
						echo 'No Effect';
					}elseif($_slider[0]->type=='particle'){
						echo 'Particle Effect';
					}elseif($_slider[0]->type=='particle_snow'){
						echo 'Snow Effect';
					}elseif($_slider[0]->type=='particle_nasa'){
						echo 'NASA';
					}elseif($_slider[0]->type=='particle_bubble'){
						echo 'Bubble';
					}elseif($_slider[0]->type=='nyan_cat'){
						echo 'Nyan Cat';
					}
				?>
				</h2>		
			</div>
		
			<div class="sliderhero_menu_title" style="margin-left: 1.5%;margin-bottom: 10px;width: 95.3%;margin-top: 7px;">
				<h2 style="font-size: 26px;"><?php echo wp_unslash($_slider[0]->title); ?></h2>
                    <a class="qchero_save_all" href="#">Save</a>
					<a class="qchero_preview" href="#" data-id="<?php echo $_id; ?>" style="margin-right: 12px;">Save & Preview</a>	
                			
			</div>
            <div class="settings">
				
			    <div class="menu">
				
                    <ul>
                        <li rel="general"><a href="#" class="active">General Settings</a></li>
                        <li rel="display-setting"><a href="#" class="">Display Settings</a></li>
                        <li rel="Effect-setting"><a href="#" class="">Effect Settings</a></li>
                        <li rel="arrows"><a href="#" class="">Arrows</a></li>
                        <li rel="shortcodes"><a href="#">Shortcode</a></li>
                    </ul>
                </div>
                <div class="menu-content">
                    <ul class="main-content">
                        <li class="general active">
                            <ul id="general-settings">
                                <li class="style designstyle"><label for="qchero-name">Name:</label><input class="myElements" id="qcheror-name"
                                                                                                name="cs[name]" type="text"
                                                                                                value="<?php echo stripslashes_deep($_slider[0]->title); ?>"/>
                                </li>
                                <li class="style designstyle"><label for="qcslide-width">Width(px):</label><input class="myElements" style="width:40%" id="qcslide-width" name="style[width]"type="number" value="<?php echo esc_attr($style->width); ?>"/>
								
								<span style="    color: #000;
    margin-right: 4px;
    display: inline-block;
    margin-left: 20px;">Custom:</span> <input class="myElements" name="style[fullwidth]" style="display: inline-block;width: 13px;height: 16px;margin: 0px;float: none;" type="radio" value="0" <?php 
									if(isset($style->screenoption) and $style->screenoption=='0'){
										echo "checked";
									}else{
										echo "checked";
									}
								?>/>
								<span style="    color: #000;
    margin-right: 4px;
    display: inline-block;
    margin-left: 20px;">Full Width:</span> <input class="myElements" name="style[fullwidth]" style="display: inline-block;width: 13px;height: 16px;margin: 0px;float: none;" type="radio" value="1" <?php 
									if(isset($style->screenoption) and $style->screenoption=='1'){
										echo "checked";
									}
								?>/>
<span style="    color: #000;
    margin-right: 4px;
    display: inline-block;
    margin-left: 20px;">Full Screen:</span> <input class="myElements" name="style[fullwidth]" style="display: inline-block;width: 13px;height: 16px;margin: 0px;float: none;" type="radio" value="2" <?php 
									if(isset($style->screenoption) and $style->screenoption=='2'){
										echo "checked";
									}
								?>/>
								<span style="    color: #000;
    margin-right: 4px;
    display: inline-block;
    margin-left: 20px;padding: 10px 0px;">Auto:</span> <input class="myElements" name="style[fullwidth]" style="display: inline-block;width: 13px;height: 16px;margin: 0px;float: none;" type="radio" value="3" <?php 
									if(isset($style->screenoption) and $style->screenoption=='3'){
										echo "checked";
									}
								?>/>								
                                </li>
                                <li class="style designstyle"><label for="qcslide-height">Height(px):</label><input class="myElements" id="qcslide-height"
                                                                                                        name="style[height]"
                                                                                                        type="number"
                                                                                                        value="<?php echo esc_attr($style->height); ?>"/>
                                </li>
                                							

                            </ul>
							<div style="clear:both"></div>
							<div class="othersetting">
									<div class="params deseffect customitemstyle">
										<label class="customlevel" for="qchero-effect-interval"><?php _e('Pause Time', 'qchero'); ?>:</label>
										<input class="myElements" style="width: 96%;" type="number" name="params[effect][interval]"
											   value="<?php echo esc_attr($params->effect->interval); ?>">
									</div>
									<div class="params deseffect customitemstyle">
                                    <label class="customlevel" for="qcslide-effect-slideffect"><?php _e('Title Alignment', 'qcslide'); ?>:</label>
									<select class="myElements" name="params[title][align]" style="width: 96%;">
										
										
										<option value="left" <?php echo ($params->title->align=='left'?'selected="selected"':''); ?>><?php _e('Left', 'qcslide'); ?></option>
										
										<option value="center" <?php echo ($params->title->align=='center'?'selected="selected"':''); ?>><?php _e('Center', 'qcslide'); ?></option>
										
										<option value="right" <?php echo ($params->title->align=='right'?'selected="selected"':''); ?>><?php _e('Right', 'qcslide'); ?></option>
										
										
									</select>
                                    
                                </div>
								<div class="params deseffect customitemstyle">
                                    <label class="customlevel" for="qcslide-effect-slideffect"><?php _e('Description Alignment', 'qcslide'); ?>:</label>
									<select class="myElements" name="params[description][align]" style="width: 96%;">
										
										
										<option value="left" <?php echo ($params->description->align=='left'?'selected="selected"':''); ?>><?php _e('Left', 'qcslide'); ?></option>
										
										<option value="center" <?php echo ($params->description->align=='center'?'selected="selected"':''); ?>><?php _e('Center', 'qcslide'); ?></option>
										
										<option value="right" <?php echo ($params->description->align=='right'?'selected="selected"':''); ?>><?php _e('Right', 'qcslide'); ?></option>
										
										
									</select>
                                    
                                </div>
								
								<div class="params deseffect customitemstyle">
                                    <label class="customlevel" for="qcslide-effect-slideffect"><?php _e('Button Alignment', 'qcslide'); ?>:</label>
									<select class="myElements" name="params[button1][align]" style="width: 96%;">
										
										
										<option value="left" <?php echo ($params->button1->align=='left'?'selected="selected"':''); ?>><?php _e('Left', 'qcslide'); ?></option>
										
										<option value="center" <?php echo ($params->button1->align=='center'?'selected="selected"':''); ?>><?php _e('Center', 'qcslide'); ?></option>
										
										<option value="right" <?php echo ($params->button1->align=='right'?'selected="selected"':''); ?>><?php _e('Right', 'qcslide'); ?></option>
										
										
									</select>
                                    
                                </div>							
							</div>
							<div style="clear:both"></div>
	
                            <div id="general-view" >
								<div class="general_view_left">
									Order and Space out Title, Subtitle & Button positions.
								</div>
                                <div id="qchero-slider-construct" >
                                    <div id="qchero-construct-vertical"></div>
                                    <div id="qchero-construct-horizontal"></div>
                                    <div id="qchero-title-construct" data="title" class="qchero_construct">
                                        <div style="margin-left:5px;color:#565855">Title</div>
                                    </div>
									
                                    <div id="qchero-button1-construct" data="button1" class="qchero_construct">
                                        <div style="margin-left:5px;color:#565855">Button</div>
                                    </div>
									
                                    <div id="qchero-description-construct" data="description" class="qchero_construct">
                                        <div style="margin-left:5px;color:#565855">Description</div>
                                    </div>

                                    <div id="zoom" class="sizer">
                                    </div>
                                    <a id="qchero_remove" title="Remove Element"><i class="fa fa-remove"
                                                                                     aria-hidden="true"></i></a>
								</div>
							</div>
                        </li>
						<li class="display-setting">
							<div class="othersetting">


								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-background-color">Content Offset(Left & Right)</label> 
									<input type="text" placeholder="45px or 10%" value="<?php echo (isset($params->contentoffset)&& $params->contentoffset!=''?$params->contentoffset:''); ?>" name="params[contentoffset]" />
								</div>
								
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-background-color" style="display: inline-block;">Auto slide</label> 
									<select name="params[stopslide]">
										<option value="0" <?php echo (isset($params->stopslide)&& $params->stopslide==0?'selected="selected"':''); ?>>On</option>
										<option value="1" <?php echo (isset($params->stopslide)&& $params->stopslide==1?'selected="selected"':''); ?>>Off</option>
									</select>
								</div>
								<div class="params customitemstyle" >
									<label class="customlevel" for="qchero-caption-text-color" style="display: inline-block;">Arrows</label> 
									<select name="params[hidearrow]">
										<option value="0" <?php echo (isset($params->hidearrow)&& $params->hidearrow==0?'selected="selected"':''); ?>>Show</option>
										<option value="1" <?php echo (isset($params->hidearrow)&& $params->hidearrow==1?'selected="selected"':''); ?>>Hide</option>
									</select>
								</div>
								<div class="params customitemstyle" >
									<label class="customlevel" for="qchero-caption-text-color" style="display: inline-block;">Bottom Navigation</label> 
									<select name="params[hidenavigation]">
										<option value="0" <?php echo (isset($params->hidenavigation)&& $params->hidenavigation==0?'selected="selected"':''); ?>>Show</option>
										<option value="1" <?php echo (isset($params->hidenavigation)&& $params->hidenavigation==1?'selected="selected"':''); ?>>Hide</option>
									</select>
								</div>
										
							</div>						
							<div class="othersetting">
								<div class="params titlefontsize customitemstyle">
                                    <label class="customlevel" for="qchero-title-fontsize">Title Font Size(px)</label>
									<input class="myElements" type="number" name="params[titlefontsize]" value="<?php echo esc_attr($params->titlefontsize); ?>"  />
                                </div>
								<div class="params descfontsize customitemstyle">
                                    <label class="customlevel" for="qchero-desc-fontsize">Description Font Size(px)</label>
									<input class="myElements" type="number" name="params[descfontsize]" value="<?php echo esc_attr($params->descfontsize); ?>"  />
                                </div>	
								<div class="params titlefontsize customitemstyle">
                                    <label class="customlevel" for="qchero-title-fontsize">Title Font Height(px)</label>
									<input class="myElements" type="number" name="params[titlefontheight]" value="<?php echo esc_attr($params->titlefontheight); ?>"  />
                                </div>
								<div class="params descfontsize customitemstyle">
                                    <label class="customlevel" for="qchero-desc-fontsize">Description Font Height(px)</label>
									<input class="myElements" type="number" name="params[descfontheight]" value="<?php echo esc_attr($params->descfontheight); ?>"  />
                                </div>	
									
								
								
							</div>
							<div class="othersetting">
								<div class="params titleffect customitemstyle">
                                    <label class="customlevel" for="qcslide-effect-slideffect"><?php _e('Title Effect', 'qcslide'); ?>:</label>
									<select class="myElements" name="params[titleffect]">
										<option value="">Normal</option>
										<option value="bounceInLeft" <?php echo ($params->titleffect=='bounceInLeft'?'selected="selected"':''); ?>>bounceInLeft</option>
										
										<option value="bounceInRight" <?php echo ($params->titleffect=='bounceInRight'?'selected="selected"':''); ?>>bounceInRight</option>
										<option value="rotateInDownLeft" <?php echo ($params->titleffect=='rotateInDownLeft'?'selected="selected"':''); ?>>rotateInDownLeft</option>
										<option value="rotateInDownRight" <?php echo ($params->titleffect=='rotateInDownRight'?'selected="selected"':''); ?>>rotateInDownRight</option>
										
										<option value="fadeInLeft" <?php echo ($params->titleffect=='fadeInLeft'?'selected="selected"':''); ?>>fadeInLeft</option>
										<option value="fadeInRight" <?php echo ($params->titleffect=='fadeInRight'?'selected="selected"':''); ?>>fadeInRight</option>
										<option value="slideInLeft" <?php echo ($params->titleffect=='slideInLeft'?'selected="selected"':''); ?>>slideInLeft</option>
										<option value="slideInRight" <?php echo ($params->titleffect=='slideInRight'?'selected="selected"':''); ?>>slideInRight</option>
										<option value="zoomInLeft" <?php echo ($params->titleffect=='zoomInLeft'?'selected="selected"':''); ?>>zoomInLeft</option>
										<option value="zoomInRight" <?php echo ($params->titleffect=='zoomInRight'?'selected="selected"':''); ?>>zoomInRight</option>
										<option value="zoomInUp" <?php echo ($params->titleffect=='zoomInUp'?'selected="selected"':''); ?>>zoomInUp</option>
										<option value="zoomInDown" <?php echo ($params->titleffect=='zoomInDown'?'selected="selected"':''); ?>>zoomInDown</option>
										<option value="flipInX" <?php echo ($params->titleffect=='flipInX'?'selected="selected"':''); ?>>flipInX</option>
										<option value="flipInY" <?php echo ($params->titleffect=='flipInY'?'selected="selected"':''); ?>>flipInY</option>
										<option value="swing" <?php echo ($params->titleffect=='swing'?'selected="selected"':''); ?>>swing</option>
										<option value="rubberBand" <?php echo ($params->titleffect=='rubberBand'?'selected="selected"':''); ?>>rubberBand</option>
										<option value="flash" <?php echo ($params->titleffect=='flash'?'selected="selected"':''); ?>>flash</option>
										<option value="wobble" <?php echo ($params->titleffect=='wobble'?'selected="selected"':''); ?>>wobble</option>
										<option value="rollIn" <?php echo ($params->titleffect=='rollIn'?'selected="selected"':''); ?>>rollIn</option>
										
									</select>
                                    
                                </div>
                                <div class="params deseffect customitemstyle">
                                    <label class="customlevel" for="qcslide-effect-slideffect"><?php _e('Description Effect', 'qcslide'); ?>:</label>
									<select class="myElements" name="params[deseffect]">
										<option value="">Normal</option>
										<option value="bounceInLeft" <?php echo ($params->deseffect=='bounceInLeft'?'selected="selected"':''); ?>>bounceInLeft</option>
										
										<option value="bounceInRight" <?php echo ($params->deseffect=='bounceInRight'?'selected="selected"':''); ?>>bounceInRight</option>
										<option value="rotateInDownLeft" <?php echo ($params->deseffect=='rotateInDownLeft'?'selected="selected"':''); ?>>rotateInDownLeft</option>
										<option value="rotateInDownRight" <?php echo ($params->deseffect=='rotateInDownRight'?'selected="selected"':''); ?>>rotateInDownRight</option>
										
										<option value="fadeInLeft" <?php echo ($params->deseffect=='fadeInLeft'?'selected="selected"':''); ?>>fadeInLeft</option>
										<option value="fadeInRight" <?php echo ($params->deseffect=='fadeInRight'?'selected="selected"':''); ?>>fadeInRight</option>
										<option value="slideInLeft" <?php echo ($params->deseffect=='slideInLeft'?'selected="selected"':''); ?>>slideInLeft</option>
										<option value="slideInRight" <?php echo ($params->deseffect=='slideInRight'?'selected="selected"':''); ?>>slideInRight</option>
										<option value="zoomInLeft" <?php echo ($params->deseffect=='zoomInLeft'?'selected="selected"':''); ?>>zoomInLeft</option>
										<option value="zoomInRight" <?php echo ($params->deseffect=='zoomInRight'?'selected="selected"':''); ?>>zoomInRight</option>
										<option value="zoomInUp" <?php echo ($params->deseffect=='zoomInUp'?'selected="selected"':''); ?>>zoomInUp</option>
										<option value="zoomInDown" <?php echo ($params->deseffect=='zoomInDown'?'selected="selected"':''); ?>>zoomInDown</option>
										<option value="flipInX" <?php echo ($params->deseffect=='flipInX'?'selected="selected"':''); ?>>flipInX</option>
										<option value="flipInY" <?php echo ($params->deseffect=='flipInY'?'selected="selected"':''); ?>>flipInY</option>
										<option value="swing" <?php echo ($params->deseffect=='swing'?'selected="selected"':''); ?>>swing</option>
										<option value="rubberBand" <?php echo ($params->deseffect=='rubberBand'?'selected="selected"':''); ?>>rubberBand</option>
										<option value="flash" <?php echo ($params->deseffect=='flash'?'selected="selected"':''); ?>>flash</option>
										<option value="wobble" <?php echo ($params->deseffect=='wobble'?'selected="selected"':''); ?>>wobble</option>
										<option value="rollIn" <?php echo ($params->deseffect=='rollIn'?'selected="selected"':''); ?>>rollIn</option>
										
									</select>
                                    
                                </div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-background-color">Background Color</label> <input type="text" name="params[background]" class="color-field" value="<?php echo (isset($params->background)?esc_attr($params->background):''); ?>" />
								</div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-caption-text-color">Title Color</label> <input type="text" name="params[titlecolor]" class="color-field myElements" value="<?php echo (isset($params->titlecolor)?esc_attr($params->titlecolor):''); ?>" />
								</div>
									
							</div>
							<div style="clear:both"></div>
							<div class="othersetting" style="display: inline-block; float: left; width: 25%;">
								
							
									<label class="customlevel" for="qchero-caption-text-color">Desctiption Color</label> <input type="text" name="params[descriptioncolor]" class="color-field myElements" value="<?php echo esc_attr($params->descriptioncolor); ?>" />
								

							</div>
							<div class="othersetting" style="display: inline-block; float: left; width: 25%;">
								<div class="params customitemstyle" style="width:100%;">
									
									<label class="customlevel" for="bg_image_url">Background Image</label>
									<input type="hidden" name="cs[bg_image_url]" id="bg_image_url" class="regular-text" value="<?php echo esc_attr($_slider[0]->bg_image_url); ?>">
									<input type="button" name="upload-btn" id="bg-upload-btn" class="button-secondary" value="Upload Image">
								</div>
								<div style="clear:both"></div>
								<div id="bg_preview_img">
								
								<?php 
									if($_slider[0]->bg_image_url != '') :
								?>
									<span class="remove_bg_image">X</span>
									<img src="<?php echo esc_attr($_slider[0]->bg_image_url); ?>" alt="" />
								<?php endif; ?>
								</div>
							

							</div>
							<div class="othersetting" style="display: inline-block; float: left; margin-right: 22px;width: 33%;">
									<div class="params customitemstyle" style="width:100%;">
									
									<label class="customlevel" for="bg_image_url">Background Gradient</label>
									<input type="hidden" name="cs[bg_gradient]" id="bg_gradient" class="regular-text" value='<?php echo str_replace('"','',preg_replace('/\\\\/', '', $_slider[0]->bg_gradient)); ?>' />
									<input type="button" name="upload-btn" id="bg_gradient_select" class="button-secondary" value="Select Gradient">

								</div>
								<?php
									if(isset($_slider[0]->bg_gradient) and strlen($_slider[0]->bg_gradient)>5){
								?>
									<div style="clear:both"></div>
									<div id="gradient_view" style="display:inline-block;<?php echo str_replace('"','',preg_replace('/\\\\/', '', $_slider[0]->bg_gradient)); ?>">
										<span class="remove_gradient">x</span>
									</div>
								<?php 
									}else{
								?>	
									<div style="clear:both"></div>
									<div id="gradient_view">
										<span class="remove_gradient">x</span>
									</div>
								<?php
									}
								?>

							</div>						
						</li>
						<li class="Effect-setting">
							<div class="othersetting" style="position:relative">
								<div style=" height: 100%;  width: 100%; position: absolute;opacity: 0.7;z-index: 999;background: #ddd;">
									<p style="opacity: 1; color: red; font-size: 25px; text-align: center;">Coming Soon</p>
								</div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-background-color">Particle Type</label> <select name="params[particle_type]">
											<option value="circle" <?php echo (isset($params->particle_type) &&$params->particle_type=='circle'?'selected="selected"':''); ?>>Circle</option>
											<option value="edge" <?php echo (isset($params->particle_type) && $params->particle_type=='edge'?'selected="selected"':''); ?>>Edge</option>
											<option value="triangle" <?php echo (isset($params->particle_type) && $params->particle_type=='triangle'?'selected="selected"':''); ?>>Triangle</option>
											<option value="polygon" <?php echo (isset($params->particle_type)&&$params->particle_type=='polygon'?'selected="selected"':''); ?>>Polygon</option>
											<option value="star" <?php echo (isset($params->particle_type)&&$params->particle_type=='star'?'selected="selected"':''); ?>>Star</option>
											<option value="image" <?php echo (isset($params->particle_type)&&$params->particle_type=='image'?'selected="selected"':''); ?>>Image</option>
									</select>
								</div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-caption-text-color">Interactivity</label> <select name="params[interactivity]">
											<option value="">None</option>
											<option value="grab" <?php echo (isset($params->interactivity)&&$params->interactivity=='grab'?'selected="selected"':''); ?>>Grab</option>
											<option value="repulse" <?php echo (isset($params->interactivity)&&$params->interactivity=='repulse'?'selected="selected"':''); ?>>Repulse</option>
									</select>
								</div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-caption-text-color">Particle Color</label> <input type="text" name="params[particle_color]" class="color-field myElements" value="<?php echo (isset($params->particle_color)?esc_attr($params->particle_color):''); ?>" />
								</div>
								<div class="params customitemstyle">
									<label class="customlevel" for="qchero-caption-text-color">Line Linked Color</label> <input type="text" name="params[linelink_color]" class="color-field myElements" value="<?php echo (isset($params->linelink_color)?esc_attr($params->linelink_color):''); ?>" />
								</div>		
							</div>						
						</li>
						<li class="arrows">
							<div class="othersetting" style="position:relative;height: 64px;">
								<div style=" height: 100%;  width: 100%; position: absolute;opacity: 0.7;z-index: 999;background: #ddd;">
									<p style="opacity: 1; color: red; font-size: 25px; text-align: center;">Coming Soon</p>
								</div>
	
							</div>						
						</li>
                        <li class="shortcodes">
							<div class="shortcodes-contents">
								<div style="margin-bottom: 12px;">
									Copy & paste the shortcode directly into any WordPress post or page.
									<p style="font-size: 18px;line-height: 34px;color: #000;">[qcld_hero id=<?php echo intval($_slider[0]->id); ?>]</p>
								</div>
								<span>OR</span>
								<div>
									Copy & paste this code into a template file to include the slideshow within your
                                    theme.
                                    <p style="font-size: 18px;line-height: 34px;color: #000;">&lt;?php echo do_shortcode("[qcld_hero id=<?php echo intval($_slider[0]->id); ?>]"); ?&gt;</p>
								</div>
							</div>
						</li>
                    </ul>
                </div>
            </div>
        
        <div id="qchero_slide_edit" style="display:none;">
            <input class="title" name="title" value=""/>
            <input class="description" name="description" value=""/>
            <div class="content">
                <span id="logo">Logo</span>
                <div class="contents">

                </div>
            </div>
        </div>
        <div id="qchero_slider_preview_popup">

        </div>
        <div id="qchero_slider_preview">
            <div class="qchero_close" style="position:fixed;top: 12%;right: 6%;"><i class="fa fa-remove"
                                                                                     aria-hidden="true"></i></div>
        </div>
        <!--SLIDER-->
        <style>

            /*** title ***/
            .qchero_bullets {
                position: absolute;

            }

            .qchero_bullets div, .qchero_bullets div:hover, .qchero_bullets .av {
                position: absolute;
                /* size of bullet elment */
                width: 12px;
                height: 12px;
                border-radius: 10px;
                filter: alpha(opacity=70);
                opacity: .7;
                overflow: hidden;
                cursor: pointer;
                border: #4B4B4B 1px solid;
            }



            .qchero_bullets .bulletav {
                background-color: #74B8CF !important;
                border: #fff 1px solid;
            }

            .qchero_bullets .dn, .qchero_bullets .dn:hover {
                background-color: #555555;
            }



            /*** title ***/
            .qcherotitle {
                box-sizing: border-box;
                padding: 1%;
                overflow: hidden;
            }

            .qcherotitle h3 {
                margin: 0;
                padding: 0;
                word-wrap: break-word;
                width: 100%;
                text-align: center;
                font-size: inherit !important;
            }


        </style>
    </div>
    <div id="qchero_slider_title_styling" class="qchero-styling main-content">
        <div class="qchero_close"><i class="fa fa-remove" aria-hidden="true"></i></div>
        <span class="popup-type" data="off"><img
                src="<?php echo QCLD_sliderhero_IMAGES . "/light_1.png"; ?>"></span>
        <form id="qchero-title-styling" class="params">
            <input type="hidden" class="width" name="params[title][style][width]" rel="px"
                   value="<?php echo esc_attr($params->title->style->width); ?>">
            <input type="hidden" class="height" name="params[title][style][height]" rel="px"
                   value="<?php echo esc_attr($params->title->style->height); ?>">
            <input type="hidden" class="top" name="params[title][style][top]" rel="0"
                   value="<?php echo esc_attr($params->title->style->top); ?>">
            <input type="hidden" class="left" name="params[title][style][left]" rel="0"
                   value="<?php echo esc_attr($params->title->style->left); ?>">
            
        </form>
        <div class="qchero_content">
            <div class="qchero_title">
                <div class="qchero_title_child"></div>
                <span class="title">Title</span>
            </div>
        </div>
    </div>
	
    <div id="qchero_slider_button1_styling" class="qchero-styling main-content">
        <div class="qchero_close"><i class="fa fa-remove" aria-hidden="true"></i></div>
        <span class="popup-type" data="off"><img
                src="<?php echo QCLD_sliderhero_IMAGES . "/light_1.png"; ?>"></span>
        <form id="qchero-button1-styling" class="params">
            <input type="hidden" class="width" name="params[button1][style][width]" rel="px"
                   value="<?php echo esc_attr($params->button1->style->width); ?>">
            <input type="hidden" class="height" name="params[button1][style][height]" rel="px"
                   value="<?php echo esc_attr($params->button1->style->height); ?>">
            <input type="hidden" class="top" name="params[button1][style][top]" rel="0"
                   value="<?php echo esc_attr($params->button1->style->top); ?>">
            <input type="hidden" class="left" name="params[button1][style][left]" rel="0"
                   value="<?php echo esc_attr($params->button1->style->left); ?>">
            
        </form>
        <div class="qchero_content">
            <div class="qchero_button1">
                <div class="qchero_button1_child"></div>
                <span class="title">button1</span>
            </div>
        </div>
    </div>
	
    <div id="qchero_slider_description_styling" class="qchero-styling main-content">
        <div class="qchero_close"><i class="fa fa-remove" aria-hidden="true"></i></div>
        <span class="popup-type" data="off"><img
                src="<?php echo QCLD_sliderhero_IMAGES . "/light_1.png"; ?>"></span>
        <form id="qchero-description-styling" class="params">
            <input type="hidden" class="width" name="params[description][style][width]" rel="px"
                   value="<?php echo esc_attr($params->description->style->width); ?>">
            <input type="hidden" class="height" name="params[description][style][height]" rel="px"
                   value="<?php echo esc_attr($params->description->style->height); ?>">
            <input type="hidden" class="top" name="params[description][style][top]" rel="0"
                   value="<?php echo esc_attr($params->description->style->top); ?>">
            <input type="hidden" class="left" name="params[description][style][left]" rel="0"
                   value="<?php echo esc_attr($params->description->style->left); ?>">
            
        </form>
        <div class="qchero_content">
            <div class="qchero_description">
                <div class="qchero_description_child"></div>
                <span class="description">description</span>
            </div>
        </div>
    </div>
<div id="qchero_loading_overlay" style="display:none;">
	<div><img src="<?php echo QCLD_sliderhero_IMAGES . "/loading_1.gif"; ?>"/></div>
</div>	
    <style>
        #qchero_slider_preview_popup {
            display: none;
            position: fixed;
            height: 100%;
            width: 100%;
            background: #000000;
            opacity: 0.7;
            top: 0;
            left: 0;
            z-index: 9998;
        }

        #qchero_slider_preview {
            padding: 40px;
            overflow-y: scroll;
            overflow: overlay;
            display: none;
            position: fixed;
            height: 80%;
            width: 90%;
            background: #f1f1f1;
            opacity: 1;
            top: 10%;
            left: 5%;
            z-index: 10000;
            box-sizing: border-box;
        }

        .qchero-custom-styling .qchero_content .qchero_custom .qchero_img {
            box-sizing: border-box;
            border-style: solid !important;
        }

        .qchero-custom-styling .qchero_content .qchero_custom img {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .qcheroimg {
            overflow: hidden;
            box-sizing: border-box;
            box-sizing: border-box;
        }

        #qchero_slider_preview .qchero_content {
            position: absolute;
            background: #FBABAB;
            width: 100%;
            height: 100%;
        }

        #qchero-slider-construct {
            width: 214px;
            height: 500px;
            position: relative;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            overflow: hidden;
            background: rgba(223, 223, 223, 0.36);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            box-sizing: border-box;
            -moz-box-shadow: inset 0 0 1px #000000;
            -webkit-box-shadow: inset 0 0 1px #000000;
            box-shadow: inset 0 0 1px #000000;

        }

        .qchero_construct {
            max-width: <?php echo absint($style->width);?>px;
            max-height: <?php echo absint($style->height);?>px;
            position: absolute;
            width: 100px;
            height: 50px;
            margin: 0;
            padding: 0;
            word-wrap: break-word;
            background: green;
            display: inline-block;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            cursor: move;
        }

        img.qchero_construct {
            width: 100px;
            height: auto;
        }

        #qchero-title-construct {
            position: absolute;
            min-width: 50px;
            width: <?php echo absint($params->title->style->width);?>px;
            height: <?php echo absint($params->title->style->height);?>px;
            background: transparent;
            cursor: move;
            top: <?php echo esc_attr($params->title->style->top);?>;
            left: <?php echo esc_attr($params->title->style->left);?>;
            opacity: 0.9;
            color: rgb(86, 88, 85);
            filter: alpha(opacity=<?php echo abs($params->title->style->opacity);?>);
            border: 2px dashed #898989;
            word-wrap: break-word;
            overflow: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            box-sizing: border-box;
        }
        #qchero-button1-construct {
            position: absolute;
            min-width: 50px;
            width: <?php echo absint($params->button1->style->width);?>px;
            height: <?php echo absint($params->button1->style->height);?>px;
            background: transparent;
            cursor: move;
            top: <?php echo esc_attr($params->button1->style->top);?>;
            left: <?php echo esc_attr($params->button1->style->left);?>;
            opacity: 0.9;
            color: rgb(86, 88, 85);
            filter: alpha(opacity=<?php echo abs($params->title->style->opacity);?>);
            border: 2px dashed #898989;
            word-wrap: break-word;
            overflow: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            box-sizing: border-box;
        }

        #qchero-description-construct {
            position: absolute;
            min-width: 50px;
            width: <?php echo absint($params->description->style->width);?>px;
            height: <?php echo absint($params->description->style->height);?>px;
            background: <?php echo ("#".$params->description->style->background->color);?>;
            background: transparent;

            cursor: move;
            top: <?php echo esc_attr($params->description->style->top);?>;
            left: <?php echo esc_attr($params->description->style->left);?>;
            opacity: 0.9;
            color: rgb(86, 88, 85);
            border: 2px dashed #898989;
            filter: alpha(opacity=<?php echo abs($params->description->style->opacity);?>);
            word-wrap: break-word;
            overflow: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            box-sizing: border-box;
        }

        #qchero-custom-construct {
            position: absolute;
            min-width: 50px;
            cursor: move;
            word-wrap: break-word;
            overflow: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }


        #qchero-description-construct #qchero_remove {
            opacity: 0;
        }
    </style>
</div>
    <?php
}
