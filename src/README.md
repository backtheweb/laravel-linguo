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

```   
 
And publish the config:

```
php artisan vendor:publish --provider="Backtheweb\Linguo\LinguoServiceProvider" --tag=config
php artisan migrate  --path=/packages/backtheweb/linguo/src/migrations/

```




### Setup

Edit `config/linguo.php`
