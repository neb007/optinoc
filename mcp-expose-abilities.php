<?php
/**
 * Plugin Name: OPTINOC Security & MCP
 * Description: Security hardening and MCP abilities exposure.
 */

// Expose all abilities via MCP
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

// Block user enumeration for unauthenticated requests
add_filter( 'rest_authentication_errors', function ( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
    $path = trim( $_SERVER['REQUEST_URI'] ?? '', '/' );
    if ( ! is_user_logged_in() && strpos( $path, 'wp-json/wp/v2/users' ) !== false ) {
        return new WP_Error( 'rest_forbidden', 'Access denied.', array( 'status' => 403 ) );
    }
    return $result;
} );

// Remove X-Pingback header
add_filter( 'wp_headers', function ( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
} );

// Disable XML-RPC at PHP level (backup to nginx block)
add_filter( 'xmlrpc_enabled', '__return_false' );
