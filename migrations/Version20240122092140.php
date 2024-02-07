<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122092140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, usuario_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, fecha DATE DEFAULT NULL, num_visualizaciones INT NOT NULL, num_likes INT NOT NULL, num_downloads INT NOT NULL, INDEX IDX_8319D2B33397707A (categoria_id), INDEX IDX_8319D2B3DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE miembro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, trabajo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, imagen VARCHAR(255) NOT NULL, precio INT NOT NULL, precio_antiguo INT NOT NULL, INDEX IDX_A7BB0615DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, user_image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2265B05D3A909126 (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B33397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B3DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B33397707A');
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B3DB38439E');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615DB38439E');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE miembro');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE usuario');
    }
}
