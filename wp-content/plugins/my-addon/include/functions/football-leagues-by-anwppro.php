<?php
add_action( 'rank_math/vars/register_extra_replacements', function(){
    rank_math_register_var_replacement(
        'shortcode_player_get_title_clb', [
        'name'        => esc_html__( 'ANWP Player - Title clb', 'rank-math' ),
        'description' => esc_html__( 'Get title clb of player', 'rank-math' ),
        'variable'    => 'shortcode_player_get_title_clb',
        'example'     => esc_html__( 'Title Club', 'rank-math' ),
    ],
        'shortcode_player_get_title_clb_call_back'
    );

    rank_math_register_var_replacement(
        'shortcode_player_get_position_title', [
        'name'        => esc_html__( 'ANWP Player - Position Title', 'rank-math' ),
        'description' => esc_html__( 'Get position title of player', 'rank-math' ),
        'variable'    => 'shortcode_player_get_position_title',
        'example'     => esc_html__( 'Position Title', 'rank-math' ),
    ],
        'shortcode_player_get_position_title_call_back'
    );

    rank_math_register_var_replacement(
        'shortcode_player_get_country_of_birth', [
        'name'        => esc_html__( 'ANWP Player - Country  Of Birth', 'rank-math' ),
        'description' => esc_html__( 'Get Country  Of Birth of player', 'rank-math' ),
        'variable'    => 'shortcode_player_get_country_of_birth',
        'example'     => esc_html__( 'Country Of Birth', 'rank-math' ),
    ],
        'shortcode_player_get_country_of_birth_call_back'
    );
});
function shortcode_player_get_title_clb_call_back(){
    global $post;
    $object    = is_object( $post ) ? $post : [];
    $has_post  = is_object( $object ) && isset( $object->ID );
    $on_screen = is_singular() || is_admin() || ! empty( get_query_var( 'sitemap' ) );
    if ( ! $has_post || ! $on_screen ) {
        return null;
    }
    $club_id  = absint( get_post_meta( $object->ID, '_anwpfl_current_club', true ) );
    if(function_exists('anwp_football_leagues')){
        $club_title = anwp_football_leagues()->club->get_club_title_by_id( $club_id );
        return $club_title;
    }
    return '';
}

function shortcode_player_get_position_title_call_back(){
    global $post;
    $object    = is_object( $post ) ? $post : [];
    $has_post  = is_object( $object ) && isset( $object->ID );
    $on_screen = is_singular() || is_admin() || ! empty( get_query_var( 'sitemap' ) );
    if ( ! $has_post || ! $on_screen ) {
        return null;
    }
    $position_code  = get_post_meta( $object->ID, '_anwpfl_position', true ) ;
    if(function_exists('anwp_football_leagues')){
        $position_title = anwp_football_leagues()->player->get_translated_position($object->ID,$position_code);
        return $position_title;
    }
    return '';
}

function shortcode_player_get_country_of_birth_call_back(){
    global $post;
    $object    = is_object( $post ) ? $post : [];
    $has_post  = is_object( $object ) && isset( $object->ID );
    $on_screen = is_singular() || is_admin() || ! empty( get_query_var( 'sitemap' ) );
    if ( ! $has_post || ! $on_screen ) {
        return null;
    }
    $country_key = get_post_meta( $object->ID, '_anwpfl_country_of_birth', true ) ;
    if(function_exists('anwp_football_leagues')) {
        return esc_attr(anwp_football_leagues()->data->get_value_by_key($country_key, 'country'));
    }
    return $country_key;
}

include(MY_ADDON_FUNCTION_PATH.'/page-template.php');
PageTemplater::get_instance();