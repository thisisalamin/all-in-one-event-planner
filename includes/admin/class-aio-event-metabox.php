<?php

namespace AIO_Event_Planner\Includes\Admin;

/**
 * Class AIO_Metabox
 *
 * This class handles the event metabox functionality.
 */
class AIO_Metabox {
	/**
	 * AIO_Metabox constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'aio_add_event_metabox' ) );
		add_action( 'save_post', array( $this, 'aio_save_event_metabox' ) );
	}

	/**
	 * Add event metabox.
	 */
	public function aio_add_event_metabox() {
		add_meta_box(
			'aio-event-metabox',
			'Event Details',
			array( $this, 'aio_event_metabox_callback' ),
			'event',
			'normal',
			'default'
		);
	}

	/**
	 * Callback function for the event metabox.
	 *
	 * @param \WP_Post $post The post object.
	 */
	public function aio_event_metabox_callback( $post ) {
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'aio_event_metabox', 'aio_event_metabox_nonce' );

		// Retrieve an existing value from the database.
		$aio_event_date = get_post_meta( $post->ID, '_aio_event_date', true );
		$aio_event_time = get_post_meta( $post->ID, '_aio_event_time', true );

		// Set default values.
		if ( empty( $aio_event_date ) ) {
			$aio_event_date = '';
		}

		if ( empty( $aio_event_time ) ) {
			$aio_event_time = '';
		}

		// Form fields.
		?>
		<div class="aio-event-metabox">
			<div class="aio-event-metabox-row">
				<div class="aio-event-column">
					<div class="aio-event-metabox-date">
						<label for="aio-event-date">Date</label>
						<input type="date" id="aio-event-date" name="aio_event_date" value="<?php echo esc_attr( $aio_event_date ); ?>">
					</div>
				</div>
				<div class="aio-event-column">
					<div class="aio-event-metabox-time">
						<label for="aio-event-time">Time</label>
						<input type="time" id="aio-event-time" name="aio_event_time" value="<?php echo esc_attr( $aio_event_time ); ?>">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save event metabox.
	 *
	 * @param int $post_id The post ID.
	 */
	public function aio_save_event_metabox( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['aio_event_metabox_nonce'] ) ) {
			return $post_id;
		}

		$nonce = isset( $_POST['aio_event_metabox_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['aio_event_metabox_nonce'] ) ) : '';

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'aio_event_metabox' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'event' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Sanitize user input.
		$aio_event_date = isset( $_POST['aio_event_date'] ) ? sanitize_text_field( wp_unslash( $_POST['aio_event_date'] ) ) : '';
		$aio_event_time = isset( $_POST['aio_event_time'] ) ? sanitize_text_field( wp_unslash( $_POST['aio_event_time'] ) ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, '_aio_event_date', $aio_event_date );
		update_post_meta( $post_id, '_aio_event_time', $aio_event_time );
	}
}
