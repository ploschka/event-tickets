<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102024508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Ticket (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, event_date VARCHAR(10) NOT NULL, ticket_adult_price INT NOT NULL, ticket_adult_quantity INT NOT NULL, ticket_kid_price INT NOT NULL, ticket_kid_quantity INT NOT NULL, barcode VARCHAR(120) NOT NULL, equal_price INT NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_900CA89597AE0266 (barcode), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Ticket');
    }
}
