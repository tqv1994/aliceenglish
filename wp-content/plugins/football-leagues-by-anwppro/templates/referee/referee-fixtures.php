<?php
/**
 * The Template for displaying Referee >> Fixtures Games Section.
 *
 * This template can be overridden by copying it to yourtheme/anwp-football-leagues/referee/referee-fixtures.php.
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

$games_options = [
	'referee_id'   => $data->staff_id,
	'type'         => 'fixture',
	'sort_by_date' => 'asc',
	'class'        => 'mt-2',
];

$games_referee   = anwp_football_leagues()->referee->get_referee_games( $games_options );
$games_assistant = anwp_football_leagues()->referee->get_referee_games( $games_options, '', 'assistant' );

if ( empty( $games_referee ) && empty( $games_assistant ) ) {
	return;
}
?>
<div class="referee__fixtures referee-section anwp-section anwp-b-wrap">

	<div class="anwp-block-header__wrapper d-flex justify-content-between">
		<div class="anwp-block-header">
			<?php echo esc_html( AnWPFL_Text::get_value( 'referee__fixtures__upcoming_matches', __( 'Upcoming matches', 'anwp-football-leagues' ) ) ); ?>
		</div>
	</div>

	<?php if ( ! empty( $games_referee ) ) : ?>
		<div class="match-list">
			<div class="anwp-bg-gray-200 px-2 anwp-border anwp-border-gray-300 anwp-border-bottom-0">
				<?php echo esc_html( AnWPFL_Text::get_value( 'match__referees__referee', __( 'Referee', 'anwp-football-leagues' ) ) ); ?>
			</div>
			<div class="list-group">
				<?php
				foreach ( $games_referee as $list_match ) :
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
