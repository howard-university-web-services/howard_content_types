# API Documentation

This document provides technical API reference and integration details for the Howard Content Types module.

## Table of Contents

- [Module Architecture](#module-architecture)
- [Content Type APIs](#content-type-apis)
- [Hook Implementations](#hook-implementations)
- [Field APIs](#field-apis)
- [Media Integration](#media-integration)
- [Theming APIs](#theming-apis)
- [Configuration APIs](#configuration-apis)
- [Update APIs](#update-apis)
- [Extension Points](#extension-points)

## Module Architecture

### Module Structure

The Howard Content Types module follows a modular architecture:

```
howard_content_types/
├── howard_content_types.module          # Main module file
├── howard_content_types.install         # Installation hooks
├── howard_content_types.info.yml        # Module metadata
├── howard_content_types.libraries.yml   # Asset libraries
├── config/install/                      # Default configuration
├── assets/                              # CSS/JS assets
└── modules/                             # Sub-modules
    ├── hc_announcements/
    ├── hc_article/
    ├── hc_page/
    ├── hc_person/
    ├── hc_resource/
    └── hc_standard_homepage/
```

### Dependencies

**Core Dependencies:**
- `field` - Field API
- `file` - File handling
- `filter` - Text filtering
- `image` - Image processing
- `link` - Link fields
- `media` - Media management
- `options` - Select lists
- `system` - Core system
- `text` - Text fields

**Contributed Dependencies:**
- `entity_reference_revisions` - Advanced entity references
- `focal_point` - Image focal point selection
- `paragraphs` - Structured content blocks

## Content Type APIs

### Content Type Registration

Each sub-module registers its content type via configuration files:

```yaml
# Example: config/install/node.type.hc_page.yml
langcode: en
status: true
dependencies: {}
name: 'HC Basic Page'
type: hc_page
description: 'A basic page content type for Howard University sites.'
help: ''
new_revision: true
preview_mode: 1
display_submitted: false
```

### Content Type Machine Names

| Content Type | Machine Name | Module |
|--------------|--------------|--------|
| HC Announcement | `hc_announcement` | `hc_announcements` |
| HC Article | `hc_article` | `hc_article` |
| HC Basic Page | `hc_page` | `hc_page` |
| HC Person | `hc_person` | `hc_person` |
| HC Resource | `hc_resource` | `hc_resource` |
| HC Standard Homepage | `hc_standard_homepage` | `hc_standard_homepage` |

### Content Type Loading

```php
// Load a content type configuration
$content_type = \Drupal::entityTypeManager()
  ->getStorage('node_type')
  ->load('hc_page');

// Check if content type exists
if ($content_type) {
  $label = $content_type->label();
  $description = $content_type->getDescription();
}
```

## Hook Implementations

### hook_help()

Provides module help documentation:

```php
/**
 * Implements hook_help().
 */
function howard_content_types_help($route_name, RouteMatchInterface $route_match) {
  switch ($route_name) {
    case 'help.page.howard_content_types':
      // Returns README.md content with optional Markdown processing
      $text = file_get_contents(dirname(__FILE__) . "/README.md");
      
      if (!\Drupal::moduleHandler()->moduleExists('markdown')) {
        return '<pre>' . $text . '</pre>';
      }
      else {
        $filter_manager = \Drupal::service('plugin.manager.filter');
        $settings = \Drupal::configFactory()->get('markdown.settings')->getRawData();
        $config = ['settings' => $settings];
        $filter = $filter_manager->createInstance('markdown', $config);
        return $filter->process($text, 'en');
      }
  }
  return NULL;
}
```

### hook_preprocess_node()

Processes node variables for theming:

```php
/**
 * Implements hook_preprocess_node().
 */
function howard_content_types_preprocess_node(&$variables) {
  $node = $variables['elements']['#node'];
  $view_mode = $variables['view_mode'];
  $bundle = $node->bundle();

  // Hero image processing
  $variables['hero_image'] = '/themes/contrib/hu_general/idfive-component-library/build/img/graduates_talking.jpg';
  
  if ($node->hasField('field_hc_header_image')) {
    $hero_image = $node->get('field_hc_header_image')->getValue();
    if ($hero_image && !empty($hero_image)) {
      $entity = Media::load($hero_image[0]['target_id']);
      if (isset($entity) && $entity->field_media_image->entity !== NULL) {
        $variables['hero_image'] = ImageStyle::load('hc_hero_image')
          ->buildUrl($entity->field_media_image->entity->getFileUri());
      }
    }
  }

  // Hero image visibility control
  $variables['show_hero_image'] = TRUE;
  if ($node->hasField('field_hc_hide_header_image')) {
    $value = $node->get('field_hc_hide_header_image')->getValue();
    if ($value[0]['value'] == '1') {
      $variables['show_hero_image'] = FALSE;
    }
  }
}
```

### hook_preprocess_views_view()

Processes views for media browsers:

```php
/**
 * Implements hook_preprocess_views_view().
 */
function howard_content_types_preprocess_views_view(&$variables) {
  if ($variables['view']->id() === 'hc_media_browser' || 
      $variables['view']->id() === 'media_entity_browser') {
    $variables['view_array']['#attached']['library'][] = 'howard_content_types/view';
  }
}
```

### hook_form_alter()

Modifies content forms:

```php
/**
 * Implements hook_form_alter().
 */
function howard_content_types_form_alter(&$form, FormStateInterface $form_state, $form_id) {
  // Add admin library to all forms
  $form['#attached']['library'][] = 'howard_content_types/admin';
  
  // Remove preview from all forms
  $form['actions']['preview']['#access'] = FALSE;
  
  // Howard content type specific modifications
  if (preg_match('/node_hc_/', $form_id)) {
    if (isset($form['promote'])) {
      unset($form['promote']);
    }
  }
}
```

## Field APIs

### Standard Fields

The module provides common fields across content types:

#### Header Image Field
```yaml
field_name: field_hc_header_image
type: entity_reference
target_type: media
target_bundles: ['image']
settings:
  handler: 'default:media'
  handler_settings:
    target_bundles: ['image']
```

#### Hide Header Image Field
```yaml
field_name: field_hc_hide_header_image
type: boolean
settings:
  on_label: 'Yes'
  off_label: 'No'
default_value: false
```

### Field Loading and Manipulation

```php
// Load field configuration
$field_config = \Drupal::entityTypeManager()
  ->getStorage('field_config')
  ->load('node.hc_page.field_hc_header_image');

// Get field value from node
$node = \Drupal::entityTypeManager()
  ->getStorage('node')
  ->load($nid);

if ($node->hasField('field_hc_header_image')) {
  $header_image = $node->get('field_hc_header_image')->entity;
  if ($header_image) {
    $image_url = $header_image->field_media_image->entity->getFileUri();
  }
}
```

### Field Creation API

```php
// Create field storage
$field_storage = FieldStorageConfig::create([
  'field_name' => 'field_hc_custom_field',
  'entity_type' => 'node',
  'type' => 'string',
  'cardinality' => 1,
]);
$field_storage->save();

// Create field instance
$field = FieldConfig::create([
  'field_storage' => $field_storage,
  'bundle' => 'hc_page',
  'label' => 'Custom Field',
  'required' => FALSE,
]);
$field->save();
```

## Media Integration

### Media Browser Integration

The module integrates with Entity Browser for media management:

```php
// Media browser configuration
$browser_config = [
  'target_type' => 'media',
  'selection_handler' => 'default:media',
  'selection_handler_settings' => [
    'target_bundles' => ['image'],
    'sort' => ['field' => 'created', 'direction' => 'DESC'],
  ],
];
```

### Media Categories

Default media categories created during installation:

```php
/**
 * Creates stock media browser terms.
 */
function _howard_content_types_create_media_browser_terms() {
  $categories = [
    'Students',
    'Alumni',
    'Faculty & Staff',
    'Events',
    'Campus Landmarks',
    'University Figures',
    'Campus Life',
    'Athletics',
    'Academic Programs',
    'Research',
  ];

  foreach ($categories as $category) {
    $term = Term::create([
      'name' => $category,
      'vid' => 'hc_media_browser_categories',
    ]);
    $term->save();
  }
}
```

### Image Style API

```php
// Load and use image styles
$image_style = ImageStyle::load('hc_hero_image');
$styled_image_url = $image_style->buildUrl($original_image_uri);

// Available image styles
$image_styles = [
  'hc_hero_image' => 'Large hero/header images',
  'hc_thumbnail' => 'Small thumbnail images',
  'hc_card_image' => 'Medium card-sized images',
];
```

## Theming APIs

### Template Suggestions

The module provides template suggestions for content types:

```php
// Template suggestions for nodes
function howard_content_types_theme_suggestions_node_alter(array &$suggestions, array $variables) {
  $node = $variables['elements']['#node'];
  $sanitized_view_mode = strtr($variables['elements']['#view_mode'], '.', '_');
  
  // Add content type specific suggestions
  if (strpos($node->bundle(), 'hc_') === 0) {
    $suggestions[] = 'node__' . $node->bundle() . '__' . $sanitized_view_mode;
  }
}
```

### Available Templates

Content type templates to override in themes:

```
templates/content/
├── node--hc-announcement.html.twig
├── node--hc-announcement--teaser.html.twig
├── node--hc-article.html.twig
├── node--hc-article--teaser.html.twig
├── node--hc-page.html.twig
├── node--hc-person.html.twig
├── node--hc-person--card.html.twig
├── node--hc-resource.html.twig
└── node--hc-standard-homepage.html.twig
```

### Theme Variables

Available variables in node templates:

```twig
{# Standard Drupal variables #}
{{ content }}
{{ node }}
{{ view_mode }}

{# Howard Content Types specific variables #}
{{ hero_image }}          {# Processed hero image URL #}
{{ show_hero_image }}     {# Boolean for hero image visibility #}

{# Example usage #}
{% if show_hero_image and hero_image %}
  <div class="hero-image">
    <img src="{{ hero_image }}" alt="{{ node.label }}" />
  </div>
{% endif %}
```

## Configuration APIs

### Configuration Management

```php
// Load module configuration
$config = \Drupal::config('howard_content_types.settings');

// Load content type configuration
$content_type_config = \Drupal::config('node.type.hc_page');

// Update configuration
$config_factory = \Drupal::configFactory();
$config = $config_factory->getEditable('howard_content_types.settings');
$config->set('setting_name', 'value');
$config->save();
```

### Configuration Override

Sites can override default configuration:

```php
// In settings.php or settings.local.php
$config['node.type.hc_page']['name'] = 'Custom Page Name';
$config['field.field.node.hc_page.field_hc_header_image']['required'] = TRUE;
```

### Partial Configuration Import

```bash
# Import specific configuration
drush config:import --partial --source=modules/contrib/howard_content_types/config/install/

# Import with update mode
drush cim -y --partial --source=modules/contrib/howard_content_types/config/install/
```

## Update APIs

### Database Updates

The module includes update hooks for field changes:

```php
/**
 * Removes field_hc_hide_for_nonhoward from HC Page CT.
 */
function howard_content_types_update_8013() {
  // Delete field instance
  if (FieldConfig::loadByName('node', 'hc_page', 'field_hc_hide_for_nonhoward') !== NULL) {
    FieldConfig::loadByName('node', 'hc_page', 'field_hc_hide_for_nonhoward')->delete();
  }

  // Delete field storage
  if (FieldStorageConfig::loadByName('node', 'field_hc_hide_for_nonhoward') !== NULL) {
    FieldStorageConfig::loadByName('node', 'field_hc_hide_for_nonhoward')->delete();
  }
}
```

### Running Updates

```bash
# Run database updates
drush updatedb

# Check for pending updates
drush updatedb --status

# Run specific update
drush updatedb --module=howard_content_types
```

## Extension Points

### Custom Hooks

Modules can implement custom hooks to extend functionality:

```php
/**
 * Implements hook_howard_content_types_content_alter().
 */
function mymodule_howard_content_types_content_alter(&$content, $node, $view_mode) {
  if ($node->bundle() === 'hc_page') {
    // Modify content for HC Page content type
    $content['custom_element'] = [
      '#markup' => '<div class="custom-content">Custom content</div>',
    ];
  }
}
```

### Event Subscribers

Create event subscribers for advanced integration:

```php
/**
 * Event subscriber for Howard Content Types.
 */
class HowardContentTypesSubscriber implements EventSubscriberInterface {
  
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'howard_content_types.node_presave' => 'onNodePresave',
    ];
  }
  
  /**
   * React to node presave events.
   */
  public function onNodePresave(Event $event) {
    // Custom logic for node presave
  }
}
```

### Plugin APIs

Extend functionality with custom plugins:

```php
/**
 * Custom field formatter for Howard content types.
 *
 * @FieldFormatter(
 *   id = "howard_custom_formatter",
 *   label = @Translation("Howard Custom Formatter"),
 *   field_types = {
 *     "text",
 *     "text_long"
 *   }
 * )
 */
class HowardCustomFormatter extends FormatterBase {
  
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#markup' => $this->viewValue($item),
      ];
    }
    
    return $elements;
  }
}
```

### Service Integration

Access Howard Content Types services:

```php
// Get the Howard Content Types service
$howard_service = \Drupal::service('howard_content_types.helper');

// Use service methods
$hero_image = $howard_service->getHeroImage($node);
$formatted_content = $howard_service->formatContent($content);
```

---

*For more advanced integration examples and custom development, see the [Developer Guide](DEVELOPER.md).*
