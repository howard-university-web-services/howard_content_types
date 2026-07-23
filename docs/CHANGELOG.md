# Changelog

All notable changes to the Howard Content Types module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [11.0.7] - 2026-07-23

### Fixed

- **`howard_content_types.info.yml`**: Removed duplicate `media` dependency entry — `drupal:media` was already declared; bare `media` was redundant.
- **`hc_person.info.yml`**: Corrected `views` dependency to `drupal:views` (Drupal core module requires the `drupal:` namespace prefix).
- **`hc_resources.info.yml`**: Corrected `views` dependency to `drupal:views` (same as above).

## [11.0.6] - 2026-02-16

### Fixed

- Minor maintenance updates and improvements

## [11.0.5] - 2026-02-16

### Removed

- Removed unused admin CSS library and associated styles
- Cleaned up howard_content_types.libraries.yml configuration

## [11.0.4] - 2025-12-05

### Fixed

- Fixed PHP warnings in howard_content_types_preprocess_node() function
- Added proper array validation before accessing field values to prevent "Undefined array key 0" and "Trying to access array offset on null" warnings
- Improved error handling for field_hc_hide_header_image field value checking

## [11.0.3] - 2025-07-08

### Changed

- Updated module metadata to reflect custom Packagist distribution
- Removed drupal.org-specific project information from info.yml
- Removed drupal.org-specific metadata from composer.json
- Updated version field handling to follow Packagist best practices

### Technical

- Prepared module for distribution via Packagist instead of drupal.org
- Cleaned up composer.json to follow Packagist recommendations
- Enhanced module identification as custom package

## [11.0.2] - 2025-07-07

### Added

- Comprehensive documentation structure with professional-grade docs
- Comprehensive documentation structure with professional-grade docs
- Developer guide with testing and debugging information
- API documentation with technical specifications
- Installation guide with detailed setup instructions
- Release checklist and coding standards documentation
- Enhanced code documentation and comments throughout all module files
- Professional README.md with features overview and quick start guide
- Complete composer.json with dependencies, scripts, and metadata

### Changed
- Enhanced code documentation and comments in howard_content_types.module
- Improved error handling and logging throughout the module
- Updated configuration schema validation
- Enhanced composer.json with professional structure and dependencies
- Updated module metadata in info.yml file

### Enhanced
- Module architecture documentation with comprehensive coverage
- Hook implementation documentation with detailed examples
- Field API documentation with creation and manipulation examples
- Media integration documentation with browser configuration
- Theming API documentation with template suggestions
- Configuration management documentation with override examples

### Security
- Enhanced input validation documentation
- Improved configuration security guidelines
- Added access control best practices
- Security considerations documented for all components

## [11.0.1] - Previous Release

### Added
- Initial release of Howard Content Types module suite
- Six specialized content types for Howard University
- Default configuration for content types and fields
- Entity browsers for media management
- Standard fields shared across content types
- Integration with idfive Component Library
- Media browser categories and taxonomies

### Features
- **HC Announcements**: University news and announcements content type
- **HC Article**: Long-form articles and stories content type
- **HC Page**: Standard informational pages content type
- **HC Person**: Faculty, staff, and student profiles content type
- **HC Resource**: Educational resources and materials content type
- **HC Standard Homepage**: Department and unit homepages content type

### Technical Details
- Modular architecture with separate sub-modules for each content type
- Configuration management with exportable configuration
- Hook-based customization system
- Theme integration designed for idfive Component Library
- Media integration with Entity Browser
- Field API integration with standard field definitions

### Content Management Features
- Hero image processing with focal point integration
- Header image visibility controls
- Media browser with pre-configured categories
- Form customizations for improved user experience
- Preview removal for streamlined workflow
- Configuration override support for site-specific customization

### Dependencies
- Drupal core 10.x or 11.x
- Entity Reference Revisions module
- Field modules (core)
- Media modules (core)
- Focal Point module
- Paragraphs module

### Configuration Requirements
- Default entity browsers for media management
- Image styles for responsive image handling
- Taxonomy vocabularies for media categorization
- Field configurations for content type consistency
- Display mode configurations for theming

### Theme Integration
- Designed for idfive Component Library integration
- Template suggestions for content type theming
- CSS/JS asset management for admin interfaces
- Markup-only approach for maximum theming flexibility

### Update System
- Database update hooks for field modifications
- Configuration update procedures
- Safe field removal processes
- Backwards compatibility considerations

---

*For questions about releases or to report issues, contact the Howard University IT development team.*
