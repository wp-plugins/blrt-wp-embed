<?php
/**
* Plugin Name: Blrt WP Embed
* Plugin URI: http://www.blrt.com/wordpress-plugin
* Description: Enable embedding Blrts in your pages and posts by simply pasting in the URL of a public or private Blrt - just like YouTube videos are embedded utilising oEmbed.
* Version: 1.0.0
* Author: Blrt
* Author URI: http://www.blrt.com
* License: GPL2
*/

/* Copyright 2015  Blrt Operations Pty Ltd  (email : support@blrt.com)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License, version 2, as 
   published by the Free Software Foundation.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 

defined( 'ABSPATH' ) or die( 'No direct access to this file' );

class BlrtWPEmbed {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }
    
    public function init() {
        $this->add_oembed_providers();
    }
    
    private function add_oembed_providers() {
        $convertible_servers = $this->get_convertible_servers();
        $oembed_server = $this->get_oembed_server();
        
        if(!($convertible_servers && $oembed_server)) return false;
        
        $preg_convertible_servers = '(' . implode( '|', array_map( 'preg_quote', $convertible_servers ) ) . ')';
        wp_oembed_add_provider( "#https?://$preg_convertible_servers/(conv/.*?/)?blrt/.*#i", "https://$oembed_server/oembed", true );
        
        return true;
    }
    
    private function get_convertible_servers() {
        return apply_filters( 'blrt_wp_embed_convertible_servers' , array(
            'e.blrt.com',
            'm.blrt.co'
        ) );
    }
    
    private function get_oembed_server() {
        return apply_filters( 'blrt_wp_embed_oembed_server', 'e.blrt.com' );
    }
}

$blrtwp_embed = new BlrtWPEmbed();
