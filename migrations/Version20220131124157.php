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
        $passwordHash = '$2y$10$Dv1Klg1u6mTtKIlHfLBW3.MSoVcndGBtYxJsn.vnsG9dq7AycaPt.';
        $this->addSql("INSERT INTO public.\"user\" (username,roles,password) VALUES ('admin','{}'::json,'$passwordHash');");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM public."user" WHERE id=1;');
    }
}
