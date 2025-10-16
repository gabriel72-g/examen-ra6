<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402215336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE instrumento (id INT AUTO_INCREMENT NOT NULL, imparte_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_F75182443D850628 (imparte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nombre_apellidos VARCHAR(255) NOT NULL, profesor TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario_instrumento (usuario_id INT NOT NULL, instrumento_id INT NOT NULL, INDEX IDX_CF7A70CADB38439E (usuario_id), INDEX IDX_CF7A70CA40B7B70 (instrumento_id), PRIMARY KEY(usuario_id, instrumento_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE instrumento ADD CONSTRAINT FK_F75182443D850628 FOREIGN KEY (imparte_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario_instrumento ADD CONSTRAINT FK_CF7A70CADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario_instrumento ADD CONSTRAINT FK_CF7A70CA40B7B70 FOREIGN KEY (instrumento_id) REFERENCES instrumento (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE instrumento DROP FOREIGN KEY FK_F75182443D850628
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario_instrumento DROP FOREIGN KEY FK_CF7A70CADB38439E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario_instrumento DROP FOREIGN KEY FK_CF7A70CA40B7B70
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE instrumento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario_instrumento
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
