<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126094047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wine CHANGE name name VARCHAR(255) NOT NULL, CHANGE vintage vintage VARCHAR(4) DEFAULT NULL, CHANGE grape grape VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE region region VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE wine CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE vintage vintage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'2000\'\'\' COLLATE `utf8mb4_unicode_ci`, CHANGE grape grape VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' COLLATE `utf8mb4_general_ci`, CHANGE country country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' COLLATE `utf8mb4_unicode_ci`, CHANGE region region VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' COLLATE `utf8mb4_unicode_ci`, CHANGE image_path image_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'test\'\'\' COLLATE `utf8mb4_unicode_ci`');
    }
}
