<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309125958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket_comments (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, people_id INT NOT NULL, comment VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, is_private TINYINT(1) NOT NULL, INDEX IDX_DAF76AAB700047D2 (ticket_id), INDEX IDX_DAF76AAB3147C936 (people_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE people (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, assignee_id INT NOT NULL, customer_id INT NOT NULL, line INT NOT NULL, status INT NOT NULL, priority INT NOT NULL, subject VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, INDEX IDX_54469DF459EC7D60 (assignee_id), INDEX IDX_54469DF49395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_comments ADD CONSTRAINT FK_DAF76AAB700047D2 FOREIGN KEY (ticket_id) REFERENCES tickets (id)');
        $this->addSql('ALTER TABLE ticket_comments ADD CONSTRAINT FK_DAF76AAB3147C936 FOREIGN KEY (people_id) REFERENCES people (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF459EC7D60 FOREIGN KEY (assignee_id) REFERENCES people (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF49395C3F3 FOREIGN KEY (customer_id) REFERENCES people (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket_comments DROP FOREIGN KEY FK_DAF76AAB3147C936');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF459EC7D60');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF49395C3F3');
        $this->addSql('ALTER TABLE ticket_comments DROP FOREIGN KEY FK_DAF76AAB700047D2');
        $this->addSql('DROP TABLE ticket_comments');
        $this->addSql('DROP TABLE people');
        $this->addSql('DROP TABLE tickets');
    }
}
