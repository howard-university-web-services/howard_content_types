# Howard Content Types

Content Types for Howard installs.

This module, and submodules, contain markup only (no js or css), those should be provided in the client theme, loaded via the idfive Component Library:

 - [idfive Component Library](https://bitbucket.org/idfivellc/idfive-component-library)
 - [idfive Component Library D8 Theme](https://bitbucket.org/idfivellc/idfive-component-library-d8-theme)

 This module also provides default entity browsers for ease in creating media fields with the proper browsers. It also creates some standard fields used across the submodules.

## Instalation and Updates

**Install Via Composer:**
```
composer install howard/howard_content_types
```
**Update Via Composer:**
```
composer update howard/howard_content_types
```
## Submodules
The following submodules are available:
 - Announcements: Creates the "HC Announcement" Content Type.
 - Article: Creates the "HC Article" Content Type.
 - Page: Creates the "HC Basic Page" Content Type.
 - Standard Homepage: Creates the "HC Standard Homepage" Content Type.

## Configuration Overrides
This module is designed so that config can be overridden locally. Essentially, the config provides a "starter" when installing the module, that can be modified per site. If config is "added to" after initial install, a manual config resync will likely need to be done. Something like:

 - drush cim -y --partial --source=modules/contrib/howard_content_types/config/install/
 
 Keep in mind thast extensive testing should be done before attempting the above.

## Markup Overrides

- You may override paragraphs templates by copying them into the client theme.
- You may override hooks by copying into client .theme, and modifying hook name/etc.
