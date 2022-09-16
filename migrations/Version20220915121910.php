<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915121910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating logs table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
CREATE TABLE logs(
   id VARCHAR(36) NOT NULL,
   service VARCHAR (50) NOT NULL,      
   date DATETIME NOT NULL,      
   method VARCHAR (6) NOT NULL,      
   path VARCHAR (100) NOT NULL,      
   code VARCHAR (3) NOT NULL,
   current_line_number INT,     
   PRIMARY KEY (id)
);        
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
