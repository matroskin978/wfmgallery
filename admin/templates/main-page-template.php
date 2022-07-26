<h2>Galleries List Page</h2>

<!-- Pagination -->
<div class="pagination">
	<?php
    $per_page = 5;
	$pagination_info = Wfmgallery_Admin::get_pagination_info( $per_page );
	Wfmgallery_Admin::debug( $pagination_info );

	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'    => '?paged=%#%',
		'current'   => $pagination_info['paged'],
		'total'     => $pagination_info['total_pages'],
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'mid_size'  => 5
	) );
	?>
</div>
<!-- Pagination -->

<?php Wfmgallery_Admin::debug( Wfmgallery_Admin::get_galleries( $per_page ) ); ?>
