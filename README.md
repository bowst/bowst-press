# BOWST-PRESS

-   Bowst-Press is Bowst's out of the box solution and starting point for building a custom Wordpress site.
-   Based on [Underscores.me](http://underscores.me) Wordpress starter theme.
-   Complete with node modules (bootstrap, gulp, font awesome) and a Gulp build system for compiling styles and javascript.
-   Follow the steps below to get started.

## 1) Download

1.  Dowload the Bowst-Press theme and place it in the 'themes' folder in /wp-content/themes.

## 2) Rename

1.  Rename the folder 'bowst-press' to the name of your new theme or project.
2.  In 'style.css' change the 'Theme Name' to the name you chose in above (this is the display name for the theme in the Wordpress admin, so exclude dashes or underscores), and change the other meta data items in respect to your project.
3.  Change all 'bowst*press' references in 'functions.php' to the new folder name you applied in step 2-1 (if a '-'' was used in the name, change it to a '*').

## 3) Settings

1.  In your .gitignore file, add the following to ensure your node packages do not get committed to your GIT repo:
    wp-content/themes/theme-name-in-step-2)/node_modules/

## 4) Override

1.  Override favicon.io with your custom fav icon.
2.  Override screenshot.png with a screenshot that represents your theme's design (880x660).
3.  Override /public/img/logo.png with your theme's logo.

## 5) Install

1.  Open up terminal and enter 'npm install' to install all of the node modules that come with this theme.
2.  Activate the theme itself in the Wordpress Admin (Appearance > Themes).

## 6) Plugins

The following plugins are used in most of our projects and are recommended:

1.  [Advanced Custom Fields with Repeater Field](https://wordpress.org/plugins/advanced-custom-fields/)
2.  [Custom Post Type UI](https://wordpress.org/plugins/custom-post-type-ui/)
3.  [Yoast](https://wordpress.org/plugins/wordpress-seo/)
4.  [Google Analytics](https://wordpress.org/plugins/google-analytics-dashboard-for-wp/)
5.  [Intuitive Custom Post Order](https://wordpress.org/plugins/intuitive-custom-post-order/)
6.  [Custom Sidebars](https://wordpress.org/plugins/custom-sidebars/)
7.  [Regenerate Thumbnails](https://wordpress.org/plugins/regenerate-thumbnails/)
8.  [Smush Image Compression and Optimization](https://wordpress.org/plugins/wp-smushit/)
9.  [Dashicons](https://developer.wordpress.org/resource/dashicons/#arrow-left-alt)

## 7) Styles

1.  Override global variables in "src/sass/\_variables.scss". Create custom variables if necessary. Most base styles will pop right into place upon the customization of these variables.
2.  Style global/default elements (h1, h2, p, a, etc) in "src/sass/\_base.scss" (only if variables are not available for them in the above file).
3.  In "src/sass/components-styles" override the color selectors and variables in "\_backgrounds.scss" and "\_type.scss" with your theme's custom color variables and names.
4.  Style global buttons and forms based on your design in "src/sass/components-styles/buttons" and "../forms".
5.  Compile your styles with Gulp by using the command "gulp" in Terminal in your theme's root folder.
6.  Use the --url argument if you want to use BrowserSync to automatically reload your CSS and JS changes (Ex: "gulp --url http://yourlocaldevsite.kbox.site").

## 8) Build

Build out the structure of your Wordpress theme. Create pages, page types, apply templates, create and apply sidebars, add custom fields, and more!

### Default Templates (in alphabetical order)

-   **404.php**: 404 error page template
-   **archive.php**: Blog archive page template
-   **comments.php**: Blog comments template
-   **footer.php**: Global website footer template, referenced in all other templates
-   **front-page.php**: Homepage template
-   **header.php**: Global website header template, referenced in all other templates
-   **index.php**: Blog listing template
-   **page.php**: Page template, applied by defailt if no custom template as been assigned and references files in 'template-parts'
-   **search.php**: Search results template
-   **sidebar.php**: Sidebar template (pulls dynamic data from admin)
-   **single.php**: Post template, applied by defailt if no custom template as been assigned and references files in 'template-parts'

### Additonal Templates

-   **'Templates' folder**: Place all custom templates here. Remeber to add the 'template display name' as a php comment at the top (as shown in front-page.php).
-   **'Template Parts' folder**: Various partial displays depending on what kind of page/post view you are on.
    _ content-none.php: Empty search results
    _ content-page.php: Page content
    _ content-search.php: Search results
    _ content.php: Post content
