<?php

namespace App\Http\Controllers\Api\Department;

use App\Models\User;
use App\Models\Department;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Department\Requests\StoreRequest;
use App\Http\Controllers\Api\Department\Requests\UpdateRequest;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    public $departments;

    /**
     * @var UserRepository
     */
    public $users;

    public function __construct(DepartmentRepository $departments, UserRepository $users)
    {
        $this->departments = $departments;
        $this->users = $users;
    }

    /**
     * Show paginated users.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $departments = $this->departments->newQuery()->with('users')->paginate(5);

        return response()->json(['departments' => $departments]);
    }

    /**
     * Show selected department data.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $user = $this->departments->newQuery()->with('users')->findOrFail($id);

        return response()->json(['department' => $user]);
    }

    /**
     * Create department
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $department = $this->departments->getModel();

        $department->name = $request->get('name');
        $department->description = $request->get('description');
        $department->logo = $request->get('logo');
        $department->save();

        //Check if need add users in department
        if($request->get('users')) {
            foreach ($request->get('users') as $userData) {
                $user = $this->users->findOrFail($userData['id']);
                //Add user
                $department->users()->attach($user->id);
            }
        }

        return response()->json(['department' => $department]);
    }

    /**
     * Update department
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $department = $this->departments->findOrFail($id);

        $department->name = $request->get('name');
        $department->description = $request->get('description');
        $department->logo = $request->get('logo');
        $department->save();

        //Check if need add users in department
        if($request->get('users')) {
            $usersIds = [];
            foreach ($request->get('users') as $userData) {
                $user = $this->users->findOrFail($userData['id']);
                $usersIds[$user->id] = $user->id;
            }
            //Add users
            $department->users()->sync($usersIds);
        }

        return response()->json(['department' => $department]);
    }

    /**
     * Delete department request
     *
     * @param int $id
     * @return JsonResponse
     * @throws
     */
    public function delete($id): JsonResponse
    {
        $department = $this->departments->findOrFail($id);

        //Remove all users from department
        $department->users()->detach();

        //Remove department
        $department->delete();

        $departments = $this->departments->paginate([], 5);

        return response()->json(['departments' => $departments]);
    }
}
