=== KnockoutBunny ===
Contributors: knockoutbunny
Tags: game, survey, competition, quiz, engagement
Requires at least: 5.6
Tested up to: 5.8
Stable tag: 1.2.0
Requires PHP: 7.3.9
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable site visitors to have fun whilst picking their favourite from 8 items of your choosing.

== Description ==

# The KnockoutBunny Plugin

The KnockoutBunny wordpress plugin can be used to create a fun game for your site visitors to play to help them pick their favourite from a list of eight items that you set using an admin screen. You can then analyse the results of these choices. 

> They PLAY whilst you LEARN!

## Setup

  - Use the admin screen to create a game for your users to play
  - Simply use the shortcode [[knockoutbunny]] to add the game to your site

## Playing the game

  - The user plays a series of one-v-one matches to help them decide their favourite from your eight items
  - The results from the game are displayed as a simple image which your user can easily share with their friends 

## Analysis

  - You can see a summary of choices users have made via your Dashboard

## Demo Video

https://player.vimeo.com/video/598863803

## Tech

The plugin is written using php, CSS and javascript.


## Wordpress

The plugin uses the following Wordpress functionality:
  - Shortcodes
  - Custom Posts and Metadata
  - Settings Api
  - Dashboard Widgets
  - REST Api
  - Translation

Feel free to take a look and comment using the Review and/or Support sections.


== Frequently Asked Questions ==

= Which users choices are stored? =

A user who has Edit Post permissions will have the results of their game stored

= How are users choices stored? =

A user's choices are stored as draft Custom Posts called 'knockoutbunny_results'

= How are the choices ranked? =

For each game the following points are awarded:
Winner - 5 pts
RunnerUp - 3 pts
Losing Semi-Finalist - 2 pts
Losing Quarter-Finalist - 1 pt

These points are stored as metadata attached to the knockoutbunny_results custom posts

= What if I want to change my game? =

You can create a new game simply by editing the existing game defined in the KnockoutBunny Settings menu. However, to ensure accurate analysis you should remember to delete all of the knockoutbunny_results posts associated with the previous game.

= Who can view analysis results? =

All Administrators can view a summary of games played via the widget that appears on your Dashboard.

= How can I comment or make suggestions? =

All comments/suggestions are welcomed and can be submitted via the Plugin's Support section


== Screenshots ==

1. Admin screen to create a game
2. The initial screen a user is displayed
3. Once the PLAY button is clicked, the game commences and the user is asked to choose between two items
4. The final screen displays the results as an image file
5. A summary of users' choices are shown on the dashboard


== Change Log ==

= 1.2.0 =
Handle Responsive Design and make block fixed size

= 1.1.0 =
Introduction of analysis functionality

= 1.0.0 =
Initial Release

== Upgrade Notice ==

= 1.2.0 =
This release provides improved formatting for phone devices
 
= 1.1.0 =
This release provides a dashboard to allow you to learn more about your customers 