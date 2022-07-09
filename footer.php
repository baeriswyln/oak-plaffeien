			</div><!-- close #qodef-page-inner div from header.php -->
		</div><!-- close #qodef-page-outer div from header.php -->
		<?php
		// Hook to include page footer template
		do_action( 'pelicula_action_page_footer_template' );

		// Hook to include additional content before wrapper close tag
		do_action( 'pelicula_action_before_wrapper_close_tag' );
		?>

        <footer>
            <div class="footer-inner">
                <h1>Programm</h1>
            <?php
            echo do_shortcode('[movies_footer]');
            ?>
            </div>
        </footer>
	</div><!-- close #qodef-page-wrapper div from header.php -->
	<?php
	// Hook to include additional content before body tag closed
	do_action( 'pelicula_action_before_body_tag_close' );
	?>
<?php wp_footer(); ?>
</body>
</html>