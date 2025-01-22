<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250118160113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_restau CHANGE guests guests INT NOT NULL, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE reservations DROP validated');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD validated TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation_restau CHANGE guests guests INT DEFAULT 1 NOT NULL, CHANGE date date DATE DEFAULT \'2023-01-01\' NOT NULL');
    }
}
