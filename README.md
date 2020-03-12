# Laravel Eloquent Filters

A package for Laravel that can be used to filter a model's records.

## How does it work?

Simply the package checks the request query for keys that match the corresponding filter keys set for the model then builds the query.

Each model has a corresponding `filters` file where it's filters can be registered and mapped.

Each registered `filter` is a unique file that contains the necessary functionality to build a query.

This means that for models that have a `title` column, they can share the call the same filter file hence reducing code duplication.

## Installation

Use composer to install the package:

```
composer require miracuthbert/laravel-eloquent-filters
```

## Setup

The package takes advantage of Laravel Auto-Discovery, so it doesn't require you to manually add the ServiceProvider.

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`

```php
Miracuthbert\Filters\EloquentFiltersServiceProvider::class
```

If you want to publish the `config` file use the commands below in your console

### Publish Config

```
php artisan vendor:publish --provider=Miracuthbert\Filters\EloquentFiltersServiceProvider --tag=filters-config
```

## Usage

## Setting up a model

A filter for a model generally extends the `Miracuthbert\Filters\FiltersAbstract`.

It contains a list of filters that will should be applied to a the model and a map of `key/value` pair of filters list.

To create one:

First, create a model with `php artisan make:model` command.

Then create a filter file for the model using:

```
php artisan filter:model {name}

// example
php artisan filter:make UserFilters

// within specific namespace
php artisan filter:make Users\\UserFilters
```

Switch `name` with the model name and preferably add suffix `Filters` to indicate it is a model filter, eg. `UserFilters`

> Copy and add the block of code printed out in the console, to the related model. Do not forget to pull in the required namespaces.

### Using Filter in Controller
 
After setup above in any controller that you call the model instance, call the `filter` scope passing an instance of the `Illuminate\Http\Request'.

```php
$users = User::filter($request)->get();
```

In case you have disabled appending of the filters query to a paginator, you could do it manually by using the `filters_query` helper: 

```php
$users->appends(filters_query());
```

```blade
// in blade view
{{ $users->appends(filters_query())->links() }}
```

## Creating a Filter

All created filters by default will be placed within, `App\Filters` directory (namespace).

To create a filter use:

```
php artisan filter:make {name}

// example
php artisan filter:make NameFilter

// within specific namespace
php artisan filter:make Users\\NameFilter
```

Switch `name` with the name of the filter, eg. `NameFilter` (normal filter), `CreatedOrder` (ordering filter)

> When creating a filter, it is good to add `Filter` or `Order` to the name for ease of use.

You can then open the filter file and add your custom query functionality. See the `filter:make` command options for some preset templates.

> Filters are basically blocks of code that extend `Illuminate\Database\Eloquent\Builder`, so you are not limited to the preset templates.

You can pass, the following options to the `filter:make` command, to make use of some of the common filter templates:

- `column`, Indicates the column the filter should be implemented on
- `bool`, Indicates if generated filter should be a boolean filter class
- `null`, Indicates if generated filter should be a null check filter class
- `order`, Indicates if generated filter should be an order filter class
- `relation`, Generates a filter class for the given relationship

## Registering Filters to Model Filters

After creating a filter, to use it open a model filter and register a `key/value` pair under the `$filters` field.

```php
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [
         'name' => NameFilter::class,
         'email' => EmailFilter::class,
         'created' => CreatedOrder::class,
    ];
```

## Setting Default Filters

In a model filter, you can register a `key/value` pair under the `$defaultFilters` field, for filters you want to be applied by default.

> `key` should be the same as the one registered on the `$filters` field, `value` should be an actual database value.

_Note_: Default filters should only be used for filters with `fixed` or `unchanging` values, eg. `true`, `false`

```php
    /**
     * A list of default filters.
     *
     * @var array
     */
    protected $defaultFilters = [
         'created' => 'desc',
    ];
```

> You can override default filters in the constructor of a model filter, by adding different checks.

```php
    // constructor

    if ($request->hasAny('cancelled', 'completed')) {
        $this->defaultFilters = [
            'upcoming' => 'false'
        ];
    }
```

## Console Commands

There available commands within the package:

- `filter:model`: Create a new filter class for a model
- `filter:make`: Creates a new Eloquent filter class

> Pass `--help` option to the commands to get more details on using them

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Cuthbert Mirambo via [miracuthbert@gmail.com](mailto:miracuthbert@gmail.com). All security vulnerabilities will be promptly addressed.

## Credits

- [Cuthbert Mirambo](https://github.com/miracuthbert)

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
