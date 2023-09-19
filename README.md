# laravel UUID/MUID

This package is for generating uuid but with custom length and charset.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install muid.

```bash
composer require abdulrhmansouda/muid
```

## Usage

inside your table migration
```php
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->muid()->primary(); \\ by default the column name is "muid"
            $table->timestamps();
        });
    }
```

inside your model
```php
use Illuminate\Database\Eloquent\Model;
use MUID\HasMUID;

class TableName extends Model
{
    use HasMUID;
}
```

That's it ^_^

## Customization

you are able to add multiple column, change column_name, length of the string inside column, the charset.

first of all to change column name you have to start from migration:

```php
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->muid('id')->primary();
            $table->muid('unique_code', 5)->unique();
            $table->timestamps();
        });
    }
```
then from your model you can change the column_name, length , charset as follow:

```php
use Illuminate\Database\Eloquent\Model;
use MUID\HasMUID;

class TableName extends Model
{
    use HasMUID;

    protected static function get_muid_columns(): array
    {
        return [
            [
                'column_name'   => 'id',
                // 'length'    => 10, default length is 10
                // 'charset'   => '0123456789abcdefghijklmnopqrstuvwxyz', default chareset
            ],
            [
                'column_name'   => 'unique_code',
                'length'    => 5,
                'charset'   => '0123456789',
            ],
        ];
    }
}
```
## Helper Function
### when you want to generate muid manually.

Depending on the model the parameters of length and charset will be taken automatically.
```php
use Illuminate\Support\Str;

$unique_muid = Str::generateMUIDByModel(ModelName::class); // default column name is muid.

$unique_muid = Str::generateMUIDByModel(ModelName::class, 'column_name');
```

When you don't want to use model at all. you can generate unique muid depending on the table name.

```php
use Illuminate\Support\Str;

$unique_muid = Str::generateMUIDByTable('table_name');
// default column_name = 'muid'
// default column_length = 10
// default charset = '0123456789abcdefghijklmnopqrstuvwxyz'

$unique_muid = Str::generateMUIDByTable('table_name', 'column_name', 5, '0123456789');
```

## To add muid column to a table which has records
after adding configuration to model you have to add in migration.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('table_name', function (Blueprint $table) {
            $table->muid('new_column_name')->nullable();
        });

        TableName::all()->each(function ($model_instance) {
            $model_instance->generateMUID(['new_column_name']);
            $model_instance->save();
        });

        Schema::table('table_name', function (Blueprint $table) {
            $table->muid('new_column_name')
                ->nullable(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_name', function (Blueprint $table) {
            $table->dropColumn(['new_column_name']);
        });
    }
};
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)