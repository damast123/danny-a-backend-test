# ![danny-a-backend-test](logo.png)

> ### Test backend Laravel for Rest API.

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/12.x/installation)

Clone the repository

    git clone https://github.com/damast123/danny-a-backend-test.git

Switch to the repo folder

    cd danny-a-backend-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/damast123/danny-a-backend-test.git
    cd danny-a-backend-test
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## API Specification

This application use to be REST API. This helps mix and match any backend with any other frontend without conflicts.

#### Create Todo List

```http
  POST /api/todo-lists
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| title | string | this will set title and it required |
| assignee | string | this will set assignee but it's optional |
| due_date | string | this will set the due date of todo list and it required |
| time_tracked | int | this will set time of todo list, it can be fill and not (default 0) |
| status | string | this will set status todo list(pending, open, in_progress, completed), it can be fill and not (default pending) |
| priority | string | this will set the priority todo list(low, medium, high) and it required |
| |  |  |

#### Get export excel

```http
  GET /api/todo-lists/export-excel
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| title | string | this will set filter title |
| assignee | string | this will set filter assignee |
| due_start | string | this will set filter due_start |
| due_end | string | this will set filter due_end |
| time_min | int | this will set filter time_min |
| time_max | int | this will set filter time_max |
| status | string | this will set filter status |
| priority | string | this will set filter priority |
| |  |  |

#### Get provide chart data

```http
  GET /api/todo-lists/export-excel
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| type | string | this will set filter type and have 3 type to filter(status, priority and, assignee) |
| |  |  |

----------

# Code overview

## Dependencies

- [laravel excel](https://docs.laravel-excel.com/3.1/getting-started/installation.html) - For exporting excel

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|

Refer the [api specification](#api-specification) for more info.

