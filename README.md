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
            $table->muid(); \\ by default the column name is "muid"
            $table->timestamps();
        });
    }
```

inside your model
```php
class TableName extends Model
{
    use HasMUID;
}
```

That's it ^_^

## Customize

you are able to add multiple column, change column_name, length of the string inside column, the charset.

first of all to change column name you have to start from migration:

```php
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->muid('id');
            $table->muid('unique_code');
            $table->timestamps();
        });
    }
```
then from your model you can change the column_name, length , charset as follow:

```php
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
### To add muid column to a table which has records
after adding configuration to model you have to add in migration.

```php
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
            $table->string('new_column_name')
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