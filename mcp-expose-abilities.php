<?php
/**
 * Plugin Name: MCP Expose All Abilities
 * Description: Marks all registered WordPress abilities as public for MCP Adapter.
 */

add_filter('wp_abilities_register_ability_args', function ($args, $name) {
    if (!isset($args['meta'])) {
        $args['meta'] = [];
    }
    $args['meta']['mcp.public'] = true;
    return $args;
}, 10, 2);
