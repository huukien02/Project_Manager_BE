<?php

namespace App\Repositories\Projects;

interface ProjectRepositoryInterface
{
    public function getAllProjects(array $filters);

    public function findProjectById(int $id);

    public function createProject(array $data);

    public function updateProject(int $id, array $data);

    public function deleteProject(int $id): bool;
}
