<?php
/**
 * This is the main admin page layout in charge of displaying the users table.
 * It displays a list of users in a table.
 */
?>

<div class="wrap">
	<h1><?php echo esc_attr( $page_title ); ?></h1>
	
	<hr class="wp-header-end" />

	<noscript>
		<div class="before-table">
			<?php UTEC\Utils::get_template( 'partials/roles-filter.php', [ 'roles' => $roles ] ); ?>
			<?php UTEC\Utils::get_template( 'partials/pagination.php', [ 'pagination' => $pagination ] ); ?>
		</div>

		<table class="wp-list-table widefat fixed striped users">
			<?php UTEC\Utils::get_template( 'partials/table-headers.php', [ 'admin_url' => $admin_url, 'request' => $request ] ); ?>

			<tbody id="the-list" data-wp-lists='list:user'>
				<?php if ( ! empty( $users ) ) { ?>
					<?php foreach ( $users as $user ) { ?>
					<tr id='user-<?php echo (int) $user->ID; ?>'>
						<td class='username column-username has-row-actions column-primary' data-colname="Username">
							<a href="<?php echo esc_url( $user->edit_link ); ?>">
								<img src="<?php echo esc_url( $user->avatar ); ?>" alt="<?php echo esc_attr( printf( __( 'Avatar profile picture of %1$s', 'utec' ), $user->user_login ) ); ?>" />
								<strong><?php echo esc_html( $user->user_login ); ?></strong>
							</a>
						</td>
						<td class='name column-name' data-colname="Name">
							<?php echo ! is_null( $user->name ) ? esc_html( $user->name ) : sprintf( '<em>%1$s</em>', __( 'Unknown', 'name' ) ); ?>
						</td>
						<td class='email column-email' data-colname="Email">
							<?php printf( '<a href="mailto:%1$s">%1$s</a>', $user->email ); ?>
						</td>
						<td class='role column-role' data-colname="Role">
							<?php echo esc_html( implode( ', ', $user->roles ) ); ?>
						</td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="4"><?php esc_html_e( 'No users found.', 'utec' ); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="after-table">
			<?php UTEC\Utils::get_template( 'partials/pagination.php', [ 'pagination' => $pagination ] ); ?>
		</div>
	</noscript>

	<div id="utec-app"></div>
</div>