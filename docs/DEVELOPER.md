# Developer Guide

This guide provides technical details for developers working on or extending the Howard Content Types module.

## Table of Contents

- [Development Environment Setup](#development-environment-setup)
- [Module Architecture](#module-architecture)
- [Content Type Development](#content-type-development)
- [Testing](#testing)
- [Debugging](#debugging)
- [Contributing](#contributing)
- [Code Standards](#code-standards)

## Development Environment Setup

### Prerequisites

- Drupal 10.x or 11.x development environment
- PHP 8.1+ with required extensions
- Composer for dependency management
- Git for version control
- Node.js and npm (for asset compilation if needed)

### Installation for Development

1. **Clone the repository:**
   ```bash
   git clone [repository-url]
   cd howard_content_types
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Enable the module:**
   ```bash
   drush en howard_content_types
   ```

4. **Enable sub-modules for testing:**
   ```bash
   drush en hc_page hc_article hc_person
   ```

## Module Architecture

### Core Components

```
howard_content_types/
├── howard_content_types.module      # Main module file with hooks
├── howard_content_types.install     # Installation and update hooks
├── howard_content_types.info.yml    # Module metadata
├── howard_content_types.libraries.yml # Asset libraries
├── config/install/                  # Default configuration
├── assets/                          # CSS/JS for admin interfaces
└── modules/                         # Sub-modules for content types
```

### Content Type Sub-Modules

Each content type is implemented as a separate sub-module:

```
modules/hc_page/
├── hc_page.info.yml                 # Sub-module metadata
├── config/install/                  # Content type configuration
│   ├── node.type.hc_page.yml       # Content type definition
│   ├── field.field.*.yml           # Field configurations
│   └── core.entity_view_display.*.yml # Display configurations
```

### Key Design Patterns

1. **Modular Architecture**: Each content type is a separate sub-module
2. **Configuration Management**: All settings stored in exportable config
3. **Hook-based Extensions**: Uses Drupal's hook system for customization
4. **Theme Integration**: Designed for idfive Component Library
5. **Media Integration**: Entity browsers for consistent media handling

## Content Type Development

### Creating a New Content Type Sub-Module

1. **Create sub-module directory:**
   ```bash
   mkdir modules/hc_newtype
   cd modules/hc_newtype
   ```

2. **Create info file (`hc_newtype.info.yml`):**
   ```yaml
   name: HC New Type
   type: module
   description: A new content type for Howard University.
   version: '11.0.2'
   core_version_requirement: ^10 || ^11
   package: Howard University
   dependencies:
     - howard_content_types
   ```

3. **Create config directory structure:**
   ```bash
   mkdir -p config/install
   ```

4. **Define content type (`config/install/node.type.hc_newtype.yml`):**
   ```yaml
   langcode: en
   status: true
   dependencies: {}
   name: 'HC New Type'
   type: hc_newtype
   description: 'Description of the new content type.'
   help: ''
   new_revision: true
   preview_mode: 1
   display_submitted: false
   ```

### Adding Fields to Content Types

1. **Create field storage (`config/install/field.storage.node.field_hc_custom.yml`):**
   ```yaml
   langcode: en
   status: true
   dependencies:
     module:
       - node
   id: node.field_hc_custom
   field_name: field_hc_custom
   entity_type: node
   type: string
   settings:
     max_length: 255
     is_ascii: false
     case_sensitive: false
   module: core
   locked: false
   cardinality: 1
   translatable: true
   indexes: {}
   persist_with_no_fields: false
   custom_storage: false
   ```

2. **Create field instance (`config/install/field.field.node.hc_newtype.field_hc_custom.yml`):**
   ```yaml
   langcode: en
   status: true
   dependencies:
     config:
       - field.storage.node.field_hc_custom
       - node.type.hc_newtype
   id: node.hc_newtype.field_hc_custom
   field_name: field_hc_custom
   entity_type: node
   bundle: hc_newtype
   label: 'Custom Field'
   description: 'A custom field for this content type.'
   required: false
   translatable: true
   default_value: []
   default_value_callback: ''
   settings: {}
   field_type: string
   ```

### Configuring Display Modes

1. **Form display (`config/install/core.entity_form_display.node.hc_newtype.default.yml`):**
   ```yaml
   langcode: en
   status: true
   dependencies:
     config:
       - field.field.node.hc_newtype.field_hc_custom
       - node.type.hc_newtype
     module:
       - path
   id: node.hc_newtype.default
   targetEntityType: node
   bundle: hc_newtype
   mode: default
   content:
     field_hc_custom:
       type: string_textfield
       weight: 1
       region: content
       settings:
         size: 60
         placeholder: ''
       third_party_settings: {}
   hidden: {}
   ```

## Testing

### Manual Testing

1. **Content Type Creation:**
   - Enable sub-module
   - Verify content type appears in admin
   - Test content creation form
   - Verify field functionality

2. **Display Testing:**
   - Test different view modes
   - Verify theming integration
   - Check responsive behavior
   - Test media integration

3. **Configuration Testing:**
   - Export/import configuration
   - Test configuration overrides
   - Verify update hooks

### Automated Testing

Create unit tests for custom functionality:

```php
/**
 * Tests for Howard Content Types.
 *
 * @group howard_content_types
 */
class HowardContentTypesTest extends KernelTestBase {
  
  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'howard_content_types',
    'hc_page',
    'node',
    'field',
    'system',
  ];
  
  /**
   * Test content type creation.
   */
  public function testContentTypeCreation() {
    $this->installConfig(['hc_page']);
    
    $content_type = NodeType::load('hc_page');
    $this->assertNotNull($content_type);
    $this->assertEquals('HC Basic Page', $content_type->label());
  }
}
```

### Integration Testing

Test with actual Drupal site:

```bash
# Create test content
drush generate:content --content-types=hc_page 10

# Test configuration export
drush config:export

# Test configuration import
drush config:import
```

## Debugging

### Enable Debug Mode

Add to `settings.local.php`:

```php
$config['system.logging']['error_level'] = 'verbose';
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
```

### Common Debug Points

1. **Hook Implementation:**
   ```php
   function howard_content_types_preprocess_node(&$variables) {
     // Debug node variables
     \Drupal::logger('howard_content_types')
       ->debug('Node variables: @vars', ['@vars' => print_r($variables, TRUE)]);
   }
   ```

2. **Field Value Debugging:**
   ```php
   if ($node->hasField('field_hc_header_image')) {
     $field_value = $node->get('field_hc_header_image')->getValue();
     \Drupal::logger('howard_content_types')
       ->debug('Field value: @value', ['@value' => print_r($field_value, TRUE)]);
   }
   ```

3. **Configuration Debugging:**
   ```php
   $config = \Drupal::config('node.type.hc_page');
   \Drupal::logger('howard_content_types')
     ->debug('Config: @config', ['@config' => print_r($config->getRawData(), TRUE)]);
   ```

### Troubleshooting Tools

- **Devel module** for debugging variables
- **Config Inspector** for configuration issues
- **Webprofiler** for performance analysis
- **XDebug** for step-through debugging

## Contributing

### Development Workflow

1. **Create feature branch:**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make changes following coding standards**

3. **Add/update configuration as needed**

4. **Test changes thoroughly**

5. **Update documentation**

6. **Submit pull request**

### Code Review Checklist

- [ ] Follows Drupal coding standards
- [ ] Includes appropriate configuration
- [ ] Has been tested manually
- [ ] Updates documentation
- [ ] Handles errors gracefully
- [ ] Follows module conventions

### Configuration Management

When adding new configuration:

1. **Export configuration:**
   ```bash
   drush config:export --destination=modules/contrib/howard_content_types/config/install/
   ```

2. **Review exported files:**
   - Remove site-specific UUIDs
   - Clean up unnecessary dependencies
   - Verify configuration structure

3. **Test configuration import:**
   ```bash
   drush config:import --partial --source=modules/contrib/howard_content_types/config/install/
   ```

## Code Standards

### Drupal Standards

Follow [Drupal Coding Standards](https://www.drupal.org/docs/develop/standards):

- Use proper indentation (2 spaces)
- Follow naming conventions
- Include comprehensive documentation
- Use proper error handling

### Module-Specific Standards

#### File Naming
- Content types: `hc_` prefix (e.g., `hc_page`)
- Fields: `field_hc_` prefix (e.g., `field_hc_header_image`)
- Configuration files: Follow Drupal conventions

#### Documentation Standards
```php
/**
 * Implements hook_preprocess_node().
 *
 * Adds hero image processing for Howard content types.
 */
function howard_content_types_preprocess_node(&$variables) {
  // Implementation with clear comments
}
```

#### Configuration Standards
```yaml
# Clear, descriptive labels
name: 'HC Basic Page'
description: 'A basic page content type for Howard University sites.'

# Consistent field naming
field_name: field_hc_header_image
label: 'Header Image'
```

### Quality Assurance

#### Code Quality Tools
```bash
# PHP CodeSniffer
phpcs --standard=Drupal,DrupalPractice modules/contrib/howard_content_types/

# PHP Code Beautifier
phpcbf --standard=Drupal modules/contrib/howard_content_types/
```

#### Configuration Validation
```bash
# Validate configuration syntax
drush config:validate

# Check for configuration errors
drush config:status
```

## Performance Considerations

### Configuration Loading
- Minimize configuration dependencies
- Use lazy loading where possible
- Cache configuration when appropriate

### Field Processing
- Optimize field value processing in hooks
- Use entity query for bulk operations
- Consider field caching strategies

### Media Handling
- Optimize image style generation
- Use responsive images appropriately
- Consider CDN integration for media

## Security Considerations

### Input Validation
- Validate all user inputs in form alters
- Sanitize field values in preprocessing
- Use proper text formats for rich content

### Access Control
- Implement proper permission checks
- Validate user access in custom hooks
- Follow principle of least privilege

### Configuration Security
- Avoid storing sensitive data in configuration
- Use environment variables for site-specific settings
- Regularly audit configuration exports

---

*For additional development support, contact the Howard University IT development team.*
