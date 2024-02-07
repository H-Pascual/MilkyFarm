<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205114500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B3DB38439E');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B3DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615DB38439E');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE user_image user_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_2265b05d3a909126 ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493A909126 ON user (nombre)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B3DB38439E');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B3DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615DB38439E');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE user CHANGE user_image user_image VARCHAR(255) DEFAULT \'avatar.png\'');
        $this->addSql('DROP INDEX uniq_8d93d6493a909126 ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D3A909126 ON user (nombre)');
    }
}
