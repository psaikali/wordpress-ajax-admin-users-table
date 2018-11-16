<?php
$username_classes        = $name_classes        = 'sortable desc';
$username_link_order_arg = $name_link_order_arg = 'asc';

if ( $request['orderby'] == 'user_login') {
	$username_classes = "sorted {$request['order']}";
	$username_link_order_arg = ( $request['order'] == 'ASC' ) ? 'desc' : 'asc';
} elseif ( $request['orderby'] == 'name') {
	$name_classes = "sorted {$request['order']}";
	$name_link_order_arg = ( $request['order'] == 'ASC' ) ? 'desc' : 'asc';
}
?>
<thead>
	<tr>
		<th scope="col" id='username' class='manage-column column-username column-primary <?php echo esc_attr( strtolower( $username_classes ) ); ?>'>
			<a href="<?php echo esc_url( add_query_arg( [ 'orderby' => 'user_login', 'order' => $username_link_order_arg ], $admin_url ) ); ?>" >
				<span><?php esc_attr_e( 'Username', 'utec' ); ?></span><span class="sorting-indicator"></span>
			</a>
		</th>
		<th scope="col" id='name' class='manage-column column-name <?php echo esc_attr( strtolower( $name_classes ) ); ?>'>
			<a href="<?php echo esc_url( add_query_arg( [ 'orderby' => 'name', 'order' => $name_link_order_arg ], $admin_url ) ); ?>">
				<span><?php esc_attr_e( 'Name', 'utec' ); ?></span><span class="sorting-indicator"></span>
			</a>
		</th>
		<th scope="col" id='email' class='manage-column column-email desc'>
			<?php esc_attr_e( 'E-mail address', 'utec' ); ?>
		</th>
		<th scope="col" id='role' class='manage-column column-role'>
			<?php esc_attr_e( 'Role(s)', 'utec' ); ?>
		</th>
	</tr>
</thead>