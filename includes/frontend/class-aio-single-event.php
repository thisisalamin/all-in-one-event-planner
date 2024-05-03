<?php
/**
 * File description.
 *
 * @package AIO_Event_Planner
 */

namespace AIO_Event_Planner\Includes\Frontend;

/**
 * Class AIO_Single_Event
 *
 * Description of the class.
 */
class AIO_Single_Event {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_filter( 'the_content', array( $this, 'aio_single_event_content' ) );
	}

	/**
	 * Filter the content for a single event.
	 *
	 * @param string $content The original content.
	 * @return string The modified content.
	 */
	/**
	 * Adds event details to the content of a single event.
	 *
	 * This function is called when generating the content for a single event page.
	 * It retrieves the event date and time from the post meta and formats them.
	 * Then, it appends the event details to the existing content.
	 *
	 * @param string $content The existing content of the single event page.
	 * @return string The modified content with event details added.
	 */
	public function aio_single_event_content( $content ) {
		$event_date = '';
		$event_time = '';
		if ( is_singular( 'event' ) ) {
			$event_id   = get_the_ID();
			$event_date = get_post_meta( $event_id, '_aio_event_date', true );
			$event_date = gmdate( 'F j, Y', strtotime( $event_date ) );

			$event_time = get_post_meta( $event_id, '_aio_event_time', true );
			// Convert the time to 12 hour format.
			$event_time = gmdate( 'h:i a', strtotime( $event_time ) );
		}

		ob_start();
		?>
		<div class="aio-event-details">
			<p><strong>Event Date:</strong> <?php echo esc_html( $event_date ); ?></p>
			<p><strong>Event Time:</strong> <?php echo esc_html( $event_time ); ?></p>
		</div> 
		<?php
		$event_details = ob_get_clean();
		$content      .= $event_details;
		return $content;
	}
}

