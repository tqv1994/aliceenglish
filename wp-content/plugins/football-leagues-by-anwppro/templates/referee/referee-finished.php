<?php
/**
 * The Template for displaying Referee >> Finished Games Section.
 *
 * This template can be overridden by copying it to yourtheme/anwp-football-leagues/referee/referee-finished.php.
 *
 * @var object $data - Object with args.
 *
 * @author        Andrei Strekozov <anwp.pro>
 * @package       AnWP-Football-Leagues/Templates
 * @since         0.11.14
 *
 * @version       0.13.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Parse template data
$data = (object) wp_parse_args(
	$data,
	[
		'staff_id' => '',
	]
);

if ( empty( $data->staff_id ) ) {
	return;
}

// Get Season ID
$season_id = anwp_football_leagues()->get_active_referee_season( $data->staff_id );

if ( ! empty( $_GET['season'] ) ) {  // phpcs:ignore WordPress.Security.NonceVerification

	$current_season  = sanitize_key( $_GET['season'] ); // phpcs:ignore WordPress.Security.NonceVerification
	$maybe_season_id = anwp_football_leagues()->season->get_season_id_by_slug( $current_season );

	if ( absint( $maybe_season_id ) ) {
		$season_id = absint( $maybe_season_id );
	}
}

$games_options = [
	'referee_id'   => $data->staff_id,
	'season_id'    => $season_id,
	'type'         => 'result',
	'sort_by_date' => 'desc',
	'class'        => 'mt-2',
];

$games_referee   = anwp_football_leagues()->referee->get_referee_games( $games_options );
$games_assistant = anwp_football_leagues()->referee->get_referee_games( $games_options, '', 'assistant' );
?>
<div class="referee__finished referee-section anwp-section anwp-b-wrap">

	<div class="anwp-block-header__wrapper d-flex justify-content-between">
		<div class="anwp-block-header">
			<?php echo esc_html( AnWPFL_Text::get_value( 'referee__finished__finished_matches', __( 'Finished matches', 'anwp-football-leagues' ) ) ); ?>
		</div>

		<?php
		$dropdown_filter = [
			'context' => 'referee',
			'id'      => $data->staff_id,
		];

		anwp_football_leagues()->helper->season_dropdown( $season_id, true, '', $dropdown_filter );
		?>
	</div>

	<?php if ( empty( $games_referee ) && empty( $games_assistant ) ) : ?>
		<div class="anwp-b-wrap match-list">
			<div class="list-group">
				<?php anwp_football_leagues()->load_partial( [ 'no_data_text' => AnWPFL_Text::get_value( 'referee__finished__no_data', __( 'no data', 'anwp-football-leagues' ) ) ], 'nodata' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $games_referee ) ) : ?>
		<div class="match-list">
			<div class="anwp-bg-gray-200 px-2 anwp-border anwp-border-gray-300 anwp-border-bottom-0">
				<?php echo esc_html( AnWPFL_Text::get_value( 'match__referees__referee', __( 'Referee', 'anwp-football-leagues' ) ) ); ?>
			</div>
			<div class="list-group">
				<?php
				$cards_by_game = anwp_football_leagues()->referee->get_cards_game_by_players( $games_referee );

				foreach ( $games_referee as $list_match ) :
					// Get match data to render
					$data = anwp_football_leagues()->match->prepare_match_data_to_render( $list_match );

					$data['competition_logo']   = 1;
					$data['extra_actions_html'] = anwp_football_leagues()->referee->get_cards_game_html(
						$list_match,
						isset( $cards_by_game[ $list_match->match_id ] ) ? $cards_by_game[ $list_match->match_id ] : []
					);

					anwp_football_leagues()->load_partial( $data, 'match/match', 'slim' );

				endforeach;
				?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $games_assistant ) ) : ?>
		<div class="match-list mt-1">
			<div class="anwp-bg-gray-200 px-2 anwp-border anwp-border-gray-300 anwp-border-bottom-0">
				<?php echo esc_html( AnWPFL_Text::get_value( 'match__referees__assistant', __( 'Assistant Referee', 'anwp-football-leagues' ) ) ); ?>
			</div>
			<div class="list-group">
				<?php
				foreach ( $games_assistant as $list_match ) :
					// Get match data to render
					$data = anwp_football_leagues()->match->prepare_match_data_to_render( $list_match );

					$data['competition_logo']   = 1;
					$data['extra_actions_html'] = anwp_football_leagues()->referee->get_cards_game_html( false );

					anwp_football_leagues()->load_partial( $data, 'match/match', 'slim' );

				endforeach;
				?>
			</div>
		</div>
	<?php endif; ?>
</div>
