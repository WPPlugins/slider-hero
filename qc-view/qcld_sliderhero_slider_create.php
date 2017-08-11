<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


function qcld_sliderhero_sliders_type() { ?>
	
	<div class="qchero_sliders_list_wrapper">
		<div class="sliderhero_menu_title">
			<h2 style="font-size: 26px;">Slider-Hero</h2>
		</div>
		<div class="form_wrapper_sliderhero">
			<p style="color: #000;font-size: 18px;padding: 20px 0px;">Choose an Effect to Start Creating a New Slider. Choose "No Effect" if You Want a Simple Image Slider.</p>

			<div class="effect_selection_area">
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=no_effect'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/no-effect.jpg' ?>" alt="" />
					<p>No Effect</p>
				</a>
				
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=particle'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/default.jpg' ?>" alt="" />
					<p>Particle Effect</p>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=particle_snow'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/snow.jpg' ?>" alt="" />
					<p>Snow Effect</p>
				</a>

				
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=particle_nasa'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/nasa.jpg' ?>" alt="" />
					<p>NASA</p>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=particle_bubble'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/bubble.jpg' ?>" alt="" />
					<p>Bubble</p>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=nyan_cat'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/nyan_cat.jpg' ?>" alt="" />
					<p>Nyan Cat</p>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=Slider-Hero&task=addslider&type=torus'); ?>">
					<img src="<?php echo QCLD_sliderhero_IMAGES.'/torus.jpg' ?>" alt="" />
					<p>Torus of Cubes</p>
				</a>

				
			</div>			
		</div>

	</div>
	<?php
}

