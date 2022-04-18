<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412141102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wpisy ADD trasa_id INT DEFAULT NULL, ADD author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE wpisy ADD CONSTRAINT FK_8C22785C518F4BA5 FOREIGN KEY (trasa_id) REFERENCES trasy (id)');
        $this->addSql('ALTER TABLE wpisy ADD CONSTRAINT FK_8C22785CF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_8C22785C518F4BA5 ON wpisy (trasa_id)');
        $this->addSql('CREATE INDEX IDX_8C22785CF675F31B ON wpisy (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wpisy DROP FOREIGN KEY FK_8C22785C518F4BA5');
        $this->addSql('ALTER TABLE wpisy DROP FOREIGN KEY FK_8C22785CF675F31B');
        $this->addSql('DROP INDEX IDX_8C22785C518F4BA5 ON wpisy');
        $this->addSql('DROP INDEX IDX_8C22785CF675F31B ON wpisy');
        $this->addSql('ALTER TABLE wpisy DROP trasa_id, DROP author_id');
    }
}
