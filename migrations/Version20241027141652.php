<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027141652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN module.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE module_module (module_source INT NOT NULL, module_target INT NOT NULL, PRIMARY KEY(module_source, module_target))');
        $this->addSql('CREATE INDEX IDX_A6276607F5893F5C ON module_module (module_source)');
        $this->addSql('CREATE INDEX IDX_A6276607EC6C6FD3 ON module_module (module_target)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, token_api VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_module (user_id INT NOT NULL, module_id INT NOT NULL, PRIMARY KEY(user_id, module_id))');
        $this->addSql('CREATE INDEX IDX_69763D15A76ED395 ON user_module (user_id)');
        $this->addSql('CREATE INDEX IDX_69763D15AFC2B591 ON user_module (module_id)');
        $this->addSql('ALTER TABLE module_module ADD CONSTRAINT FK_A6276607F5893F5C FOREIGN KEY (module_source) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE module_module ADD CONSTRAINT FK_A6276607EC6C6FD3 FOREIGN KEY (module_target) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_module ADD CONSTRAINT FK_69763D15A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_module ADD CONSTRAINT FK_69763D15AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE module_module DROP CONSTRAINT FK_A6276607F5893F5C');
        $this->addSql('ALTER TABLE module_module DROP CONSTRAINT FK_A6276607EC6C6FD3');
        $this->addSql('ALTER TABLE user_module DROP CONSTRAINT FK_69763D15A76ED395');
        $this->addSql('ALTER TABLE user_module DROP CONSTRAINT FK_69763D15AFC2B591');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_module');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_module');
    }
}
