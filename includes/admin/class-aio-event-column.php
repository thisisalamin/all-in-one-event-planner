<?php

namespace AIO_Event_Planner\Includes\Admin;

/**
 * Class AIO_Event_Column
 * Description of the class.
 */
class AIO_Event_Column {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_filter( 'manage_event_posts_columns', array( $this, 'aio_event_columns' ) );
		add_action( 'manage_event_posts_custom_column', array( $this, 'aio_event_columns_data' ), 10, 2 );
	}

	/**
	 * Add custom columns to the event post type.
	 *
	 * @param array $columns The existing columns.
	 * @return array The modified columns.
	 */
	public function aio_event_columns( $columns ) {
		$columns['event_date']     = 'Event Date';
		$columns['event_time']     = 'Event Time';
		$columns['event-category'] = 'Event Category';
		return $columns;
	}

	/**
	 * Display data for custom columns in the event post type.
	 *
	 * @param string $column The column name.
	 * @param int    $post_id The post ID.
	 */
	public function aio_event_columns_data( $column, $post_id ) {
		switch ( $column ) {
			case 'event_date':
				$event_date = get_post_meta( $post_id, '_aio_event_date', true );
				$event_date = gmdate( 'F j, Y', strtotime( $event_date ) );
				echo esc_html( $event_date );
				break;
			case 'event_time':
				$event_time = get_post_meta( $post_id, '_aio_event_time', true );
				$event_time = gmdate( 'h:i a', strtotime( $event_time ) );
				echo esc_html( $event_time );
				break;
			case 'event-category':
				$terms = get_the_terms( $post_id, 'event-category' );
				if ( ! empty( $terms ) ) {
					$output = array();
					foreach ( $terms as $term ) {
						$output[] = $term->name;
					}
					echo esc_html( implode( ', ', $output ) );
				} else {
					echo 'No category';
				}
				break;
		}
	}
}
