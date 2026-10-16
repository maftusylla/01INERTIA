<?php
namespace App\DTOs\Groupe;

final readonly class GenerateGroupData
{
    public function __construct(
        public int $tailleGroupe,
    ) {}
}
