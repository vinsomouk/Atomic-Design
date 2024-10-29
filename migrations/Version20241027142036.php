<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027142036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_module DROP CONSTRAINT fk_a6276607f5893f5c');
        $this->addSql('ALTER TABLE module_module DROP CONSTRAINT fk_a6276607ec6c6fd3');
        $this->addSql('DROP TABLE module_module');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE module_module (module_source INT NOT NULL, module_target INT NOT NULL, PRIMARY KEY(module_source, module_target))');
        $this->addSql('CREATE INDEX idx_a6276607ec6c6fd3 ON module_module (module_target)');
        $this->addSql('CREATE INDEX idx_a6276607f5893f5c ON module_module (module_source)');
        $this->addSql('ALTER TABLE module_module ADD CONSTRAINT fk_a6276607f5893f5c FOREIGN KEY (module_source) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE module_module ADD CONSTRAINT fk_a6276607ec6c6fd3 FOREIGN KEY (module_target) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
