<?php
$base_url = remove_query_arg( wp_removable_query_args(), set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) );
?>

<nav class="pagination">
	<ul>
		<li class="link previous <?php if ( $pagination['current_page'] === 1 ) { echo 'disabled'; } ?>">
			<?php if ( $pagination['current_page'] > 1 ) { ?><a href="<?php echo esc_url( add_query_arg( [ 'paged' => $pagination['current_page'] - 1 ], $base_url ) ); ?>"><?php } ?>
			<?php printf(
				'%1$s %2$s',
				'<i class="dashicons dashicons-arrow-left-alt"></i>',
				__( 'Previous', 'utec' )
			); ?>
			<?php if ( $pagination['current_page'] > 1 ) { ?></a><?php } ?>
		</li>

		<li class="text">
			<span><?php printf(
				__( 'Page %1$d of %2$d', 'utec' ),
				$pagination['current_page'],
				$pagination['total_pages']
			); ?></span>
		</li>

		<li class="link next <?php if ( $pagination['current_page'] === $pagination['total_pages'] ) { echo 'disabled'; } ?>">
			<?php if ( $pagination['current_page'] < $pagination['total_pages'] ) { ?><a href="<?php echo esc_url( add_query_arg( [ 'paged' => $pagination['current_page'] + 1 ], $base_url ) ); ?>"><?php } ?>
			<?php printf(
				'%2$s %1$s',
				'<i class="dashicons dashicons-arrow-right-alt"></i>',
				__( 'Next', 'utec' )
			); ?>
			<?php if ( $pagination['current_page'] < $pagination['total_pages'] ) { ?></a><?php } ?>
		</li>
	</ul>
</nav>