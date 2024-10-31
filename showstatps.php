<?php
/*
Plugin Name: My Plugin Stats
Plugin URI: http://mysqlhow2.com/
Description: Watch the number of downloads on a plugin.
Version: 1.1
Author: Lee Thompson
Author URI: http://mysqlhow2.com
*/
/*
Copyright 2010  Lee Thompson (email: mysql_dba@cox.net)

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




add_action('admin_menu', 'my_plugin_stats_add_admin_menu');
add_action('init', 'my_plugin_stats_init');


echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') .'/wp-content/plugins/my-plugin-stats/showstats.css" />' . "\n";


function my_plugin_stats_add_admin_menu() {
 add_submenu_page('options-general.php', 'My Plugin Stats', 'My Plugin Stats', 8, __FILE__, 'my_plugin_stats_admin_menu');
}

function my_plugin_stats_admin_menu() {
 include('mypluginstats_admin.php');
}

function my_plugin_stats_init() {
        if(!get_option('my_plugin_stats')) {
                add_option('my_plugin_stats');
                update_option('my_plugin_stats','http://wordpress.org/extend/plugins/wordpress-woot-watcher/stats/');
        }
        add_filter('plugin_row_meta', 'my_plugin_stats_Plugin_Links',10,2);

}

function my_plugin_stats_Plugin_Links($links, $file) {
        $plugin = plugin_basename(__FILE__);
        if ($file == $plugin) {
                $links[] = '<a href="options-general.php?page='.$plugin.'">' . __('Settings') . '</a>';
                $links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=25LDNVSUTHKAJ" target="_blank">' . __('Donate to this plugin') . '</a>';
        }
        return $links;
}

function my_plugin_stats() {
	// Inlcude our tag grab class
	include("stats.php"); // class for spider
	// Enter the URL you want to run
        $getplugins = get_option('my_plugin_stats');
        $plugin = explode(',',$getplugins);
	echo "<table class=\"servicesT\">";
	$numcols = 3; // how many columns to display
	$numcolsprinted = 0; // no of columns so far
        foreach($plugin as $urlrun) {
		$title = split("/",$urlrun);
		// Specify the start and end tags you want to grab data between
		$stag="<h4>History</h4>";
		$etag="</table>";
		// Make a title spider
		$tspider = new tagSpider();
		// Pass URL to the fetch page function
		$tspider->fetchPage($urlrun);
		// Enter the tags into the parse array function
		$linkarray = $tspider->parse_array($stag, $etag);
		// Loop to pump out the results
		foreach ($linkarray as $result) {
		$result = str_replace("<h4>History</h4>", "", $result);	
                if ($numcolsprinted == $numcols) {
			echo"</tr><tr>";
                        $numcolsprinted = 0;
                }
			echo "<th class=\"servHd\">".strtoupper($title[5])."</th>";
			echo "<td class=\"servHd\">".$result."</td>";
			$numcolsprinted++;
		}
		$colstobalance = $numcols - $numcolsprinted;
		for ($i=1; $i<=$colstobalance; $i++) {
		echo "<td class=\"servHd\"></td>\n";
		}
	}
	echo "</table>";
}

function my_plugin_stats_setup() {
        wp_add_dashboard_widget( 'my_plugin_stats', __( 'My Plugin Stats' ), 'my_plugin_stats' );
}

add_action('wp_dashboard_setup', 'my_plugin_stats_setup');
?>
