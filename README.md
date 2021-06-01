# Установка и настройка

1. Измените настройки `rusbeldoor/yii2General` в файле `./common/config/params-mylocal.php`.

2. Выполнить миграции для изменения структуры базы данных.
```
php yii migrate --migrationPath=@vendor/rusbeldoor/yii2-general/console/migrations/
```

3. Создайте платформы (как минимум текущего проекта).

4. Создайте кроны и настройте их запуск.
- `\console\controllers\RemoveOutdatedDataController` (родитель `\rusbeldoor\yii2General\console\controllers\RemoveOutdatedDataController`, рекомендуется запуск не чаще, чем раз в 2 суток).
```
0 0 */2 * * php /home/user/yii2/yii removing-outdated-data > /dev/null
```
- `\console\controllers\YandexDirectController` (родитель `\rusbeldoor\yii2General\console\controllers\YandexDirectController`, рекомендуется запуск не чаще, чем раз в 2 часа).
```
0 0 */6 * * php /home/user/yii2/yii yandex-direct > /dev/null
```

# Модули

## Платформы

Backend. Перечеь сервисов (сайтов, платформ и т. п.) участвующих в общей структуре (главный, дочерние, соседние сервисы).

http://panel.yii2.local/administrator/platform

### Настройка

1. Добавить хотябы 1 платформу.

## RBAC

Backend. Модуль реализующий систему контроля доступа (права, роли).

http://panel.yii2.local/administrator/rbac/role  
http://panel.yii2.local/administrator/rbac/permission  

## Кроны

Backend. Модуль реализующий работу и управление кронами.

http://panel.yii2.local/administrator/cron

## Подписки

Frontend-backend. Модуль реализующий подписную систему (систему уведомлений по каналам связи).

### Предназначение таблиц

* user_subscription_sender_category - это категории отправителей сообщений (в категории может быть 0+).
* user_subscription_sender - это отправители сообщений (участники категорий).
* user_subscription_sender_category_action - это действия распространяющиеся на всех участников категорий.
* user_subscription - это связь между пользователем и отправителем сообщений (участником категории).
* user_subscription_channel - это способ доставки уведомлений.
* user_subscription_exemption - это исключения из связи user_subscription по действию и способу доставки уведомлений.

### Настройка

1. Добавить хотябы 1 категорию (таблица `user_subscription_sender_category`).
2. Добавить хотябы 1 отрпавителя сообщений (таблица `user_subscription_sender`).
3. Добавить хотябы 1 действие категории (таблица `user_subscription_sender_category_action`).
4. Связать пользователя с отправителем (таблица `user_subscription`).

## Яндекс.Директ

Backend. Модуль реализующий работу с Яндекс.Директ.

### Настройка

1. Добавить хотябы одну аккаунт (таблица `yandex_direct_account`).
