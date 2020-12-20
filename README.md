# Установка и настройка

1. Измените настройки `rusbeldoor/yii2General` в файле `./common/config/params-mylocal.php`.

2. Выполнить миграции для изменения структуры базы данных.
```
php yii migrate --migrationPath=@vendor/rusbeldoor/yii2-general/console/migrations/
```

3. Создайте кроны и настройте их запуск.
- `\console\controllers\RemoveOutdatedDataController` (родитель `\rusbeldoor\yii2General\console\controllers\RemoveOutdatedDataController`, рекомендуется запуск раз в сутки).
- `\console\controllers\YandexDirectController` (родитель `\rusbeldoor\yii2General\console\controllers\YandexDirectController`, рекомендуется запуск раз в 2 часа).

# Панели
## Backend

### RBAC

http://panel.yii2.local/administrator/rbac/role  
http://panel.yii2.local/administrator/rbac/permission  

### Кроны

http://panel.yii2.local/administrator/cron 

### Яндекс.Директ

http://panel.yii2.local/administrator/yandex-direct
