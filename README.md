1. Скачайте репозиторий git clone https://github.com/GiperProger/loan_provider.git
2. Зайдите в проект и выполните команду make start, поднимутся докер контейнеры и база данных, проект готов к работе.
3. Это Rest API Приложение, оно не имеет пользовательского интерфейса, работать с ним можно например через POST MAN. 
   В корне проекта есть папка postman, в ней готовая коллекция для взаимодействия с приложением. 
   Импортируйте и наслаждайтесь
4. Для того что бы запустить тесты нужно выполнить команду make db-migrate-test, а затем make test
5. Для запуска статического анализатора кода выполните команду make static-analyse
6. Если кредит был одобрен, то для пользователя создается уведомление в базе данных, после чего можно запустить команду
   которая рассылает уведомления make send-notifications