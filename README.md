# Nova Detached Filters

[![Latest Version on Packagist](https://img.shields.io/packagist/v/optimistdigital/nova-detached-filters.svg?style=flat-square)](https://packagist.org/packages/optimistdigital/nova-detached-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/optimistdigital/nova-detached-filters.svg?style=flat-square)](https://packagist.org/packages/optimistdigital/nova-detached-filters)

This [Laravel Nova](https://nova.laravel.com/) package allows you to place filters in Nova cards detached from the filter dropdown.

## Features

- Saving filter state
- Reset all and single filters
- Customizable
  - Change width of individual filter
  - Create columns for stacked filters

## Screenshots

![Large Card](docs/large.png)

![Small Cards](docs/small.png)


## Installation

Install the package in a Laravel Nova project via Composer:

```bash
composer require optimistdigital/nova-detached-filters
```

## Usage

Pass the filters you wish to detach from the filter menu and show on a card to `NovaDetachedFilters` class.
**NB: Filters you wish to detach must also be defined in `filters()` function.**


```php
use OptimistDigital\NovaDetachedFilters\NovaDetachedFilters;

public function filters()
{
    return this->myFilters();
}

public function cards()
{
    return [
        new NovaDetachedFilters($this->myFilters()),
    ];
}

protected function myFilters()
{
    return [
        new BooleanFilter(),
        new SelectFilter(),
        new PillFilter(),
        // ...
    ];
}
```

## Customization

### Widths
You can define the width of the filter using `withMeta()`.
To see available width options, check out [Tailwind width classes](https://tailwindcss.com/docs/width#app)

```php
public function cards(Request $request)
{
    return [
        new NovaDetachedFilters([
            (new SelectFilter())->withMeta(['width' => 'w-1/3']),
            (new AnotherSelectFilter())->withMeta(['width' => 'w-2/3']),
        ]),
    ];
}
```

Define the width of the card if you wish to have multiple filter cards side-by-side.
**Width classes should be passed without `w-` in front of it.**

```php
public function cards(Request $request)
{
    return [
        (new NovaDetachedFilters([
            new SelectFilter(),
            new AnotherSelectFilter()
        ]))->width('1/3'),
        (new NovaDetachedFilters([
            new SelectFilter(),
            new AnotherSelectFilter()
        ]))->width('2/3'),
    ];
}
```

### Resetting filter values
If you have bigger filters that take longer to clear manually, you can define `withReset` in filters metadata, that will render a button to easily clear the filters value without affecting other filters.

```php
public function cards(Request $request)
{
    return [
        new NovaDetachedFilters([
            (new SelectFilter())->withMeta(['withReset' => true]),
        ]),
    ];
}
```

If you want to clear all filters, you can call `withReset()` on `NovaDetachedFilters` class. This will render a button on the top-left corner that will clear all filter values.
```php
public function cards(Request $request)
{
    return [
        (new NovaDetachedFilters([
            new SelectFilter(),
        ]))->withReset(),
    ];
}
```

### Storing filter state
When you are working with multiple resources and large group of filters assigning filters every time you navigate is a hassle.
You can call `withPersist()` function on `NovaDetachedFilters` that will render a lock button top-right corner of the card.
Upon clicking the button, the lock will turn green stating that current filters are saved to `localStorage`.

```php
public function cards(Request $request)
{
    return [
        (new NovaDetachedFilters([
            new SelectFilter(),
        ]))->withPersist(),
    ];
}
```


## Credits

- [Kaspar Rosin](https://github.com/kasparrosin)

## License

Nova Detached Filters is open-sourced software licensed under the [MIT license](LICENSE.md).
