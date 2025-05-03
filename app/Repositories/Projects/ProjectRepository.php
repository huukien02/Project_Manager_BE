<?php

namespace App\Repositories\Projects;

use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllProjects(array $filters)
    {
        $query = Project::with('owner')->latest();

        if (isset($filters['search']) && $filters['search']) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', 'like', '%' . $filters['status'] . '%');
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            dd($filters['start_date']);
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->whereDate('end_date', '<=', $filters['end_date']);
        }

        if (isset($filters['owner']) && $filters['owner']) {
            $query->whereHas('owner', function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['owner'] . '%');
            });
        }

        return $query->paginate(5);
    }

    public function findProjectById(int $id): ?Project
    {
        return Project::with('owner')->find($id);
    }

    // Tạo mới một dự án
    public function createProject(array $data): Project
    {
        return Project::create($data);
    }

    // Cập nhật thông tin dự án
    public function updateProject(int $id, array $data): Project
    {
        $project = Project::findOrFail($id);
        $project->update($data);

        return $project;
    }

    // Xóa một dự án
    public function deleteProject(int $id): bool
    {
        $project = Project::findOrFail($id);
        return $project->delete();
    }
}
