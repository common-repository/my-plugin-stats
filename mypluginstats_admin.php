<?php
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

function delete_form(){
        $myvariable = get_option('my_plugin_stats');
        $checked_feeds = explode(',',$myvariable);
?>
	<div class="wrap">
	<h2>Delete from My Plugin Stats</h2>
	Manage the plugins you want to watch here.<br>
	<form method="post" action="<?php echo $PHP_SELF; ?>">
	<?php 
	foreach ($checked_feeds as $plugin) {
 ?>
<table class="form-table">
        <tr valign="top">
        <th scope="row"><?php echo $plugin; ?></th>
        <td><input type="checkbox" name="delete_plugin_stats[]" value="<?php echo $plugin; ?>" /></td>
        </tr>
</table>
<?php 
}
?>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Delete Plugin Stats') ?>" />
    </p>
</form>
</div>
<?php
}

function add_form(){
?>
<div class="wrap">
        	<h2>Add another plugin to get stats</h2>
        <form method="post" action="<?php echo $PHP_SELF; ?>">
		<table class="form-table">
        		<tr valign="top">
			        <th scope="row">Add New Plugin</th>
			        <td>URL of plugin stats from wordpress.org<input type="text" name="add_plugin_stats" /></td>
		        </tr>
		</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Add Plugin') ?>" />
    	</p>
	</form>
</div>

<?php
}

if(isset($_POST['add_plugin_stats']))
{

	$newvariable=$_POST["add_plugin_stats"];
        $myvariable = get_option('my_plugin_stats');
        $checked_feeds = explode(',',$myvariable);

        foreach ($checked_feeds as $plugin) {
        $current_plugins = $plugin.",";
	if ($newvariable == $plugin){
		echo "<div class=\"updated\">Already added to Plugin Stats.</div>";
	delete_form();
	add_form();
	exit;
	}
        $newvariable = $current_plugins."$newvariable";
}
        echo "<div class=\"updated\">Added to Plugin Stats.</div>";
update_option('my_plugin_stats', "$newvariable");
}

if(isset($_POST['delete_plugin_stats']))
{

        echo "<div class=\"updated\">Deleted from Plugin Stats.</div>";
        $newvariable=$_POST["delete_plugin_stats"];
	$how_many = count($newvariable);
     	for ($i=0; $i<$how_many; $i++) {
        	$deleteplugins =  $newvariable[$i];
	}     	
        $myvariable = get_option('my_plugin_stats');
        $checked_feeds = explode(',',$myvariable);
        foreach ($checked_feeds as $plugin) {
        $current_plugins = $plugin.",";
        $deletevariable = str_replace($deleteplugins, "" ,$current_plugins);
        $deletevariable = str_replace(",", "" ,$current_plugins);
	update_option('my_plugin_stats', "$deletevariable");
	}
}

delete_form();
add_form();

?>
<br>
<div class="wrap">
Donations are accepted for continued development of My Plugin Stats. Thank you.<br>
<script type="text/javascript">
        <!--
        document.write(unescape("%3Ca%20href%20%3D%20%22https%3A//www.paypal.com/cgi-bin/webscr%3Fcmd%3D_s-xclick%26hosted_button_id%3D25LDNVSUTHKAJ%22%20target%20%3D%20%22_blank%22%3E%3Cimg%20src%3D%22https%3A//www.paypal.com/en_US/i/btn/btn_donate_SM.gif%22%20border%3D%220%22%20name%3D%22submit%22%20alt%3D%22PayPal%20-%20The%20safer%2C%20easier%20way%20to%20pay%20online%21%22%3E%3C/a%3E%0A"));
        //-->
        </script>
</div>
