<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309153019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket_comments DROP FOREIGN KEY FK_DAF76AAB3147C936');
        $this->addSql('DROP INDEX IDX_DAF76AAB3147C936 ON ticket_comments');
        $this->addSql('ALTER TABLE ticket_comments CHANGE people_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket_comments ADD CONSTRAINT FK_DAF76AABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DAF76AABA76ED395 ON ticket_comments (user_id)');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF459EC7D60');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF49395C3F3');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF459EC7D60 FOREIGN KEY (assignee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF49395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket_comments DROP FOREIGN KEY FK_DAF76AABA76ED395');
        $this->addSql('DROP INDEX IDX_DAF76AABA76ED395 ON ticket_comments');
        $this->addSql('ALTER TABLE ticket_comments CHANGE user_id people_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket_comments ADD CONSTRAINT FK_DAF76AAB3147C936 FOREIGN KEY (people_id) REFERENCES people (id)');
        $this->addSql('CREATE INDEX IDX_DAF76AAB3147C936 ON ticket_comments (people_id)');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF459EC7D60');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF49395C3F3');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF459EC7D60 FOREIGN KEY (assignee_id) REFERENCES people (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF49395C3F3 FOREIGN KEY (customer_id) REFERENCES people (id)');
    }
}
