<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
			<footer id="site-footer" role="contentinfo" class="header-footer-group">

				<div class="section-inner">
<!--                    Added by meteor 12/12/2020-->
                    <div id="footer-info-wrapper">
                        <div id="footer-info-inner">
                            <div id="footer-logo" class="wp-block-columns">
                                <div class="wp-block-column" style="flex-basis: 30%"><img id="footer-logo-img" src="http://localhost/wordpress/wp-content/uploads/2020/12/id-1-1.png"></div>
                                <div class="wp-block-column ml-none" style="flex-basis: 70%">
                                    <span id="footer-company-category">株式会社</span>&nbsp;
                                    <span id="footer-company-name">荻田建築事務所</span>
                                </div>
                            </div>
                            <div class="wp-block-columns align-vhcenter">
                                <div class="wp-block-column" style="flex-basis: 25%">
                                    <div class="footer-contact-info">
                                        <img src="http://localhost/wordpress/wp-content/uploads/2020/12/sharp-marker.png">
                                        <span id="footer-office1-addr">巽事務所</span>
                                    </div>
                                </div>
                                <hr width="1" size="50" class="addr-seperator">
                                <div class="wp-block-column ml-none" style="flex-basis: 75%">
                                    <p class="footer-office-addr pl-sm">
                                        〒544-0014  大阪市生野区巽東1-1-32<br>TEL.06-6758-1100/FAX.06-6758-5429
                                    </p>
                                </div>
                            </div>
                            <div class="wp-block-columns align-vhcenter">
                                <div class="wp-block-column" style="flex-basis: 25%">
                                    <div class="footer-contact-info">
                                        <img src="http://localhost/wordpress/wp-content/uploads/2020/12/sharp-marker.png">
                                        <span id="footer-office2-addr">谷町事務所</span>
                                    </div>
                                </div>
                                <hr width="1" size="50" class="addr-seperator">
                                <div class="wp-block-column ml-none" style="flex-basis: 75%">
                                    <p class="footer-office-addr pl-sm">
                                        〒544-0014  大阪市中央区安弩堂時町1-2-17 i-box-3F<br>TEL.06-6777-7874/FAX.06-6777-7875
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="footer-credits">

						<p class="footer-copyright">
							<?/*php
							echo date_i18n(
								// translators: Copyright date format, see https://www.php.net/date
								_x( 'Y', 'copyright date format', 'twentytwenty' )
							);*/
							?>
                            Copyright(C)O-ken-design All rights reserved.
						</p><!-- .footer-copyright -->

					</div><!-- .footer-credits -->

					<a class="to-the-top" href="#site-header">
						<span class="to-the-top-long">
							<?php
							/* translators: %s: HTML character for up arrow. */
							printf( __( 'To the top %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-long -->
						<span class="to-the-top-short">
							<?php
							/* translators: %s: HTML character for up arrow. */
							printf( __( 'Up %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-short -->
					</a><!-- .to-the-top -->

				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
