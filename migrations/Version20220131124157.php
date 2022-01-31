<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131124157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO public.\"user\" (id,username,roles,password) VALUES (1,'admin','{}'::json,'admin');");

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM public."user" WHERE id=1;');
    }
}
