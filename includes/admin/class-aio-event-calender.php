<?php
namespace AIO_Event_Planner\Includes\Admin;

/**
 * Class AIO_Event_Calender
 * Description of the class.
 */
class AIO_Event_Calender {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'aio_event_calender_post_type' ) );
		add_action( 'admin_menu', array( $this, 'aio_event_calender_menu' ) );
	}

	/**
	 * Description of the function.
	 */
	public function aio_event_calender_menu() {

		add_submenu_page(
			'edit.php?post_type=event',
			'Event Calendar',
			'Event Calendar',
			'manage_options',
			'event-calendar',
			array( $this, 'aio_event_calender_page' )
		);
	}
	/**
	 * Description of the function.
	 */
	public function aio_event_calender_page() {

		if ( isset( $_GET['month'] ) && isset( $_GET['year'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'event-calendar' ) ) {
			$month = sanitize_text_field( wp_unslash( $_GET['month'] ) );
		} else {
			$month = gmdate( 'm' );
		}
		$year = ( isset( $_GET['year'] ) ) ? sanitize_text_field( wp_unslash( $_GET['year'] ) ) : gmdate( 'Y' );
		$days = cal_days_in_month( CAL_GREGORIAN, $month, $year );

		// Get all events for the month.
		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => -1,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => '_aio_event_date',
					'value'   => $year . '-' . $month . '-01',
					'compare' => '>=',
				),
				array(
					'key'     => '_aio_event_date',
					'value'   => $year . '-' . $month . '-' . $days,
					'compare' => '<=',
				),
			),
		);

		$events = array();
		$query  = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$event_date = get_post_meta( get_the_ID(), '_aio_event_date', true );
				$event_day  = gmdate( 'd', strtotime( $event_date ) );
				// Check if events array for this day exists.
				if ( ! isset( $events[ $event_day ] ) ) {
					$events[ $event_day ] = array();
				}
				$event_permalink        = get_permalink();
				$events[ $event_day ][] = '<a class="event-title" target="_blank" href="' . $event_permalink . '">' . get_the_title() . '</a>';
			}
			wp_reset_postdata();
		} else {
			$events = array();
		}

		// Set the query paramenter when clicked button for month and year.
		$month = ( isset( $_GET['month'] ) ) ? sanitize_text_field( wp_unslash( $_GET['month'] ) ) : gmdate( 'm' );
		$year  = ( isset( $_GET['year'] ) ) ? sanitize_text_field( wp_unslash( $_GET['year'] ) ) : gmdate( 'Y' );

		// Set the URL for the previous and next month.
		$prev_month_url = wp_nonce_url( admin_url( 'edit.php?post_type=event&page=event-calendar&month=' . gmdate( 'm', strtotime( $year . '-' . $month . '-01 -1 month' ) ) . '&year=' . gmdate( 'Y', strtotime( $year . '-' . $month . '-01 -1 month' ) ) ), 'event-calendar' );
		$next_month_url = wp_nonce_url( admin_url( 'edit.php?post_type=event&page=event-calendar&month=' . gmdate( 'm', strtotime( $year . '-' . $month . '-01 +1 month' ) ) . '&year=' . gmdate( 'Y', strtotime( $year . '-' . $month . '-01 +1 month' ) ) ), 'event-calendar' );

		?>
		<div class="wrap aio-calander-table">
			<h2>Event Calendar</h2>
			<div class="aio-event-header">
				<div class="aio-event-section">
					<div class="aio-button">
						<a href="<?php echo esc_url( $prev_month_url ); ?>">
							<span class="dashicons dashicons-arrow-left-alt2"></span>
						</a>
					</div>
					<div class="aio-button">
						<a href="<?php echo esc_url( $next_month_url ); ?>">
							<span class="dashicons dashicons-arrow-right-alt2"></span>
						</a>
					</div >
					<button class="aio-button-today">
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=event&page=event-calendar' ) ); ?>">Today</a>
					</button>
				</div>
				<div class="aio-event-section">
					<h2><?php echo esc_html( gmdate( 'F Y', mktime( 0, 0, 0, $month, 1, $year ) ) ); ?></h2>
				</div>
				<div class="aio-event-section">
					<div class="aio-button-group">
						<div class="aio-button active"><a href="#">month</a></div>
						<div class="aio-button"><a href="#"></a>week</div>
						<div class="aio-button"><a href="#"></a>day</div>
						<div class="aio-button"><a href="#"></a>list</div>
					</div>
				</div>
			</div>
			<table class="aio-table">
				<thead>
					<tr class='aio-table-days'>
						<th>Sun</th>
						<th>Mon</th>
						<th>Tue</th>
						<th>Wed</th>
						<th>Thu</th>
						<th>Fri</th>
						<th>Sat</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$day      = 1;
						$day_week = gmdate( 'w', gmmktime( 0, 0, 0, $month, $day, $year ) );
						for ( $i = 0; $i < $day_week; $i++ ) {
							echo '<td></td>';
						}
						while ( $day <= $days ) {
							if ( $day_week > 6 ) {
								$day_week = 0;
								echo '</tr><tr>';
							}
							$event = ( isset( $events[ $day ] ) ) ? $events[ $day ] : '';
							echo '<td>';
							echo '<strong>' . esc_html( $day ) . '</strong><br>';
								// Check if events exist for this day.
							if ( ! empty( $event ) ) {
								// Loop through events and display each title.
								foreach ( $event as $event_title ) {
									echo wp_kses_post( $event_title );
									echo '<br>';
								}
							}
							echo '</td>';
							++$day;
							++$day_week;
						}
						?>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}
}
