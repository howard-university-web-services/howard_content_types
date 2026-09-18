# Changelog

All notable changes to the Howard Content Types module will be documented in this file.

## [11.0.9] - 2026-09-18

### Changed

- **`hc_page`/`hc_standard_homepage` KS Widgets**: Excluded `hp_statistics_item` (the repeating child of the new `hp_statistics` paragraph in `howard_paragraphs`) from direct addition via the "KS Widgets" field, matching how other repeating child bundles (`hp_carousel_with_caption_slide`, `hp_carousel_with_modal_slide`, `ip_accordion_item`) are handled. It remains addable only through the `hp_statistics` container's own item field. Added `hc_page_update_8012()` and `hc_standard_homepage_update_8011()` to apply the change to already-installed sites.

## [11.0.8] - 2026-07-27

### Changed

- Converted entity browser fields to Media Library.

## [11.0.7] - 2026-07-23

### Changed

- Dependency adjustment.

## [11.0.6] - 2026-02-16

### Fixed

- Removed admin CSS causing issues with the Gin theme.
