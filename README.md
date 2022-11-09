# Laravel-Static-Image

`x-static-image` - является отличной заменой стандартного тега `img`, использовав который хотя бы раз, вы больше никогда
не захотите возвращаться к стандартному тегу

## Установка

`Тут в будущем какая то команда для установки`

Добавить в `composer.json`:

```json
"require":{
    "batyukovstudio/laravel-static-image": "dev-main"
}
```

```json
"repositories": [
    {
    "type": "vcs",
    "url": "git@github.com:batyukovstudio/laravel-static-image.git"
    },
    {
    "type": "vcs",
    "url": "git@github.com:batyukovstudio/laravel-image-object.git"
    }
],
```

Добавить в `package.json`:

```json
{
  "static-image:generate": "node vendor/batyukovstudio/laravel-static-image/convertor.js --config=node_modules/laravel-mix/setup/webpack.config.js",
  "static-image:clear": "node vendor/batyukovstudio/laravel-static-image/delete.js --config=node_modules/laravel-mix/setup/webpack.config.js"
}
```

Если вам необходимо отредактировать конфиги, или изменить static-image.blade:

`php artisan vendor:publish --tag="laravel-static-image"`

## Конфигурация

Для генерации конверсий для изображений, воспользуйтесь командами:
`php artisan laravel-static-image:generate-conversions`, или `npm run static-image:generate`

Для удаления конверсий для изображений, воспользуйтесь командами:
`php artisan laravel-static-image:delete-conversions`, или `npm run static-image:clear`

Чтобы настроить модуль изображения и настроить его поведение, вы можете использовать файл `conversion-config.json`
> Все значения в примерах являются дефолтными

### Размеры экрана (screens)

Список предопределенных размеров экрана. Эти размеры будут использоваться для создания точек перехода измененных и
оптимизированных версий изображений с помощью модификатора размеров.

```json
{
  "screens": {
    "xs": 320,
    "sm": 640,
    "md": 768,
    "lg": 1024,
    "xl": 1280,
    "xxl": 1536
  }
}
```

> type: **Object**

### Качество (quality)

Вы можете определить качетсво при генерации `webp` для всех изображений, указав это в файле конфигурации:
Допустимый диапозон `0` - `100`

```json
{
  "quality": 80
}
```

> type: **Number**

### Превикс (prefix)

`Префикс` используется при генерации изображений, а также при удалении картинок

```json
{
  "prefix": "conversions_"
}
```

> type: **String**

### Папка для поиска (pageFolder)

Для того, чтобы указать скрипту, в каких папках необходимо проводить поиск, вы можете указать в файле конфигурации:

```json
{
  "pageFolder": "resources/views"
}
```

Либо, если вы используете другую файловую структуру, к примеру `Apiato`, вы можете указать массив папок:

```json
{
  "pageFolder": [
    "resources/views",
    "app"
  ]
}
```

> type: **String** || **Array**

### Ресурсная папка  (sourceFolder)

Поскольку `Laravel` использует для хранения всех медиа-файлов папку `public` - это значение является стандартным, но вы
можете изменить ее

```json
{
  "sourceFolder": "public"
}
```

> type: **String**

### Исключение поиска (exception)

Если вдруг, вы указали в качестве `resourceFolder` корень вашего проекта, и вам необходимо сделать исключение, к
примеру `node_modules`, вы можете передать название папок

```json
{
  "exception": "node_modules"
}
```

```json
{
  "exception": [
    "node_modules",
    "config"
  ]
}
```

> type: **String** || **Array**

### Вывод предупреждений (checkWarning)

Если вы новичек, и иногда забываете указывать некоторые аттрибуты у изображений, что является не лучшей практикой, вы
можете включить проверку:

```json
{
  "checkWarning": false
}
```

> type: **Boolean**

### Вывод прогресса (checkProgress)

Если проект у вас достаточно большой, и вы опасаетесь что скрипт может зависнуть, вы можете включить вывод прогресса:

```json
{
  "checkProgress": false
}
```

> type: **Boolean**

## Использование

`x-static-image` выводит стандартный тег `picture`

```html

<x-static-image src="/batyukovstudio-logotype.png"/>
```

Конечным результатом будет:

```html

<picture>
    <source srcset="/batyukovstudio-logotype.webp" type="image/webp">
    <img src="/batyukovstudio-logotype.png">
</picture>
```

## Входные параметры (props)

### `src`

Путь до файла картинки.

`src` должен быть в виде абсолютного пути для статических изображений в `public/` (Может быть изменен).

Пример:

```html

<x-static-image src="/batyukovstudio-logotype.png"/>
```

### `width` / `height`

Оба этих свойства являются стандартными для тега `img`, необходимы при загрузке страницы. Указав эти аттрибуты, при
генерации страницы, браузер зарегистрирует место под картинку и при загрузке всех медиафайлов контент не будет "прыгать"

Пример:

```html

<x-static-image src="..." width="640" height="320"/>
```

### `sizes`

Это разделенный пробелами список пар размер/ширина экрана. На основе значений этого аттрибута, будут формироваться
медиазапросы для отображения изображений

Пример:

```html

<x-static-image src="/batyukovstudio-logotype.png" sizes="400 xl:1000"/>
```

Резульатом будет:

```html

<picture>
    <source type="image/webp"
            srcset="/_ebs_batyukovstudio-logotype_1000.webp"
            media="(min-width: 1280px)">
    <source type="image/webp"
            srcset="/_ebs_batyukovstudio-logotype_400.webp">
    <img src="/batyukovstudio-logotype.png">
</picture>
```

### `quality`

Качество для генерации изображений

Пример:

```html

<x-static-image src="/batyukovstudio-logotype.png" quality="70"/>
```

Не указав значение на теге `x-static-image`, значение качества будет браться из файла конфигурации `batwebp.config.json`
, если в файле также не указано качество, то будет взято стандартное значение `80`

### `lazy`

Является стандратным аттрибутом `loading="lazy"`, для удобства был сокращен.

Пример:

```html

<x-static-image src="/batyukovstudio-logotype.png" lazy/>
```

Результат:

```html

<picture>
    <source srcset="/batyukovstudio-logotype.webp" type="image/webp">
    <img src="/batyukovstudio-logotype.png" loading="lazy">
</picture>
```