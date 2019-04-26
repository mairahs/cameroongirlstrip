<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426091836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip CHANGE cover_image file_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_user_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_user_option ADD PRIMARY KEY (user_id, user_option_id)');
        $this->addSql('ALTER TABLE user_user_option RENAME INDEX idx_cc86b53fa76ed395 TO IDX_96CFD218A76ED395');
        $this->addSql('ALTER TABLE user_user_option RENAME INDEX idx_cc86b53fa724908b TO IDX_96CFD218A724908B');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip CHANGE file_name cover_image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_user_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_user_option ADD PRIMARY KEY (user_option_id, user_id)');
        $this->addSql('ALTER TABLE user_user_option RENAME INDEX idx_96cfd218a724908b TO IDX_CC86B53FA724908B');
        $this->addSql('ALTER TABLE user_user_option RENAME INDEX idx_96cfd218a76ed395 TO IDX_CC86B53FA76ED395');
    }
}
