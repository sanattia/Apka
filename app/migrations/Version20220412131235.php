<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412131235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE odznaki (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, punkty INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regiony (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trasy (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, trudnosc_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, points INT NOT NULL, punkt_startowy VARCHAR(255) NOT NULL, punkt_koncowy VARCHAR(255) NOT NULL, czas TIME DEFAULT NULL, INDEX IDX_6F989BBF98260155 (region_id), INDEX IDX_6F989BBF159FB904 (trudnosc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trasy_tags (trasa_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_DB2A837D518F4BA5 (trasa_id), INDEX IDX_DB2A837DBAD26311 (tag_id), PRIMARY KEY(trasa_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trudnosci (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_odznaki (user_id INT UNSIGNED NOT NULL, odznaka_id INT NOT NULL, INDEX IDX_101E682DA76ED395 (user_id), INDEX IDX_101E682D13204B24 (odznaka_id), PRIMARY KEY(user_id, odznaka_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wpisy (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, zdjecie VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE trasy ADD CONSTRAINT FK_6F989BBF98260155 FOREIGN KEY (region_id) REFERENCES regiony (id)');
        $this->addSql('ALTER TABLE trasy ADD CONSTRAINT FK_6F989BBF159FB904 FOREIGN KEY (trudnosc_id) REFERENCES trudnosci (id)');
        $this->addSql('ALTER TABLE trasy_tags ADD CONSTRAINT FK_DB2A837D518F4BA5 FOREIGN KEY (trasa_id) REFERENCES trasy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trasy_tags ADD CONSTRAINT FK_DB2A837DBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_odznaki ADD CONSTRAINT FK_101E682DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_odznaki ADD CONSTRAINT FK_101E682D13204B24 FOREIGN KEY (odznaka_id) REFERENCES odznaki (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_odznaki DROP FOREIGN KEY FK_101E682D13204B24');
        $this->addSql('ALTER TABLE trasy DROP FOREIGN KEY FK_6F989BBF98260155');
        $this->addSql('ALTER TABLE trasy_tags DROP FOREIGN KEY FK_DB2A837DBAD26311');
        $this->addSql('ALTER TABLE trasy_tags DROP FOREIGN KEY FK_DB2A837D518F4BA5');
        $this->addSql('ALTER TABLE trasy DROP FOREIGN KEY FK_6F989BBF159FB904');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE users_odznaki DROP FOREIGN KEY FK_101E682DA76ED395');
        $this->addSql('DROP TABLE odznaki');
        $this->addSql('DROP TABLE regiony');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE trasy');
        $this->addSql('DROP TABLE trasy_tags');
        $this->addSql('DROP TABLE trudnosci');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_odznaki');
        $this->addSql('DROP TABLE wpisy');
    }
}
