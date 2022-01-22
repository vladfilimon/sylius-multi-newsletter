<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220126005910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds multiple newsletter subscriptions for shop users';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE newsletter_shopuser (shopuser_id INT NOT NULL, newsletter_id INT NOT NULL, INDEX IDX_8E01D9E7DBFF1294 (shopuser_id), INDEX IDX_8E01D9E722DB1917 (newsletter_id), PRIMARY KEY(shopuser_id, newsletter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newsletter_shopuser ADD CONSTRAINT FK_8E01D9E7DBFF1294 FOREIGN KEY (shopuser_id) REFERENCES sylius_shop_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_shopuser ADD CONSTRAINT FK_8E01D9E722DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE newsletter_shopuser DROP FOREIGN KEY FK_8E01D9E7DBFF1294');
        $this->addSql('ALTER TABLE sylius_user_oauth DROP FOREIGN KEY FK_C3471B78A76ED395');
        $this->addSql('ALTER TABLE newsletter_shopuser DROP FOREIGN KEY FK_8E01D9E722DB1917');
        $this->addSql('DROP TABLE newsletter_shopuser');
        $this->addSql('DROP TABLE newsletter');
    }
}
