<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest\ProjectFilterRequest;
use App\Http\Requests\ProjectRequest\StoreProjectRequest;
use App\Http\Requests\ProjectRequest\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\Projects\ProjectRepositoryInterface;
use App\Traits\ApiResponseTrait;


class ProjectController extends Controller
{
    use ApiResponseTrait;
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(ProjectFilterRequest $request)
    {
        $filters = $request->only(['search', 'status', 'start_date', 'end_date', 'owner']);

        $projects = $this->projectRepository->getAllProjects($filters);

        return $this->apiResponse($projects, 'Thành công', 200);
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = $this->projectRepository->createProject($validated);

        if (!empty($validated['member_ids'])) {
            $project->members()->sync($validated['member_ids']);
        }

        return $this->apiResponse($project, 'Tạo dự án mới thành công', 201);
    }

    public function show(Project $project)
    {
        $project = $this->projectRepository->findProjectById($project->id);

        if (!$project)  return $this->apiResponse($project, 'Không tìm thấy dự án', 404);

        return $this->apiResponse($project, 'Lấy thông tin dự án', 200);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->update($validated);

        if (isset($validated['member_ids'])) {
            $project->members()->sync($validated['member_ids']);
        }

        return $this->apiResponse($project->load('members', 'owner'), 'Thành công', 200);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return $this->apiResponse(null, 'Thành công', 200);
    }
}
