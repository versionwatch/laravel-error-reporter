# VersionWatch Error Reporter for Laravel

[![Latest Version](https://img.shields.io/packagist/v/versionwatch/laravel-error-reporter.svg?style=flat-square)](https://packagist.org/packages/versionwatch/laravel-error-reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/versionwatch/laravel-error-reporter.svg?style=flat-square)](https://packagist.org/packages/versionwatch/laravel-error-reporter)
[![License](https://img.shields.io/github/license/versionwatch/laravel-error-reporter.svg?style=flat-square)](LICENSE.md)

A seamless error monitoring solution for Laravel applications, part of the VersionWatch ecosystem. Automatically track, group, and analyze exceptions in your production applications.

![Error Dashboard Preview](https://versionwatch.com/images/error-dashboard.png)

## Features

- **Automatic Error Reporting** - Catches all unhandled exceptions
- **Smart Grouping** - Automatically groups similar errors using content hashing
- **Rich Context** - Includes environment data, stack traces, and user context
- **Multi-project Support** - Track errors across multiple Laravel applications
- **Security First** - No sensitive data collected by default
- **Queue Integration** - Built-in support for Laravel queues
- **Performance Monitoring** - Track error occurrence frequency and patterns

## Installation

1. Install via Composer:
```bash
composer require versionwatch/laravel-error-reporter

2. Publish configuration file:
```bash
php artisan vendor:publish --tag=vw-error-reporter

3. Configure your .env file:
```bash
VERSIONWATCH_ERROR_REPORTING_ENABLED=true
VERSIONWATCH_ERROR_REPORTING_ENDPOINT=https://errors.versionwatch.com
VERSIONWATCH_ERROR_REPORTING_PROJECT_ID=your_project_id
VERSIONWATCH_ERROR_REPORTING_API_KEY=your_api_key

4. Queue Integration:
```bash
VERSIONWATCH_QUEUE_ENABLED=true
VERSIONWATCH_QUEUE_NAME=versionwatch-errors

## License

The VersionWatch Error Reporter is open-source software licensed under the MIT license.