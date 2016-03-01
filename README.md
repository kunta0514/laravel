## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)


### 注意最基本的编码规范，帮助你我阅读代码

数据库：
1、数据库修改请先在migrations中执行通过
2、表命名注意复数形式的使用，正确表达其含义，如users，tasks，task_details等
3、数据库字段全小写，单词用_分割，如:task_id
4、参数类数据可以不在数据库中key->value存储，直接在config中记录，数据库中可以只存key

前端：
1、事件绑定统一在加载时绑定，不要在dom中写死，加载统一使用$(function(){})
2、系统事件、自定义事件都遵从系统定义规则，全部小写，不要高大小写,简单来说，除了前端model对象，尽量全小写，单词直接用_分割。
3、


后台：
1、文件/文件夹，尽量保证一个单词命名，文件首字母大写，多个单词，首字母大写，如Task，TaskDetail。（resources文件除外，全小写命名，资源文件方便引用）
2、
