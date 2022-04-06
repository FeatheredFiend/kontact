<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916101946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX address_unique ON address');
        $this->addSql('ALTER TABLE address CHANGE addressline6 addressline6 VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX address_unique ON address (addressline1, addressline2, addressline3, addressline4, addressline5, addressline6)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX address_unique ON address');
        $this->addSql('ALTER TABLE address CHANGE addressline6 addressline6 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX address_unique ON address (addressline1, addressline2, addressline3, addressline4, addressline5)');
    }
}
