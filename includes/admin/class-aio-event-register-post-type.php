<?php
namespace AIO_Event_Planner\Includes\Admin;

/**
 * Class AIO_Register_Post_Type
 *
 * Description of the class.
 */
class AIO_Register_Post_Type {
	/**
	 * Register the event post type.
	 */
	public function aio_event_register_post_type() {
		$labels = array(
			'name'               => _x( 'Events', 'post type general name', 'aio-event-planner' ),
			'singular_name'      => _x( 'Event', 'post type singular name', 'aio-event-planner' ),
			'menu_name'          => _x( 'AIO Events', 'admin menu', 'aio-event-planner' ),
			'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'aio-event-planner' ),
			'add_new'            => _x( 'Add New Event', 'event', 'aio-event-planner' ),
			'add_new_item'       => __( 'Add New Event', 'aio-event-planner' ),
			'new_item'           => __( 'New Event', 'aio-event-planner' ),
			'edit_item'          => __( 'Edit Event', 'aio-event-planner' ),
			'view_item'          => __( 'View Event', 'aio-event-planner' ),
			'all_items'          => __( 'All Events', 'aio-event-planner' ),
			'search_items'       => __( 'Search Events', 'aio-event-planner' ),
			'parent_item_colon'  => __( 'Parent Events:', 'aio-event-planner' ),
			'not_found'          => __( 'No events found.', 'aio-event-planner' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'aio-event-planner' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'event' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
			'show_in_rest'       => true,
			'menu_icon'          => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IS0tIFVwbG9hZGVkIHRvOiBTVkcgUmVwbywgd3d3LnN2Z3JlcG8uY29tLCBHZW5lcmF0b3I6IFNWRyBSZXBvIE1peGVyIFRvb2xzIC0tPg0KPHN2ZyB3aWR0aD0iODAwcHgiIGhlaWdodD0iODAwcHgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4NCjxwYXRoIGQ9Ik02Ljk2MDA2IDJDNy4zNzc1OCAyIDcuNzE2MDUgMi4zMDk5NiA3LjcxNjA1IDIuNjkyMzFWNC4wODg4M0M4LjM4NjYzIDQuMDc2OTIgOS4xMzgyOSA0LjA3NjkyIDkuOTg0MDIgNC4wNzY5MkgxNC4wMTZDMTQuODYxNyA0LjA3NjkyIDE1LjYxMzQgNC4wNzY5MiAxNi4yODQgNC4wODg4M1YyLjY5MjMxQzE2LjI4NCAyLjMwOTk2IDE2LjYyMjQgMiAxNy4wMzk5IDJDMTcuNDU3NSAyIDE3Ljc5NTkgMi4zMDk5NiAxNy43OTU5IDIuNjkyMzFWNC4xNTAwOEMxOS4yNDY4IDQuMjU2NDcgMjAuMTk5MiA0LjUxNzU4IDIwLjg5OSA1LjE1ODM4QzIxLjU5ODcgNS43OTkxNyAyMS44ODM4IDYuNjcxMzkgMjIgOFY5SDJWOEMyLjExNjE4IDYuNjcxMzkgMi40MDEzIDUuNzk5MTcgMy4xMDEwNCA1LjE1ODM4QzMuODAwNzkgNC41MTc1OCA0Ljc1MzIzIDQuMjU2NDcgNi4yMDQwNiA0LjE1MDA4VjIuNjkyMzFDNi4yMDQwNiAyLjMwOTk2IDYuNTQyNTMgMiA2Ljk2MDA2IDJaIiBmaWxsPSIjMUMyNzRDIi8+DQo8cGF0aCBvcGFjaXR5PSIwLjUiIGQ9Ik0yMiAxNFYxMkMyMiAxMS4xNjEgMjEuOTg3MyA5LjY2NTI3IDIxLjk3NDQgOUgyLjAwNTg2QzEuOTkyOTYgOS42NjUyNyAyLjAwNTY0IDExLjE2MSAyLjAwNTY0IDEyVjE0QzIuMDA1NjQgMTcuNzcxMiAyLjAwNTY0IDE5LjY1NjkgMy4xNzY4OCAyMC44Mjg0QzQuMzQ4MTMgMjIgNi4yMzMyMSAyMiAxMC4wMDM0IDIySDE0LjAwMjNDMTcuNzcyNCAyMiAxOS42NTc1IDIyIDIwLjgyODggMjAuODI4NEMyMiAxOS42NTY5IDIyIDE3Ljc3MTIgMjIgMTRaIiBmaWxsPSIjMUMyNzRDIi8+DQo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTE0IDEyLjI1QzEzLjAzMzUgMTIuMjUgMTIuMjUgMTMuMDMzNSAxMi4yNSAxNFYxNkMxMi4yNSAxNi45NjY1IDEzLjAzMzUgMTcuNzUgMTQgMTcuNzVDMTQuOTY2NSAxNy43NSAxNS43NSAxNi45NjY1IDE1Ljc1IDE2VjE0QzE1Ljc1IDEzLjAzMzUgMTQuOTY2NSAxMi4yNSAxNCAxMi4yNVpNMTQgMTMuNzVDMTMuODYxOSAxMy43NSAxMy43NSAxMy44NjIgMTMuNzUgMTRWMTZDMTMuNzUgMTYuMTM4MSAxMy44NjE5IDE2LjI1IDE0IDE2LjI1QzE0LjEzODEgMTYuMjUgMTQuMjUgMTYuMTM4MSAxNC4yNSAxNlYxNEMxNC4yNSAxMy44NjIgMTQuMTM4MSAxMy43NSAxNCAxMy43NVoiIGZpbGw9IiMxQzI3NEMiLz4NCjxwYXRoIGQ9Ik0xMS4yNSAxM0MxMS4yNSAxMi42OTY3IDExLjA2NzMgMTIuNDIzMiAxMC43ODcgMTIuMzA3MUMxMC41MDY4IDEyLjE5MSAxMC4xODQyIDEyLjI1NTIgOS45Njk2NyAxMi40Njk3TDguNDY5NjcgMTMuOTY5N0M4LjE3Njc4IDE0LjI2MjYgOC4xNzY3OCAxNC43Mzc1IDguNDY5NjcgMTUuMDMwNEM4Ljc2MjU2IDE1LjMyMzIgOS4yMzc0NCAxNS4zMjMyIDkuNTMwMzMgMTUuMDMwNEw5Ljc1IDE0LjgxMDdWMTdDOS43NSAxNy40MTQyIDEwLjA4NTggMTcuNzUgMTAuNSAxNy43NUMxMC45MTQyIDE3Ljc1IDExLjI1IDE3LjQxNDIgMTEuMjUgMTdWMTNaIiBmaWxsPSIjMUMyNzRDIi8+DQo8L3N2Zz4=',
		);

		register_post_type( 'event', $args );
	}

	/**
	 * Register the event category taxonomy.
	 */
	public function aio_event_register_taxonomy() {
		$labels = array(
			'name'                       => 'Event Categories',
			'singular_name'              => 'Event Category',
			'menu_name'                  => 'Event Category',
			'all_items'                  => 'All Event Categories',
			'edit_item'                  => 'Edit Event Category',
			'view_item'                  => 'View Event Category',
			'update_item'                => 'Update Event Category',
			'add_new_item'               => 'Add New Event Category',
			'new_item_name'              => 'New Event Category Name',
			'search_items'               => 'Search Event Category',
			'popular_items'              => 'Popular Event Category',
			'separate_items_with_commas' => 'Separate event categories with commas',
			'add_or_remove_items'        => 'Add or remove event categories',
			'choose_from_most_used'      => 'Choose from the most used event categories',
			'not_found'                  => 'No event categories found',
			'no_terms'                   => 'No event categories',
			'items_list_navigation'      => 'Event Category list navigation',
			'items_list'                 => 'Event Category list',
			'back_to_items'              => '← Go to event categories',
			'item_link'                  => 'Event Category Link',
			'item_link_description'      => 'A link to an event category',
		);

		$args = array(
			'labels'       => $labels,
			'public'       => true,
			'hierarchical' => true,
			'show_in_menu' => true,
			'show_in_rest' => true,

		);

		register_taxonomy( 'event-category', 'event', $args );
	}
}
