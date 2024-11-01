=== Unique Post Views Counter ===
Contributors: chandra sekhar Gudavalli
Tags: unique views,unquer page count,unique hits,unique counter,postviews,total views,unique counter
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will enable you to display how many times a post has been viewed by unique users and we can get the total views also.


== Description ==
This one is counts and dipslay all unique users hits or views for each post on our blog.
We are saving every information in the database.
Once we activate this plugin, it will automatically create table in the database.





== Installation ==
1. Download the file
2. Upload and extract the file the copy the folder into our plugin location like (wp-content/plugins/unique_post_view_conter)
3. Activate the plugin from admin side.
4. If you want to display uniquer user count add this function in single.php . `<?php unique_views(get_the_ID()); ?>` Unique Views
5. If you want to display full count add this function in single.php . `<?php total_views(get_the_ID()); ?>` Total Views


== Screenshots ==