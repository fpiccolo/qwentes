<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928101217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', address_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', givenName VARCHAR(255) NOT NULL, familyName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_address (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', coordinates_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postalCode VARCHAR(255) NOT NULL, countryCode VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5543718B158B0682 (coordinates_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_address_coordinates (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', lat VARCHAR(255) NOT NULL, lng VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES user_address (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718B158B0682 FOREIGN KEY (coordinates_id) REFERENCES user_address_coordinates (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718B158B0682');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('DROP TABLE user_address_coordinates');
    }
}
