<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Repositories\Projects\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    protected $projectRepository;

    // Inject repository vào controller
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'start_date', 'end_date', 'owner']);

        $projects = $this->projectRepository->getAllProjects($filters);

        return $this->apiResponse($projects, 'Thành công', 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,completed,on_hold',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'owner_id' => 'required|exists:users,id',
        ]);

        $project =  $this->projectRepository->createProject($validated);
        return $this->apiResponse($project, 'Tạo dự án mới thành công', 201);
    }

    public function show(Project $project)
    {
        $project = $this->projectRepository->findProjectById($project->id);

        if (!$project)  return $this->apiResponse($project, 'Không tìm thấy dự án', 404);

        return $this->apiResponse($project, 'Lấy thông tin dự án', 200);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,active,completed,on_hold',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'owner_id' => 'sometimes|exists:users,id',
        ]);

        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return $this->apiResponse(null, 'Thành công', 200);
    }
}
