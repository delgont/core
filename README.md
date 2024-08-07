
## Laravel Delgont Core

#### Key features
- `Model options - store model properties in a key value way.`

####  Requirements
`Composer` `Laravel Framework 6.0+`

--
### Store Model Properties In a Key Value Way

If you want to store model properties in a key-value way in Laravel

```php
// Example of storing properties in key-value way
$model = YourModel::create([
    'name' => 'Example Model',
    'description' => 'This is an example model',
    'meta' => [
        'key1' => 'value1',
        'key2' => 'value2',
    ],
]);
```

```php
// app/Models/YourModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Delgont\Core\Concerns\ModelHasMeta;

class YourModel extends Model
{
    use ModelHasMeta;

    protected $fillable = ['name', 'description', 'meta'];
}
```

```php
// Example of using the trait to store key-value properties
$model = YourModel::create([
    'name' => 'Example Model',
    'description' => 'This is an example model',
    'meta' => [
        'key1' => 'value1',
        'key2' => 'value2',
    ],
]);

// Accessing key-value pair
$model->setMeta('key3', 'value3');
$value = $model->getMeta('key3');
```

```php
php artisan make:repo TestRepository --model=App/Entities/Test
```