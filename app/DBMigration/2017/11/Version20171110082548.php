<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110082548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_list (id INT AUTO_INCREMENT NOT NULL, driver_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, phone VARCHAR(64) NOT NULL, pickup_address VARCHAR(255) NOT NULL, pickup_latitude DOUBLE PRECISION NOT NULL, pickup_longitude DOUBLE PRECISION NOT NULL, destination_address VARCHAR(255) NOT NULL, destination_latitude DOUBLE PRECISION NOT NULL, destination_longitude DOUBLE PRECISION NOT NULL, comment VARCHAR(255) DEFAULT NULL, status VARCHAR(24) NOT NULL, date_updated DATETIME NOT NULL, date_created DATETIME NOT NULL, INDEX IDX_939C20FC3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_list ADD CONSTRAINT FK_939C20FC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('DROP TABLE `order`');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, driver_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, phone VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, pickup_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, pickup_latitude DOUBLE PRECISION NOT NULL, pickup_longitude DOUBLE PRECISION NOT NULL, destination_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, destination_latitude DOUBLE PRECISION NOT NULL, destination_longitude DOUBLE PRECISION NOT NULL, comment VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, status VARCHAR(24) NOT NULL COLLATE utf8_unicode_ci, date_updated DATETIME NOT NULL, date_created DATETIME NOT NULL, INDEX IDX_F5299398C3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('DROP TABLE order_list');
    }
}
