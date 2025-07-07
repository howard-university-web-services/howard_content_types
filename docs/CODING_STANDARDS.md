# Coding Standards

This document outlines the coding standards and best practices for the Howard Content Types module.

## Table of Contents

- [Overview](#overview)
- [General Standards](#general-standards)
- [PHP Standards](#php-standards)
- [Drupal Standards](#drupal-standards)
- [Documentation Standards](#documentation-standards)
- [Configuration Standards](#configuration-standards)
- [Testing Standards](#testing-standards)
- [Security Standards](#security-standards)
- [Performance Standards](#performance-standards)
- [Accessibility Standards](#accessibility-standards)
- [Code Review Guidelines](#code-review-guidelines)

## Overview

The Howard Content Types module follows strict coding standards to ensure:
- Code quality and maintainability
- Consistency across all sub-modules
- Security and performance best practices
- Accessibility compliance
- Proper documentation and testing

## General Standards

### File Organization
- Use consistent directory structure across sub-modules
- Place related files in appropriate subdirectories
- Follow Drupal's file naming conventions
- Keep configuration files organized and well-documented

### Naming Conventions
- Use descriptive, self-documenting names
- Follow snake_case for variables and functions
- Use PascalCase for classes and interfaces
- Prefix all module-specific functions with module name

### Code Structure
- Keep functions and methods focused and concise
- Use meaningful variable names
- Avoid deep nesting (max 3-4 levels)
- Implement proper error handling

## PHP Standards

### PSR Standards
Follow PSR-4 autoloading and PSR-12 coding style:

```php
<?php

declare(strict_types=1);

namespace Drupal\howard_content_types\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type for custom content.
 *
 * @FieldType(
 *   id = "howard_custom_field",
 *   label = @Translation("Howard Custom Field"),
 *   description = @Translation("A custom field for Howard content types."),
 *   default_widget = "howard_custom_widget",
 *   default_formatter = "howard_custom_formatter"
 * )
 */
class HowardCustomField extends FieldItemBase {
  // Implementation here
}
```

### Type Declarations
- Use strict types: `declare(strict_types=1);`
- Add parameter and return type hints
- Use nullable types when appropriate: `?string`

### Error Handling
```php
try {
  $result = $this->processContent($content);
} catch (InvalidArgumentException $e) {
  $this->logger('howard_content_types')->error('Invalid content: @message', [
    '@message' => $e->getMessage(),
  ]);
  throw new ContentProcessingException('Content processing failed', 0, $e);
}
```

## Drupal Standards

### Module Structure
Follow Drupal 9/10 module structure:
```
module_name/
├── config/
│   ├── install/
│   └── schema/
├── src/
│   ├── Plugin/
│   ├── Controller/
│   └── Form/
├── templates/
├── tests/
└── assets/
```

### Hooks Implementation
```php
/**
 * Implements hook_entity_type_alter().
 */
function howard_content_types_entity_type_alter(array &$entity_types) {
  // Alter entity types with proper documentation
  if (isset($entity_types['node'])) {
    $entity_types['node']->setHandlerClass('access', AccessControlHandler::class);
  }
}
```

### Plugin Development
```php
/**
 * Provides a block for displaying content.
 *
 * @Block(
 *   id = "howard_content_block",
 *   admin_label = @Translation("Howard Content Block"),
 *   category = @Translation("Howard Content Types")
 * )
 */
class HowardContentBlock extends BlockBase implements ContainerFactoryPluginInterface {
  // Proper dependency injection and implementation
}
```

### Configuration Management
- Use configuration schemas for all settings
- Provide default configurations
- Implement proper configuration validation
- Use configuration dependencies correctly

## Documentation Standards

### File Headers
All PHP files must include proper headers:
```php
<?php

/**
 * @file
 * Contains functionality for Howard content type management.
 *
 * This file provides core functionality for managing custom content types
 * within the Howard University website ecosystem.
 *
 * @package Drupal\howard_content_types
 * @author Howard University Web Team
 * @copyright 2024 Howard University
 * @license GPL-2.0-or-later
 */

declare(strict_types=1);
```

### Class Documentation
```php
/**
 * Manages content type operations and integrations.
 *
 * This class provides a centralized interface for managing content types,
 * including creation, validation, and integration with other systems.
 *
 * @package Drupal\howard_content_types
 * @since 1.0.0
 */
class ContentTypeManager {
  // Implementation
}
```

### Method Documentation
```php
/**
 * Processes content for display rendering.
 *
 * Takes raw content data and processes it according to the specified
 * display mode and security requirements.
 *
 * @param array $content
 *   The raw content data to process.
 * @param string $display_mode
 *   The display mode for rendering.
 * @param array $options
 *   Additional processing options.
 *
 * @return array
 *   The processed content ready for rendering.
 *
 * @throws \InvalidArgumentException
 *   When content data is invalid.
 * @throws \Drupal\howard_content_types\Exception\ProcessingException
 *   When processing fails.
 *
 * @since 1.0.0
 */
public function processContent(array $content, string $display_mode, array $options = []): array {
  // Implementation
}
```

## Configuration Standards

### Schema Definition
```yaml
# config/schema/howard_content_types.schema.yml
howard_content_types.settings:
  type: config_object
  label: 'Howard Content Types settings'
  mapping:
    enable_caching:
      type: boolean
      label: 'Enable content caching'
    cache_lifetime:
      type: integer
      label: 'Cache lifetime in seconds'
    allowed_content_types:
      type: sequence
      label: 'Allowed content types'
      sequence:
        type: string
        label: 'Content type machine name'
```

### Default Configuration
```yaml
# config/install/howard_content_types.settings.yml
enable_caching: true
cache_lifetime: 3600
allowed_content_types:
  - article
  - page
  - announcement
```

## Testing Standards

### Unit Tests
```php
/**
 * @coversDefaultClass \Drupal\howard_content_types\ContentTypeManager
 * @group howard_content_types
 */
class ContentTypeManagerTest extends UnitTestCase {

  /**
   * Tests content processing with valid data.
   *
   * @covers ::processContent
   */
  public function testProcessContentWithValidData() {
    // Test implementation
  }
}
```

### Functional Tests
```php
/**
 * Tests content type functionality.
 *
 * @group howard_content_types
 */
class ContentTypeFunctionalTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['howard_content_types', 'node', 'field_ui'];

  /**
   * Tests content type creation workflow.
   */
  public function testContentTypeCreation() {
    // Test implementation
  }
}
```

## Security Standards

### Input Validation
```php
// Always validate and sanitize input
$title = Html::escape($input['title']);
$description = Xss::filter($input['description'], ['em', 'strong', 'a']);

// Use dependency injection for services
public function __construct(
  private readonly EntityTypeManagerInterface $entityTypeManager,
  private readonly LoggerInterface $logger
) {}
```

### Access Control
```php
/**
 * Checks access for content operations.
 */
public function access(AccountInterface $account, $operation = 'view') {
  return AccessResult::allowedIfHasPermission($account, "administer {$this->getPluginId()} content");
}
```

### Data Protection
- Never store sensitive data in configuration
- Use proper encryption for sensitive information
- Implement CSRF protection for forms
- Validate file uploads thoroughly

## Performance Standards

### Caching
```php
// Use proper cache contexts and tags
$build['#cache'] = [
  'contexts' => ['user.permissions', 'route'],
  'tags' => ['node_list', 'config:howard_content_types.settings'],
  'max-age' => 3600,
];
```

### Database Queries
```php
// Use entity queries instead of direct database access
$query = $this->entityTypeManager
  ->getStorage('node')
  ->getQuery()
  ->condition('type', 'article')
  ->condition('status', 1)
  ->sort('created', 'DESC')
  ->range(0, 10)
  ->accessCheck(TRUE);

$nids = $query->execute();
```

### Asset Loading
- Use libraries.yml for CSS/JS
- Implement lazy loading where appropriate
- Optimize images and assets
- Use CDN for external resources

## Accessibility Standards

### Semantic HTML
```php
// Use proper semantic elements
$build['content'] = [
  '#type' => 'html_tag',
  '#tag' => 'article',
  '#attributes' => [
    'class' => ['content-article'],
    'role' => 'article',
  ],
  '#value' => $content,
];
```

### ARIA Support
```php
// Implement proper ARIA attributes
$build['navigation'] = [
  '#type' => 'html_tag',
  '#tag' => 'nav',
  '#attributes' => [
    'aria-label' => $this->t('Content navigation'),
    'role' => 'navigation',
  ],
];
```

### Keyboard Navigation
- Ensure all interactive elements are keyboard accessible
- Implement proper focus management
- Use logical tab order
- Provide skip links where appropriate

## Code Review Guidelines

### Review Checklist
- [ ] Code follows PSR-12 and Drupal standards
- [ ] All functions and classes are documented
- [ ] Security best practices are followed
- [ ] Performance considerations are addressed
- [ ] Accessibility requirements are met
- [ ] Tests are included and passing
- [ ] Configuration schema is provided
- [ ] Error handling is implemented
- [ ] Code is maintainable and readable

### Review Process
1. Automated testing (PHPStan, PHPCS, PHPUnit)
2. Manual code review by team lead
3. Security review for sensitive changes
4. Performance testing for critical paths
5. Accessibility audit for UI changes

## Tools and Automation

### Code Quality Tools
```bash
# PHP CodeSniffer
./vendor/bin/phpcs --standard=Drupal,DrupalPractice web/modules/custom/howard_content_types/

# PHPStan
./vendor/bin/phpstan analyse web/modules/custom/howard_content_types/

# PHP Unit
./vendor/bin/phpunit web/modules/custom/howard_content_types/tests/
```

### Pre-commit Hooks
Set up Git hooks to enforce standards:
- Run code sniffers
- Execute unit tests
- Validate configuration schemas
- Check documentation completeness

## Conclusion

Following these coding standards ensures that the Howard Content Types module maintains high quality, security, and maintainability. All contributors must adhere to these guidelines, and regular reviews should be conducted to ensure compliance.

For questions or clarifications about these standards, please consult the [Developer Documentation](DEVELOPER.md) or contact the development team.
