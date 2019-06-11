<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611072125 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE score_board (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, rank INT DEFAULT NULL, played_match INT DEFAULT NULL, win INT DEFAULT NULL, lose INT DEFAULT NULL, draw INT DEFAULT NULL, home_goals INT DEFAULT NULL, away_goals INT DEFAULT NULL, average INT DEFAULT NULL, point INT DEFAULT NULL, UNIQUE INDEX UNIQ_E11AE7CF296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE score_board ADD CONSTRAINT FK_E11AE7CF296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE28CDC89C FOREIGN KEY (home_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE8DEF089F FOREIGN KEY (away_id) REFERENCES team (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE28CDC89C');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE8DEF089F');
        $this->addSql('ALTER TABLE score_board DROP FOREIGN KEY FK_E11AE7CF296CD8AE');
        $this->addSql('DROP TABLE score_board');
        $this->addSql('DROP TABLE team');
    }
}
