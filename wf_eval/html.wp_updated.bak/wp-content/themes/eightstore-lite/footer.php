<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package 8Store Lite
 */

?>

</div><!-- #content -->
<div class="clear"></div>
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
	//Top Footer Widget
	if(is_active_sidebar('footer-1')){
		?>
		<section id="section-footer" class="clear">
			<div class="store-wrapper">
				<?php dynamic_sidebar('footer-1'); ?>
			</div>
		</section>
		<?php
	}
	//Footer Widget
	if(is_active_sidebar('footer-2')){
		?>
		<section id="section-footer2" class="clear">
			<div class="store-wrapper">
				<?php dynamic_sidebar('footer-2'); ?>
			</div>
		</section>
		<?php
	}
	?>
	<div class="store-footer">
		<div class="store-wrapper">
			<div class="footer-copyrt">
				<div class="site-info">
					<?php
					if(get_theme_mod('footer_copyright_text') && get_theme_mod('footer_copyright_text')!=""){
						echo wp_kses_post(get_theme_mod('footer_copyright_text'));
					} else {
						?>
						<a href="<?php echo 'http://wordpress.org/'; ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'eightstore-lite' ), 'WordPress' ); ?></a>
						<span class="sep"> | </span>
						<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'eightstore-lite' ), '8store Lite', '<a href="http://8degreethemes.com" rel="designer">8DegreeThemes</a>' );
					}
					?>
				</div><!-- .site-info -->

				<!-- Social Icons -->
				<?php if(get_theme_mod('social_icons_in_footer') && get_theme_mod('social_icons_in_footer')!='0'){ ?>
				<div class="es-social-footer">
					<?php do_action('eightstore_lite_social_links'); ?>
				</div>
				<?php } ?>

				<!-- Payment Partner Logos -->
				<?php do_action('eightstore_lite_payment_partner_logos');?>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->
<div id="es-top"></div>
<?php wp_footer(); ?>

</body>
</html>
