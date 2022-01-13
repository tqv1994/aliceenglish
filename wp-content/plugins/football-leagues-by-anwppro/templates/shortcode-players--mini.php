<?php
/**
 * The Template for displaying Players.
 *
 * This template can be overridden by copying it to yourtheme/anwp-football-leagues/shortcode-players--mini.php.
 *
 * @var object $data - Object with widget data.
 *
 * @author        Andrei Strekozov <anwp.pro>
 * @package       AnWP-Football-Leagues/Templates
 * @since         0.5.1
 *
 * @version       0.13.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$default_photo = anwp_football_leagues()->helper->get_default_player_photo();

$data = (object) wp_parse_args(
	$data,
	[
		'competition_id'    => '',
		'join_secondary'    => 0,
		'season_id'         => '',
		'league_id'         => '',
		'club_id'           => '',
		'type'              => 'scorers',
		'limit'             => 0,
		'soft_limit'        => 'yes',
		'context'           => 'shortcode',
		'show_photo'        => 'yes',
		'penalty_goals'     => 0,
		'games_played'      => 0,
		'secondary_sorting' => '',
		'group_by_place'    => 0,
		'games_played_text' => '',
		'cache_version'     => 'v3',
	]
);

$data->penalty_goals  = AnWP_Football_Leagues::string_to_bool( $data->penalty_goals );
$data->games_played   = AnWP_Football_Leagues::string_to_bool( $data->games_played );
$data->group_by_place = AnWP_Football_Leagues::string_to_bool( $data->group_by_place );

// Try to get from cache
$cache_key = 'FL-SHORTCODE_players__' . md5( maybe_serialize( $data ) );

if ( anwp_football_leagues()->cache->get( $cache_key, 'anwp_match' ) ) {
	$players = anwp_football_leagues()->cache->get( $cache_key, 'anwp_match' );
} else {
	// Load data in default way
	$players = anwp_football_leagues()->player->tmpl_get_players_by_type( $data );

	// Save transient
	if ( ! empty( $players ) ) {
		anwp_football_leagues()->cache->set( $cache_key, $players, 'anwp_match' );
	}
}

if ( empty( $players ) ) {
	return;
}

// Limit number of players
if ( (int) $data->limit > 0 ) {
	$players = anwp_football_leagues()->player->tmpl_limit_players( $players, $data->limit, $data->soft_limit );
}

// Prepare players cache
$ids = wp_list_pluck( $players, 'player_id' );
anwp_football_leagues()->player->set_players_cache( $ids );

// Stats name
$stats_name = 'scorers' === $data->type ? AnWPFL_Text::get_value( 'players__shortcode__goals', __( 'Goals', 'anwp-football-leagues' ) ) : AnWPFL_Text::get_value( 'players__shortcode__assists', __( 'Assists', 'anwp-football-leagues' ) )
?>
<div class="anwp-b-wrap">
	<table class="table table-sm small table-bordered player-list layout--mini player-list--<?php echo esc_attr( $data->type ); ?> context--<?php echo esc_attr( $data->context ); ?>">

		<tbody>
		<tr class="anwp-bg-light">
			<th class="anwp-text-center"><?php echo esc_html( AnWPFL_Text::get_value( 'players__shortcode__rank_n', _x( '#', 'Rank', 'anwp-football-leagues' ) ) ); ?></th>
			<th width="90%"><?php echo esc_html( AnWPFL_Text::get_value( 'players__shortcode__player', __( 'Player', 'anwp-football-leagues' ) ) ); ?></th>

			<?php if ( $data->games_played ) : ?>
				<th><?php echo esc_html( $data->games_played_text ); ?></th>
			<?php endif; ?>

			<th class="anwp-text-center"><?php echo esc_html( $stats_name ); ?></th>
		</tr>
		</tbody>

		<tbody>
		<?php
		$group_by_place = -1;

		foreach ( $players as $index => $p ) :

			// Get player data
			$player = anwp_football_leagues()->player->get_player( $p->player_id );

			$clubs = explode( ',', $p->clubs );
			?>
			<tr class="anwp-text-center">
				<td class="player-list__rank text-nowrap">
					<?php
					if ( $data->group_by_place ) {
						echo absint( $p->countable ) !== $group_by_place ? intval( $index + 1 ) : '';
						$group_by_place = absint( $p->countable );
					} else {
						echo intval( $index + 1 );
					}
					?>
				</td>
				<td class="text-left text-truncate anwp-max-width-1">
					<div class="d-flex align-items-center">
						<?php if ( anwp_football_leagues()->helper->string_to_bool( $data->show_photo ) ) : ?>
							<div class="player__photo-wrapper player__photo-wrapper--list anwp-text-center mr-1">
								<img class="player__photo mx-auto" src="<?php echo esc_url( $player->photo ?: $default_photo ); ?>">
							</div>
						<?php endif; ?>
						<div class="text-truncate">
							<a class="anwp-link d-block text-truncate" title="<?php echo esc_attr( $player->name ); ?>"
								href="<?php echo esc_url( $player->link ); ?>"><?php echo esc_html( $player->name_short ); ?></a>
							<?php foreach ( $clubs as $ii => $club ) : ?>
								<div class="player-list__club">
									<?php echo esc_html( $ii > 0 ? ' | ' : '' ); ?>
									<a class="club__link anwp-link align-middle" href="<?php echo esc_url( anwp_football_leagues()->club->get_club_link_by_id( $club ) ); ?>">
										<?php echo esc_html( anwp_football_leagues()->club->get_club_title_by_id( $club ) ); ?>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</td>

				<?php if ( $data->games_played ) : ?>
					<td class="player-list__gp text-nowrap">
						<?php echo absint( $p->played ); ?>
					</td>
				<?php endif; ?>

				<td class="player-list__stat text-nowrap">
					<?php
					echo absint( $p->countable );

					if ( $data->penalty_goals && $p->penalty ) {
						echo ' (' . absint( $p->penalty ) . ')';
					}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
