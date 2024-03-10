# ID-Refs: Indonesian Citizen Identity References

## Description

This library provides a collection of references and utilities related to Indonesian citizen identity documents, such as KTP (Kartu Tanda Penduduk) and KK (Kartu Keluarga). It aims to simplify the process of working with these identifiers in your PHP applications.

## Installation

The recommended installation method is via Composer:
```bash
composer require wurin7i/id-refs
```

This will install the library and its dependencies into your project's vendor directory.

## Requirements

- PHP 8.1 and above
- illuminate/support ^9.0 or ^10.0

## Usage

Once installed, you can use the library's classes and functions to interact with Indonesian citizen identity references. Refer to the detailed documentation (coming soon) for specific usage instructions.

### Database Seeders

The library may include database seeders located in the database/seeders directory. These seeders can be used to populate your database with reference data. To run the seeders, you'll need to configure your database connection and use a command-line tool like Laravel's Artisan:

```bash
php artisan db:seed --class=WuriN7i\\IdRefs\\Database\\Seeders\\ReferenceDataSeeder
```

### Populating Regions Data

IdRefs library offer a command `idrefs:update-data` to update your database with Kemendagri regions data. The sql source is retrieved from the [cahyadsn/wilayah](https://github.com/cahyadsn/wilayah) GitHub repository.

```bash
php artisan idrefs:update-data
```

## Contributing

We welcome contributions to this library. Please see the CONTRIBUTING.md file (to be added) for guidelines on how to contribute.

## License

This library is licensed under the MIT License. See the LICENSE file for details.

## Author

Wuri Nugrahadi (wuri.nugrahadi@gmail.com)