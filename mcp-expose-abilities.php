<?php
/**
 * Plugin Name: MCP Expose All Abilities
 * Description: Marks all registered WordPress abilities as public for MCP Adapter.
 */

add_filter( 'wp_register_ability_args', function ( array $args, string $ability_name ) {
    if ( ! isset( $args['meta'] ) ) {
        $args['meta'] = array();
    }
    if ( ! isset( $args['meta']['mcp'] ) ) {
        $args['meta']['mcp'] = array();
    }
    $args['meta']['mcp']['public'] = true;
    return $args;
}, 10, 2 );
