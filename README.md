
# SISTEM E-KAMPUS DARUL QURAN VERSI 2.0

## Commands Available for Developers

Fix code style convention to be based on Laravel standard:

```bash
composer format
```

Fix code style and commit immediately:

```bash
composer fc
```

Rebuild front-end assets and commit:

```bash
composer fe
```

Update composer depdendencies and commit:

```bash
composer ud
```

Reload all caches:

```bash
php artisan reload:cache
```

Create new page:

```bash
php artisan make:page ModuleNmae PageName
```

This `make:page` will create a new controller, menu, sidebar, routes automatically. This might not work well if there's
a new page created in the same module. The bottom line - streamline the way we generate a new page.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
