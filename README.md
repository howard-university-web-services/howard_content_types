# Howard Content Types

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![Drupal](https://img.shields.io/badge/Drupal-9%2B-blue.svg)](https://www.drupal.org)

A comprehensive content type management suite for Howard University Drupal installations, providing structured content types, media management, and seamless integration with the idfive Component Library.

## Overview

The Howard Content Types module provides a professional content management foundation for Howard University websites. This module suite delivers standardized content types, fields, and configurations that ensure consistency across all university web properties while maintaining flexibility for site-specific customizations.

### Key Features

- **Structured Content Types**: Six specialized content types designed for university content
- **Media Integration**: Pre-configured entity browsers and media field management
- **Component Library Ready**: Seamless integration with idfive Component Library
- **Flexible Configuration**: Override-friendly design for site-specific needs
- **Security Focused**: Built with university security requirements in mind
- **Accessibility Compliant**: WCAG 2.1 AA standards compliance

## Quick Start

### Requirements

- Drupal 9.4+ or Drupal 10.x
- PHP 8.1+
- Composer 2.x

### Installation

```bash
# Install via Composer
composer require howard/howard_content_types

# Enable the module
drush en howard_content_types -y

# Enable specific sub-modules as needed
drush en hc_article hc_page hc_person -y
```

### Configuration

1. Navigate to **Administration > Extend** and enable desired sub-modules
2. Configure content types at **Administration > Structure > Content types**
3. Set up media browsers at **Administration > Structure > Entity browsers**
4. Review field configurations and customize as needed

## Content Types

### Available Sub-modules

| Module | Content Type | Description |
|--------|--------------|-------------|
| **hc_announcements** | HC Announcement | University announcements and news updates |
| **hc_article** | HC Article | News articles and editorial content |
| **hc_page** | HC Basic Page | Standard web pages and landing pages |
| **hc_person** | HC Person | Faculty, staff, and student profiles |
| **hc_resource** | HC Resource | Educational resources and downloads |
| **hc_standard_homepage** | HC Standard Homepage | Structured homepage layouts |

### Theme Integration

This module provides markup structure without styling. Styles are provided through:

- [idfive Component Library](https://bitbucket.org/idfivellc/idfive-component-library)
- [idfive Component Library D8 Theme](https://bitbucket.org/idfivellc/idfive-component-library-d8-theme)

## Documentation

### Complete Documentation

- 📚 [Full Documentation](docs/README.md)
- ⚙️ [Installation Guide](docs/INSTALL.md)
- 🔧 [API Reference](docs/API.md)
- 👨‍💻 [Developer Guide](docs/DEVELOPER.md)
- 📋 [Changelog](docs/CHANGELOG.md)

### Quick Links

- [Configuration Override Guide](docs/INSTALL.md#configuration-management)
- [Theming and Customization](docs/DEVELOPER.md#theming-development)
- [Security Considerations](docs/INSTALL.md#security-considerations)
- [Troubleshooting](docs/INSTALL.md#troubleshooting)

## Architecture

### Design Principles

- **Modular Architecture**: Each content type is a separate sub-module
- **Configuration Management**: Site-specific overrides supported
- **Security First**: Input validation and access controls
- **Performance Optimized**: Efficient caching and query optimization
- **Extensible**: Hook system for custom functionality

### Integration Points

- **Media Management**: Entity browsers for consistent media handling
- **Field API**: Reusable field configurations across content types
- **Views Integration**: Pre-configured listing and display views
- **Search API**: Full-text search capabilities
- **Workflow**: Content moderation and publishing workflows

## Contributing

We welcome contributions from the Howard University community and beyond.

### Development Setup

```bash
# Clone the repository
git clone https://github.com/howard-university/howard_content_types.git

# Set up development environment
composer install
npm install

# Run tests
composer test
```

### Guidelines

- Follow [Drupal Coding Standards](https://www.drupal.org/docs/develop/standards)
- Review our [Coding Standards](docs/CODING_STANDARDS.md)
- Use the [Release Checklist](docs/RELEASE_CHECKLIST.md) for releases
- Submit pull requests with comprehensive tests

## Support

### Getting Help

- 📖 [Documentation](docs/README.md)
- 🐛 [Issue Tracker](https://github.com/howard-university/howard_content_types/issues)
- 💬 [Community Forum](https://www.drupal.org/project/howard_content_types)
- 📧 Email: web-support@howard.edu

### Reporting Issues

Please use our issue tracker and include:
- Drupal version
- Module version
- Steps to reproduce
- Expected vs actual behavior
- Error messages or logs

## License

This project is licensed under the GNU General Public License v2.0 or later - see the [LICENSE](LICENSE) file for details.

## Credits

### Maintainers

- Howard University Web Team
- idfive Development Team

### Contributors

- [View all contributors](https://github.com/howard-university/howard_content_types/graphs/contributors)

### Acknowledgments

- Howard University IT Services
- Drupal Community
- idfive Component Library Team

---

**Howard University** | Building Excellence in Web Content Management
