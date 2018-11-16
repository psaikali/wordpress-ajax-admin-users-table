<nav class="roles-filter">
	<h2 class='screen-reader-text'>
		<?php esc_html_e( 'Active filter on users list table', 'utec' ); ?>
	</h2>

	<ul class="subsubsub">
	<?php foreach ( $roles as $role ) { ?>
		<li class="<?php echo esc_attr( $role['slug'] ); ?>">
			<a href="<?php echo esc_url( $role['filter_url'] ); ?>" class="<?php echo ( $role['active'] ) ? 'current' : ''; ?>">
				<?php printf( '%1$s <span class="count">(%2$d)</span>', esc_html( $role['name'] ), esc_html( $role['count'] ) ); ?>
			</a>
		</li>
	<?php } ?>
	</ul>
</nav>