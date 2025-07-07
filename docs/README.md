# Howard Content Types Documentation

Welcome to the comprehensive documentation for the Howard Content Types module. This module provides a suite of content types and initial configuration specifically designed for Howard University Drupal projects.

## Table of Contents

### Getting Started
- [Installation Guide](INSTALL.md) - Complete setup and configuration instructions
- [Quick Start](#quick-start) - Get up and running quickly
- [Module Overview](#module-overview) - Understanding what this module provides

### Technical Documentation
- [API Documentation](API.md) - Technical specifications and integration details
- [Developer Guide](DEVELOPER.md) - Development setup, testing, and contributions
- [Coding Standards](CODING_STANDARDS.md) - Code quality and style guidelines

### Maintenance & Releases
- [Changelog](CHANGELOG.md) - Version history and release notes
- [Release Checklist](RELEASE_CHECKLIST.md) - Quality assurance procedures

## Quick Start

1. **Install the module:**
   ```bash
   composer require howard/howard_content_types
   drush en howard_content_types
   ```

2. **Enable sub-modules as needed:**
   ```bash
   drush en hc_announcements hc_article hc_page hc_person hc_resource hc_standard_homepage
   ```

3. **Configure content types** via the Drupal admin interface

4. **Start creating content** using the Howard-specific content types

## Module Overview

### What is Howard Content Types?

The Howard Content Types module is a comprehensive suite of content types designed specifically for Howard University's digital presence. It provides:

- **Six specialized content types** for different types of university content
- **Default configuration** that can be customized per site
- **Entity browsers** for media management
- **Standard fields** used across sub-modules
- **Theming integration** with the idfive Component Library

### Content Types Included

| Content Type | Module | Purpose |
|--------------|--------|---------|
| **HC Announcement** | `hc_announcements` | University announcements and news |
| **HC Article** | `hc_article` | Long-form articles and stories |
| **HC Basic Page** | `hc_page` | Standard informational pages |
| **HC Person** | `hc_person` | Faculty, staff, and student profiles |
| **HC Resource** | `hc_resource` | Educational resources and materials |
| **HC Standard Homepage** | `hc_standard_homepage` | Department and unit homepages |

### Key Features

#### 🎨 **Theming Integration**
- Built to work with the [idfive Component Library](https://bitbucket.org/idfivellc/idfive-component-library)
- No CSS or JavaScript included (provided by theme)
- Markup-only approach for maximum flexibility

#### 📁 **Media Management**
- Default entity browsers for consistent media handling
- Pre-configured media categories and taxonomies
- Focal point integration for responsive images

#### ⚙️ **Configuration Flexibility**
- Config can be overridden locally per site
- Starter configuration provided on install
- Support for partial configuration imports

#### 🔧 **Standard Fields**
- Common fields shared across content types
- Consistent field naming conventions
- Reusable field configurations

### Architecture

The module follows Drupal best practices with:

- **Modular design** - Each content type is a separate sub-module
- **Configuration management** - All settings stored in exportable config
- **Hook system** - Proper implementation of Drupal hooks
- **Update system** - Database updates for field changes
- **Dependency management** - Clear module dependencies

### Sub-Module Structure

```
howard_content_types/
├── modules/
│   ├── hc_announcements/     # Announcements content type
│   ├── hc_article/           # Article content type
│   ├── hc_page/              # Basic page content type
│   ├── hc_person/            # Person profile content type
│   ├── hc_resource/          # Resource content type
│   └── hc_standard_homepage/ # Homepage content type
├── config/install/           # Default configuration
├── assets/                   # CSS/JS for admin interfaces
└── docs/                     # This documentation
```

## Integration

### Theme Requirements
This module is designed to work with:
- [idfive Component Library](https://bitbucket.org/idfivellc/idfive-component-library)
- [idfive Component Library D8 Theme](https://bitbucket.org/idfivellc/idfive-component-library-d8-theme)

### Dependencies
- Drupal Core 10.x or 11.x
- Entity Reference Revisions
- Field modules (core)
- Media modules (core)
- Paragraphs module
- Focal Point module

## Support

### Getting Help
- **Documentation:** Check this docs directory for comprehensive guides
- **Issues:** Report bugs and feature requests through the project repository
- **Community:** Join Howard University's developer community discussions

### Professional Support
For enterprise support and custom development:
- Contact Howard University IT Services
- Professional consulting available through approved vendors

## Contributing

We welcome contributions! Please see our [Developer Guide](DEVELOPER.md) for:
- Development environment setup
- Coding standards and guidelines
- Testing requirements
- Submission process

## License

This project is licensed under the GNU General Public License v2.0 or later - see the [LICENSE](../LICENSE) file for details.

---

**Howard University | Information Technology Services**  
*Empowering education through innovative technology solutions*
