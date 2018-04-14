# Makefile

include .env

docker-start:
	@docker-compose up -d --build

docker-stop:
	@docker-compose down -v

logs-tail:
	@docker-compose logs -f

mysql-dump:
	@mkdir -p $(MYSQL_BACKUPS_DIR)
	@docker exec mysql mysqldump --all-databases -u $(MYSQL_USER) --password=$(MYSQL_ROOT_PASSWORD) > $(MYSQL_BACKUPS_DIR)/latest-dump.sql

mysql-restore:
	@docker exec -i mysql mysql -u $(MYSQL_USER) --password=$(MYSQL_ROOT_PASSWORD) $(MYSQL_DATABASE) < $(MYSQL_BACKUPS_DIR)/latest-dump.sql

test:
	@docker exec -it mysql mysql -u root --password=12345678 myorange "SHOW VARIABLES LIKE 'max_allowed_packet'"