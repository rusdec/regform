# Форма регистрации v0.4

#### (тестовое задание для топфейса) 

## Задание
https://docs.google.com/forms/d/e/1FAIpQLSdVvA1aAxiMfK5F2Geu82da6JH1n9kIFRFnu4lyhoxWJegK6A/viewform?c=0&w=1

## Пример формы
http://kcmrumve.beget.tech

## Краткое описание

### Файлы

1. .htaccess
	* Направляет запросы на index.php
2. index.php 
	* В зависимости от типа запроса (GET,POST) И request uri вызывает необходимый обработчик запроса
3. system/http_handlers.php
	* Описывает обработчики.
4. system/models.php
	* Описывает классы.
	* Класс соответсвует таблице в базе данных и предоставляет методы работы с данными этой таблицы.
5. system/db_config.php
	* Возвращает массив с настройками подключения к базе данных MySQL.
6. pages/*
	* Содержит файлы - статичные html-шаблоны страниц.
7. static/*
	* Содержит статические файлы: стили, js-скрипты, шрифты

### Иерархия вложенности (include)

* index.php
	* system/http_handlers.php
		* system/models.php
			* system/db_config.php

## Используются сторонние проекты
https://github.com/emn178/js-sha1 
