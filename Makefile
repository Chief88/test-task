init: migrate-up

fill-data: create-users create-operation

migrate-up:
	php src/yii migrate/up --interactive=0

create-users:
	php src/yii users/create-users

create-operation:
	php src/yii users/create-operations