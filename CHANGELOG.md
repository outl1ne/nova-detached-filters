# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.5] - 2020-10-28

### Added

- Added `change-per-page` event listener to update `per-page`.

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
