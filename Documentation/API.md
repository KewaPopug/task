## RESTful API

API реализовывает полный функционал веб части (регистрация, авторизация, редактирование данных пользователя).
Пользователь может редактировать через API свои данные. Администратор может редактировать данные любого пользователя.
API сервиса включает в себя:

- ```POST http://task.frontend/api/registration```: Регистрация пользователя;
- ```GET http://task.frontend/api/user?id=1```: Выборка пользователя, с id равным 1;
- ```GET http://task.frontend/api/current-user```: Выборка текущего пользователя;
- ```POST http://task.frontend/auth/login```: Аутентификация пользователя;
- ```GET http://task.frontend/api/users```: Выборка всех пользователей;
- ```POST http://task.frontend/api/update```: Обновление текущего пользователя;
- ```POST http://task.frontend/api/update?id=1```: Обновление пользователя.

Далее нужно воспользоваться платформой API, к примеру Postman.

### Регистрация пользователя

Для регистрации нам понадобиться ```POST http://task.frontend/api/registration``` и заполнить ```body``` таким образом:

```bash
{
    "username": "your_username",
    "password": "your_password",
    "email": "your_email",
    "surname": "your_surname",
    "firstname": "your_firstname",
    "patronymic": "your_patronymic",
    "individual_identification_number": "your_individual_identification_number",
    "date_born": "your_date_born",
    "photo_url": "your_photo_url"
}
```

При успешном выполнении будет выведено:

```bash
{
"success": true,
"message": "Пользователь успешно зарегистрирован"
}
```

### Аутентификация пользователя

Для аутентификации пользователя нам понадобиться ```POST http://task.frontend/auth/login``` и заполнить ```body``` таким образом:

```bash
{
    "username": "username",
    "password": "password"
}
```

При успешном выполнении будет выведено:

```bash
{
  {
    "id": 1,
    "username": "username",
    "auth_key": "auth_key",
    "password_hash": "password_hash",
    "password_reset_token": "password_reset_token",
    "email": "email",
    "status": "status",
    "created_at": "created_at",
    "updated_at": "updated_at",
    "verification_token": "verification_token",
    "surname": "surname",
    "firstname": "firstname",
    "patronymic": "patronymic",
    "individual_identification_number": "individual_identification_number",
    "date_born": "date_born",
    "photo_url": "photo_url"
  }
"token": "token"
}
```

```"token": "token"``` будет задействован в действиях, которые требуют аутентификации пользователя.

### Выборка пользователя

Для выборки пользователя нам понадобиться ```GET http://task.frontend/api/user?id=1``` и так как это действие требует
аутентификации пользователя, нужен сгенерированный токен, который получается при авторизации.

При успешном выполнении будет выведено информации о пользователе с id равным 1:

```bash
{
    "id": 1,
    "username": "username",
    "auth_key": "auth_key",
    "password_hash": "password_hash",
    "password_reset_token": "password_reset_token",
    "email": "email",
    "status": "status",
    "created_at": "created_at",
    "updated_at": "updated_at",
    "verification_token": "verification_token",
    "surname": "surname",
    "firstname": "firstname",
    "patronymic": "patronymic",
    "individual_identification_number": "individual_identification_number",
    "date_born": "date_born",
    "photo_url": "photo_url"
}
```

### Выборка текущего пользователя

Для выборки текущего пользователя нам понадобиться ```GET http://task.frontend/api/current-user```  и так как это действие так же требует
аутентификации пользователя, так же нужен сгенерированный токен, который получается при авторизации.

При успешном выполнении будет выведено информации о текущем пользователе:

```bash
{
    "id": 1,
    "username": "username",
    "auth_key": "auth_key",
    "password_hash": "password_hash",
    "password_reset_token": "password_reset_token",
    "email": "email",
    "status": "status",
    "created_at": "created_at",
    "updated_at": "updated_at",
    "verification_token": "verification_token",
    "surname": "surname",
    "firstname": "firstname",
    "patronymic": "patronymic",
    "individual_identification_number": "individual_identification_number",
    "date_born": "date_born",
    "photo_url": "photo_url"
}
```

### Выборка всех пользователей


Для выборки всех пользователей нам понадобиться ```GET http://task.frontend/api/users``` и так как это действие так же требует
аутентификации пользователя, так же нужен сгенерированный токен, который получается при авторизации.

При успешном выполнении будет выведено информации о всех пользователях:

```bash
{
    "id": 1,
    "username": "username",
    "auth_key": "auth_key",
    "password_hash": "password_hash",
    "password_reset_token": "password_reset_token",
    "email": "email",
    "status": "status",
    "created_at": "created_at",
    "updated_at": "updated_at",
    "verification_token": "verification_token",
    "surname": "surname",
    "firstname": "firstname",
    "patronymic": "patronymic",
    "individual_identification_number": "individual_identification_number",
    "date_born": "date_born",
    "photo_url": "photo_url"
},
{
    "id": 2,
    "username": "username",
    "auth_key": "auth_key",
    "password_hash": "password_hash",
    "password_reset_token": "password_reset_token",
    "email": "email",
    "status": "status",
    "created_at": "created_at",
    "updated_at": "updated_at",
    "verification_token": "verification_token",
    "surname": "surname",
    "firstname": "firstname",
    "patronymic": "patronymic",
    "individual_identification_number": "individual_identification_number",
    "date_born": "date_born",
    "photo_url": "photo_url"
}
...
```
### Обновление текущего пользователя

Для обновления нам понадобиться ```POST http://task.frontend/api/current-update``` и заполнить ```body``` таким образом, а так как это действие так же требует
аутентификации пользователя, так же нужен сгенерированный токен, который получается при авторизации:

```bash
{
    "username": "your_username",
    "email": "your_email",
    "surname": "your_surname",
    "firstname": "your_firstname",
    "patronymic": "your_patronymic",
    "individual_identification_number": "your_individual_identification_number",
    "date_born": "your_date_born",
    "photo_url": "your_photo_url"
}
```

При успешном выполнении будет выведено:

```bash
{
"success": true,
"message": "Пользователь успешно обновлен"
}
```

### Обновление пользователя

Для обновления нам понадобиться ```POST http://task.frontend/api/update?id=1``` и заполнить ```body``` таким образом, а так как это действие так же требует
аутентификации пользователя, так же нужен сгенерированный токен, который получается при авторизации:

```bash
{
    "username": "your_username",
    "email": "your_email",
    "surname": "your_surname",
    "firstname": "your_firstname",
    "patronymic": "your_patronymic",
    "individual_identification_number": "your_individual_identification_number",
    "date_born": "your_date_born",
    "photo_url": "your_photo_url"
}
```

При успешном выполнении будет выведено:

```bash
{
"success": true,
"message": "Пользователь успешно обновлен"
}
```




