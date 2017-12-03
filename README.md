# linguo
Gettext for laravel 5

## Installation

### Laravel Service Provider

Add the service provider and the face on `config/app.php`

```
'providers' => [

    [...]
    Backtheweb\Linguo\LinguoServiceProvider::class,
],

'aliases' => [
    [...]
    'Linguo' => Backtheweb\Linguo\LinguoFacade::class,
]
```   
 
And publish the config:

```
php artisan vendor:publish --provider="Backtheweb\Linguo\LinguoServiceProvider" --tag=config
```

### Setup

Edit `config/linguo.php`

````
return [

    'headers' => [
        'Project-Id-Version'    => 'linguo',
        'Language-Team'         => 'TeamName <info@example.com>'
    ],

    'sources' => [
        base_path('resources/views'),
        base_path('app/Http/Controllers'),
    ] ,

    'i18nPath'  => base_path('resources/lang'),
    'domain'    => 'default',           // defualt domain
    'domains'   => [],                  // others domains to process
    'locales'   => ['es', 'en'],        // may be en or en_GB
];
````


**Sources** : Is where the parser will be looking for translation keys
**i18nPath**: Is the path where are stored the translation files 

## Parse and generate translation files

Parse and build on one command

````
php artisian linguo:parse
````

### What does it do?

1. Read the folders defined on `sources` config and extract the keys form translation functions gettext, ngettext, __, _n
2. Create a catalog `default.pot` file whit keys.
3. Foreach language defined on `locales`:

    * Create or/update the `{local}/default.po` file.
    * Create a `{local}/default.php` file with translations defined on `{local}/default.po`
    
## Convert Po to array

````
php artisian linguo:convert 
php artisian linguo:convert default 
```` 

Default is the domain/file name by default, default is used.