# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.12] - 2021-11-26

### Removed

- Removed passing values by reference. (thanks to [@maherelgamil](https://github.com/maherelgamil))

## [1.0.11] - 2021-11-26

### Changed

- Fixed issue where `per-page` filter styles were not removed when component was destroyed.
- Updated packages.

## [1.0.10] - 2020-11-26

### Changed

- When using `hasDetachedFilters`, filters are now grouped by `->key()` [#13](https://github.com/optimistdigital/nova-detached-filters/issues/13)

## [1.0.9] - 2020-10-30

### Changed

- Now `collapsing` and `persisting` filters works on resource basis.
- Fixed duplicate navigation error

## [1.0.8] - 2020-10-30

### Changed

- Fixed support with `optimistdigital/nova-multiselect-filter`

## [1.0.7] - 2020-10-30

### Added

- Added `$showInMenu` parameter to `withPerPage` to optionally hide `per-page` filter from default dropdown menu

## [1.0.6] - 2020-10-29

### Changed

- Fixed filters still being clickable after toggling.
- Enabling `persist filters` now stores current filters.

## [1.0.5] - 2020-10-28

### Added

- Added `change-per-page` event listener to update `per-page`.

### Changed

- Fixed `DetachedFilterColumn` not showing filters in columns

## [1.0.4] - 2020-10-26

### Added

- Filters can now be standalone in `NovaDetachedFilters` when using `HasDetachedFilters` trait.
- Added `withPerPage` function to `NovaDetachedFilters`. More documentation in readme.
- Added `::make()` to `DetachedFilterColumn`.

### Changed

- Changed reset filter icon.

## [1.0.3] - 2020-10-23

### Changed

- Hotfix persisted filters.

## [1.0.2] - 2020-10-22

### Added

- Filter menu reset filters now also clears persisted filters.
- Added better support for dropdown filters such as `multiselect-filter`.

### Changed

- Fixed saving filters to `localStorage`.
- Changed `mounted` => `created` to initialize filter values before component is `mounted`.

## [1.0.1] - 2020-10-13

### Added

- Added `withToggle` to optionally collapse the filter card.

## [1.0.0] - 2020-10-05

Initial release.

### Added

- Simple nova card to detach filters from filter menu
- Persist Logic to store filter state in localStorage
