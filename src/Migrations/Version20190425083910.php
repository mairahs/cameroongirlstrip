<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190425083910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad_ad_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ad_ad_option ADD PRIMARY KEY (ad_id, ad_option_id)');
        $this->addSql('ALTER TABLE ad_ad_option RENAME INDEX idx_e9245dbe4f34d596 TO IDX_4150DD9C4F34D596');
        $this->addSql('ALTER TABLE ad_ad_option RENAME INDEX idx_e9245dbe21fdd7b6 TO IDX_4150DD9C21FDD7B6');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad_ad_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ad_ad_option ADD PRIMARY KEY (ad_option_id, ad_id)');
        $this->addSql('ALTER TABLE ad_ad_option RENAME INDEX idx_4150dd9c21fdd7b6 TO IDX_E9245DBE21FDD7B6');
        $this->addSql('ALTER TABLE ad_ad_option RENAME INDEX idx_4150dd9c4f34d596 TO IDX_E9245DBE4F34D596');
    }
}
