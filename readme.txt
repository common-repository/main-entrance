=== Main Entrance ===
Contributors: Christian Gatti
Tags: front end login,register,login,frontend
Donate link: http://paypal.me/ChristianGatti
Requires at least: 4.7
Tested up to: 6.5
Requires PHP: 7.x
Stable tag: 1.9.4
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Login, register or recover password through a handy and safe form that you can easily place, through shortcode, in every page or post of your WordPress website. Hide wp-login and let user login or register only through **Main Entrance** forms


== Description ==

Install and activate **Main Entrance** plugin, copy [main-entrance-form] shortcode into the page where you want to show the frontend form or enter the Main Entrance setup and build automatically a login page.

Define where to redirect registered users and define if to let them auto login after registration; this is particularly useful if you want to redirect them to a restricted content.

Define where to redirect users after login; you can set two different destinations for all users and for Main Entrance Users only (users registered through Main Entrance forms).

In association with [NutsForPress Restricted Contents](https://wordpress.org/plugins/nutsforpress-restricted-contents/), Main Entrance helps you to build a restricted content page, for allowing to download documents only to logged in users.

In association with [NutsForPress Login Watchdog](https://wordpress.org/plugins/nutsforpress-login-watchdog/), you can monitor login attempts, lock down users exceeding login attempts conceded and you can display custom errors instead of default WordPress login errors.

Fully compliant with GDPR, **Main Entrance** lets you define up to two different disclaimers and to acquire two different consents, one of them mandatory.

A complete and easy setup panel will guide you through various and useful settings.

**Whatever is worth doing at all is worth doing well**


== Installation ==

= Installation From Plugin Repository =

* Into your WordPress plugin section, press "Add New"
* Use "Main Entrance" as search term
* Click on *Install Now* on *Main Entrance* into result page, then click on *Activate*
* Set "Main Entrance" options by clicking on the link you find under the "Tools" menu

= Manual Installation =

* Download *Main Entrance* from https://wordpress.org/plugins/main-entrance
* Into your WordPress plugin section, press "Add New" then press "Load Plugin"
* Choose restricted-media.zip file from your local download folder
* Press "Install Now"
* Activate *Main Entrance*
* Set "Main Entrance" options by clicking on the "Main Entrance" link you find into WordPress dashboard
* Enjoy!


== Screenshots ==

1. Front end form example (no style)
2. Main Entrance setup page


== Changelog ==

= 1.9.4 =
* Tested up to WordPress 6.2

= 1.9.3 =
* Now you can set a comma separated list of email recipients to send new registration notifications 
* Added an "Address" field
* Few other improvements

= 1.9.2 =
* Now translations are provided by translate.wordpress.org, instead of being locally provided: please contribute!

= 1.9.1 =
* Fixed minor bugs introduced with the release 1.9

= 1.9 =
* Now you have more available fields to add to registration form and now you can check and edit custom fields within the user editor

= 1.8 =
* Minor but essential modifications, in order to interact with the incoming new version of "Restricted Media, Pages and Posts"

= 1.7 =
* In association with "Restricted Media, Pages and Posts" plugin, now you can redirect user to the origin page after registration or login 
* Minor improvements

= 1.6.2 =
* Fixed a bug that prevented from using ajax when WordPress dashboard was set to be hidden to users with role of "Main Entrance User" 

= 1.6.1 =
* Added the action "mnnt_user_registration" on completed user registration that passes the registrant email address (for subscribing to a mailing list, for example)

= 1.6 =
* Added a "Surname" to the additional field
* Added the action "mnnt_secondary_acceptance" on completed user registration that passes the registrant email address (for subscribing to a mailing list, for example) only if he/she has flagged the secondary acceptance
* Now "Name" and "Surname" field are saved as WordPress User firstname and lastname

= 1.5 =
* You can now decide the recipient address of the registration notification

= 1.4 =
* Added a small function to interact with Restricted Media plugin

= 1.3 =
* Now you can choose a set of optional fields to add to registration form and define if they have to be filled out mandatorily or not

= 1.2 =
* Fixed a bug that prevented from being displayed more than five documents into privacy selectbox (backend)

= 1.1 =
* Now you can define where to redirect users after login by role
* After login you can redirect to admin dashboard every user that doesn't have the "Main Entrance User" role
* Some minor bug fix

= 1.0 =
* First full working release


== Translations ==

* English: default language
* Italian: entirely translated


== Credits ==

* Very many thanks to [DkR](https://dkr.srl/) and [SviluppoEuropa](https://sviluppoeuropa.it/)!