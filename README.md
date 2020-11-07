# Установка и настройка

1. Измените настройки `rusbeldoor/yii2General` в файле `./common/config/mylocal-sample/params-mylocal.php` и `./common/config/params-mylocal.php`.

2. Выполнить миграции для изменения структуры базы данных.
```
php yii migrate --migrationPath=@vendor/rusbeldoor/yii2-general/console/migrations/
```

# Панели
## Backend

### RBAC

http://panel.yii2.local/administrator/rbac/role  
http://panel.yii2.local/administrator/rbac/permission  

### Кроны

http://panel.yii2.local/administrator/cron 
