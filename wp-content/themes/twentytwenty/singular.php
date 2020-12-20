<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
		}
	}

	?>

</main><!-- #site-content -->
<!--Added by meteor 12/15/2020-->
<div id="bottomlink-wrapper">
    <a href="http://o-ken-design.com">
        <div id="to-factory">
            <div><span id="en-fac-label">FACTORY</span><span id="jp-fac-label">モノづくり事業</span></div><img src="http://localhost/wordpress/wp-content/uploads/2020/12/arrow.png">
        </div>
    </a>
    <div id="genhapp-links" class="align-vhcenter">
        <a href="https://o-ken-design.co.jp/">
            <img src="http://localhost/wordpress/wp-content/uploads/2020/12/gendai.png">
        </a>
        <a href="https://happynaru.work">
            <img src="http://localhost/wordpress/wp-content/uploads/2020/12/bnr_happynaru.jpg">
        </a>
    </div>
</div>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
