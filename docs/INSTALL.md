# Installation Guide

This guide provides comprehensive instructions for installing and configuring the Howard Content Types module and its sub-modules.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Sub-Module Configuration](#sub-module-configuration)
- [Content Type Setup](#content-type-setup)
- [Media Configuration](#media-configuration)
- [Theme Integration](#theme-integration)
- [Troubleshooting](#troubleshooting)
- [Security Considerations](#security-considerations)

## Prerequisites

### System Requirements
- **Drupal:** 10.x or 11.x
- **PHP:** 8.1 or higher
- **Database:** MySQL 5.7+, PostgreSQL 10+, or MariaDB 10.3+
- **Web Server:** Apache 2.4+ or Nginx 1.12+
- **Memory:** 512MB minimum (1GB+ recommended)

### Required Modules
The following Drupal modules are required dependencies:

```bash
# Core modules (automatically available)
- field
- file
- filter
- image
- link
- media
- options
- system
- text

# Contributed modules (install via Composer)
- entity_reference_revisions
- focal_point
- paragraphs
```

### Recommended Modules
For optimal functionality, install these additional modules:

```bash
# Enhanced media management
- media_entity_browser
- entity_browser

# Content management
- pathauto
- metatag

# Development tools
- config_update
- devel (development only)
```

## Installation

### Method 1: Composer Installation (Recommended)

1. **Install the module via Composer:**
   ```bash
   composer require howard/howard_content_types
   ```

2. **Enable the main module:**
   ```bash
   drush en howard_content_types
   ```

3. **Clear cache:**
   ```bash
   drush cr
   ```

### Method 2: Manual Installation

1. **Download the module:**
   - Clone from repository or download ZIP file
   - Extract to `modules/contrib/howard_content_types/`

2. **Install dependencies:**
   ```bash
   composer require drupal/entity_reference_revisions drupal/focal_point drupal/paragraphs
   ```

3. **Enable the module:**
   ```bash
   drush en howard_content_types
   ```

### Verification

After installation, verify the module is properly installed:

```bash
# Check module status
drush pm:list --filter=howard_content_types

# Verify dependencies
drush pm:list --filter=entity_reference_revisions,focal_point,paragraphs
```

## Sub-Module Configuration

Howard Content Types includes six sub-modules for different content types. Enable only the ones you need:

### Available Sub-Modules

| Sub-Module | Command | Content Type | Purpose |
|------------|---------|--------------|---------|
| **HC Announcements** | `drush en hc_announcements` | Announcement | University news and announcements |
| **HC Article** | `drush en hc_article` | Article | Long-form articles and stories |
| **HC Page** | `drush en hc_page` | Basic Page | Standard informational pages |
| **HC Person** | `drush en hc_person` | Person | Faculty, staff, and student profiles |
| **HC Resource** | `drush en hc_resource` | Resource | Educational resources and materials |
| **HC Standard Homepage** | `drush en hc_standard_homepage` | Standard Homepage | Department and unit homepages |

### Enabling Sub-Modules

**Enable individual sub-modules:**
```bash
# Enable specific content types
drush en hc_page hc_person hc_article

# Enable all sub-modules
drush en hc_announcements hc_article hc_page hc_person hc_resource hc_standard_homepage
```

**Verify sub-module installation:**
```bash
# Check enabled sub-modules
drush pm:list --filter=hc_

# Clear cache after enabling
drush cr
```

## Content Type Setup

After enabling sub-modules, configure the content types:

### 1. Access Content Type Configuration

Navigate to: `Administration » Structure » Content types`

### 2. Configure Individual Content Types

Each Howard content type comes with default configuration:

#### HC Announcement Configuration
- **Machine name:** `hc_announcement`
- **Default fields:** Title, Body, Header Image, Category
- **Display modes:** Full, Teaser, Card
- **Permissions:** Configure user access as needed

#### HC Article Configuration
- **Machine name:** `hc_article`
- **Default fields:** Title, Body, Header Image, Author, Tags
- **Display modes:** Full, Teaser, Summary
- **Features:** Rich text editing, image galleries

#### HC Page Configuration
- **Machine name:** `hc_page`
- **Default fields:** Title, Body, Header Image, Menu settings
- **Display modes:** Full
- **Features:** Hierarchical page structure

#### HC Person Configuration
- **Machine name:** `hc_person`
- **Default fields:** Name, Bio, Photo, Position, Contact info
- **Display modes:** Full, Card, Directory
- **Features:** Contact information, social links

#### HC Resource Configuration
- **Machine name:** `hc_resource`
- **Default fields:** Title, Description, File attachments, Category
- **Display modes:** Full, List, Download
- **Features:** File management, categorization

#### HC Standard Homepage Configuration
- **Machine name:** `hc_standard_homepage`
- **Default fields:** Title, Hero content, Sections, Sidebar
- **Display modes:** Full
- **Features:** Flexible page layout, content blocks

### 3. Customize Field Settings

For each content type, you can customize:

**Field Settings:**
- Required vs. optional fields
- Field labels and help text
- Default values
- Validation rules

**Display Settings:**
- Field order and visibility
- Display formatters
- Responsive image styles
- View modes

**Form Settings:**
- Field widget types
- Field grouping
- Required field indicators
- Help text placement

## Media Configuration

Howard Content Types includes pre-configured media management:

### Default Media Types

The module creates several media browser categories:

- Students
- Alumni
- Faculty & Staff
- Events
- Campus Landmarks
- University Figures
- Campus Life
- Athletics
- Academic Programs
- Research

### Entity Browser Setup

1. **Configure entity browsers:**
   ```bash
   # Navigate to entity browser configuration
   admin/config/content/entity_browser
   ```

2. **Default browsers available:**
   - `hc_media_browser` - General media selection
   - `media_entity_browser` - Enhanced media management

3. **Customize browser settings:**
   - Upload settings and file types
   - Display modes and sorting
   - Access permissions

### Image Style Configuration

Default image styles are created for content types:

- `hc_hero_image` - Large header images
- `hc_thumbnail` - Small preview images
- `hc_card_image` - Medium card images

Customize at: `Administration » Configuration » Media » Image styles`

## Theme Integration

### idfive Component Library

Howard Content Types is designed to work with the idfive Component Library:

1. **Install the theme:**
   ```bash
   composer require idfive/idfive-component-library-d8-theme
   ```

2. **Enable the theme:**
   ```bash
   drush theme:enable idfive_component_library_d8_theme
   drush config:set system.theme default idfive_component_library_d8_theme
   ```

3. **Configure theme settings** via the admin interface

### Template Overrides

Create custom templates in your theme:

```
your_theme/
├── templates/
│   ├── content/
│   │   ├── node--hc-announcement.html.twig
│   │   ├── node--hc-article.html.twig
│   │   └── node--hc-page.html.twig
│   └── field/
│       ├── field--field-hc-header-image.html.twig
│       └── field--field-hc-body.html.twig
```

### CSS and JavaScript

The module provides admin-only CSS/JS. Site styling should come from your theme:

- **Admin styles:** `howard_content_types/admin` library
- **View styles:** `howard_content_types/view` library

## Troubleshooting

### Common Issues

#### Module Not Appearing
- Verify Composer installation completed successfully
- Check file permissions on the modules directory
- Clear all caches: `drush cr`

#### Missing Dependencies
```bash
# Check missing dependencies
drush pm:list --filter=entity_reference_revisions,focal_point,paragraphs

# Install missing modules
composer require drupal/entity_reference_revisions drupal/focal_point drupal/paragraphs
drush en entity_reference_revisions focal_point paragraphs
```

#### Configuration Import Issues
```bash
# Force configuration import
drush cim -y --partial --source=modules/contrib/howard_content_types/config/install/

# Import specific configuration
drush config:import --partial --source=modules/contrib/howard_content_types/config/install/
```

#### Field Update Problems
```bash
# Run database updates
drush updb -y

# Update entity definitions
drush entup -y

# Clear all caches
drush cr
```

### Debugging

Enable development modules for debugging:

```bash
# Install debugging tools
composer require --dev drupal/devel drupal/config_update

# Enable debug modules
drush en devel config_update
```

### Log Analysis

Check Drupal logs for errors:

```bash
# View recent log entries
drush watchdog:list --count=50

# Filter for content type issues
drush watchdog:list --filter=howard_content_types
```

## Security Considerations

### Permissions Setup

Configure proper permissions for content types:

1. **Navigate to:** `Administration » People » Permissions`

2. **Key permissions to configure:**
   - Create content permissions for each content type
   - Edit own/any content permissions
   - Delete permissions (typically restricted)
   - Administer content types (admin only)

3. **Recommended permission structure:**
   ```
   Content Creator Role:
   - Create HC Page content
   - Edit own HC Page content
   - Create HC Article content
   - Edit own HC Article content
   
   Content Manager Role:
   - Create any HC content
   - Edit any HC content
   - Delete HC content (with caution)
   
   Site Administrator Role:
   - Administer content types
   - All content permissions
   ```

### File Upload Security

Configure secure file uploads:

1. **Allowed file extensions:** Restrict to necessary types only
2. **File size limits:** Set appropriate maximum file sizes
3. **Upload directories:** Use secure, non-executable directories
4. **Virus scanning:** Consider integrating virus scanning for uploads

### Content Security

- **Input filtering:** Ensure proper text format configuration
- **Image handling:** Use secure image processing
- **User-generated content:** Implement moderation workflows
- **Cross-site scripting:** Validate all user inputs

## Performance Optimization

### Caching Configuration

Optimize caching for better performance:

```bash
# Enable page caching
drush config:set system.performance cache.page.max_age 3600

# Enable dynamic page cache
drush en dynamic_page_cache

# Configure BigPipe for faster rendering
drush en big_pipe
```

### Image Optimization

Configure image handling:

1. **Image styles:** Use appropriate image styles for different contexts
2. **Responsive images:** Enable responsive image module
3. **Image optimization:** Consider image optimization services
4. **Lazy loading:** Implement lazy loading for better performance

### Database Optimization

- Run database updates regularly: `drush updb`
- Monitor database performance
- Consider database indexing for custom queries
- Regular database maintenance

---

*For additional support, contact Howard University IT Services or refer to the [troubleshooting documentation](DEVELOPER.md#troubleshooting).*
