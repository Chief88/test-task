# test-task
Test task for companies Freematiq

# Установка
Клонируем проект: 

~~~
git clone https://github.com/Chief88/test-task.git project
cd project/
php src/init --env=Development --overwrite=All
~~~

Устанавливаем зависимости композера.
Создаем базу данных.
Редактируем файлы src/common/config/main-local.php и src/console/config/main-local.php
Примеры для данных файлов src/common/config/main-local-example.php и  src/console/config/main-local-example.php

Далее выполняем:

~~~
make init
~~~

Доступы администратора в файле src/console/migrations/m160408_174338_fill_user_and_bill_admin.php
У всех demo-пользователей пароль совпадает с никнеймом