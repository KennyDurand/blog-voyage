<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Oria
 */
?>

		</div>
	</div><!-- #content -->

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

	<!-- <footer id="colophon" class="site-footer" role="contentinfo">

	</footer> -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
