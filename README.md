# WordPress AJAX admin users table

## About this plugin
This plugin is a proof of concept, a personal experiment and a technical exercise for a job application. 

Its goal is to recreate a fully-usable admin users table powered by AJAX. 
I used this exercise to practice my ReactJS knowledge with a real-world project.

### Demo
![Demo](https://mosaika.fr/wip/wp-ajax-users-table.gif)

## Features
As you can see in the demo above, the displayed table is filterable by user role, and sortable on the Username and Name (specifically Last Name) column. 
Pagination, filters and ordering requests are sent via AJAX and no page refresh is needed to browse data.

## Installation
Simply clone this repository in your `/plugins/` folder, or [download the latest ZIP](https://github.com/psaikali/wordpress-ajax-admin-users-table/archive/master.zip) and install it directly via the Plugins admin page in WordPress.

Once activated, a new "AJAX table" sub-menu will show up in your "Users" admin menu.

## Future
*PRs are more than welcome!*
Please feel free to improve this foundation and submit exciting new features. 
If I got some time, I'll be happy to extend this plugin and make it even more awesome, adding a proper search field and some other cool filters.

## Filters

A couple of filters give you the ability to change the default plugin behavior.

### utec_admin_table_capability
By default, only users with the `list_users` capability will have the permission to access the custom users table admin page and send AJAX request to its API route.

Use this filter to change this capability.
```
apply_filters( 'utec_admin_table_capability', function( $cap ) {
	return 'manage_options';
} );
```

### utec_users_amount

By default, the plugin will display the exact same number of users (per page) in the table as the amount defined by the user on the native Users admin page. 

Use this filter to force a different number of users to be displayed.

```
apply_filters( 'utec_users_amount', function( $amount ) {
	return 50;
} );
```