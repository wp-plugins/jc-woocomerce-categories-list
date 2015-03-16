<?php
function jc_woocomerce_settings_page() {
	?>
	<div class="wrap">
		<form method="post" action="options.php">
			<?php settings_fields( 'jc-woocommerce-se' ); ?>
			<?php do_settings_sections( 'jc-woocommerce-se' ); ?>
			<table class="form-table">
				<?php 
				if(get_option('enable-image') !== ""){$checked1 = "checked=\"checked\""; }else{ $checked = "";}	
				if(get_option('enable-products') !== ""){$checked2 = "checked=\"checked\""; }else{ $checked = "";}	
				?>
				<tr>
					<td>
						<h2>General configuration of the plugin</h2>
					</td>
				</tr>
				<tr>
					<td>
						<label for=""><b>Show Products : </b> </label>
						<input type="checkbox" name="enable-products" id="<?php echo get_option('enable-products'); ?>" value="enable-products" <?php echo $checked2; ?> />
					</td>
				</tr>
				<?php 
				if(get_option('enable-products') !== ""){
					?>
					<tr>
						<td>
							<label for=""><b>Post per page : </b> </label>
							<input type="text" name="post-per-page" value="<?php echo esc_attr( get_option('post-per-page') ); ?>" />
						</td>
					</tr>
					<?php  
				}
				?>
								<tr>
					<td>
						<label for=""><b>Enable images : </b> </label>
						<input type="checkbox" name="enable-image" id="<?php echo get_option('enable-image'); ?>" value="enable-image" <?php echo $checked1; ?> />
					</td>
				</tr>
				<tr>
					<td>
						<h3>
							To display the list at any section should paste the following shorcode
						</h3>
						<h2>
							[categories_product]
						</h2>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<div>
			<a href="http://webdesignjc.com/recaptchawp/index.html">Mas detalles</a>
		</div>
	</div>
	<?php }