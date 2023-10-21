<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{


    /**
     * @var Model
     */
    protected $model;
    private $paginate;

    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $model
     */
    public function __construct(Employee $model)
    {
        $this->model = $model;
        $this->paginate = 12;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function createWithDetails(array $data, array $equipments_array, array $papers_array)
    {
    }


    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }


    public function all(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->with(['reports_to_minimum','department','gender'])
            ->get();
    }


    public function allMinimum(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->select('id', 'name', 'title', 'reports_to_id', 'image')
            ->with(['reports_to_minimum'])
            ->get();
    }

    public function paginate(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->with(['reports_to_minimum'])
            ->paginate($this->paginate);
    }

    public function archive(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->onlyTrashed()
            ->with(['reports_to_minimum','deleted_by'])
            ->get();
    }


    public function archivePaginate(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->onlyTrashed()
            ->with(['reports_to_minimum','deleted_by'])
            ->paginate($this->paginate);
    }

    public function groupBy(string $column)
    {
        return $this->model
            ->select('id', 'name', 'email', 'temp_reports_to_email')
            ->get()
            ->groupBy($column);
    }


    public function getWhereFirst(array $data)
    {
        return $this->model
            ->where($data)
            ->with(['reports_to_minimum'])
            ->first();
    }

    public function getEmailsInvitations(string $subdomain)
    {
        return $this->model
            ->where('email', 'LIKE', '%' . $subdomain)
            ->whereNull('password')
            ->select('id', 'name', 'email')
            ->get();
    }


    public function getAllWhereDomain(string $value)
    {
        return $this->model
            ->where('email', 'LIKE', '%' . $value)
            ->get();
    }


    public function getWhereAll(array $data)
    {
        return $this->model
            ->where($data)
            ->with(['reports_to_minimum'])
            ->all();
    }

    public function get(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->with('department', 'reports_to_minimum')
            ->withTrashed()
            ->first();
    }

    public function getMinimum(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->select('id', 'name', 'title', 'reports_to_id', 'image')
            ->withTrashed()
            ->first();
    }

    public function getWhereInIds(array $ids)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->with('department', 'reports_to_minimum','gender')
            ->withTrashed()
            ->get();
    }

    public function getWhereAllMinimum(array $data)
    {
        return $this->model
            ->where($data)
            ->select('id', 'name', 'title', 'reports_to_id', 'image')
            ->get();
    }


    public function getWithDetails(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->with('department.company', 'reports_to_minimum')
            ->withTrashed()
            ->first();
    }
    public function updateWhere(array $condition, array $data)
    {
        return $this->model
            ->where($condition)
            ->update($data);
    }

    public function updateWhereIn(array $ids, array $data)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->update($data);
    }


    public function getEmployeeByEmail($email)
    {
        $Employee = $this->model->where('email', $email)->first();
        return $Employee;
    }

    public function updatePassword($id, $hash)
    {
        $Employee = $this->model->whereId($id)->update([
            'password' => $hash,
        ]);
        return $Employee;
    }

    public function updateIsFirstTime($id, $is_first_time)
    {
        return $this->model->whereId($id)->update([
            'is_first_time' => $is_first_time,
        ]);
    }

    public function updateEmployeeData($id, $country_code, $phone, $date_of_birth)
    {
        return $this->model->whereId($id)->update([
            'country_code' => $country_code,
            'phone' => $phone,
            'date_of_birth' => $date_of_birth
        ]);
    }

    public function updateEmployeeProfileImage($id, $profile_image)
    {
        return $this->model->whereId($id)->update([
            'image' => $profile_image,
        ]);
    }

    public function select(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->select('id', 'name', 'image')
            ->get();
    }

    public function selectArchive(int $company_id)
    {
        return $this->model
            ->where('company_id', $company_id)
            ->select('id', 'name', 'image')
            ->onlyTrashed()
            ->get();
    }

    public function softDelete(int $id)
    {
        return $this->model
            ->find($id)
            ->delete($id);
    }

    public function destroy(int $id)
    {
        return $this->model
            ->find($id)
            ->delete($id);
    }

    public function restore(int $id)
    {
        return $this->model
            ->withTrashed()
            ->find($id)
            ->restore();
    }

    public function update(array $data, int $id)
    {
        return $this->model
            ->withTrashed()
            ->find($id)
            ->update($data);
    }

    public function multiDelete(array $ids)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->delete();
    }

    public function forceDelete(int $id)
    {
        return $this->getMinimum($id)
            ->forceDelete($id);
    }


    private function handleSort($query, $sort)
    {
        if ($sort == 'newest')
            return $query->orderBy('created_at', 'desc');

        return $query->orderBy('created_at', 'asc');
    }

    private function handleIsComplete($query, $is_complete)
    {
        if ($is_complete == 1) {
            return $query->where([
                'is_personal_information_complete' => 1,
                'is_work_information_complete' => 1,
                'is_vacations_complete' => 1,
            ]);
        } else if (is_null($is_complete)) {
            return $query;
        } else {
            // return $query->where('is_personal_information_complete', 0)
            //     ->orWhere('is_work_information_complete', 0)
            //     ->orWhere('is_vacations_complete', 0);
        }
    }




    public function search(int $company_id, $from, $to, $department_id, $is_complete, $sort, $paginate = 1)
    {
       
        $query = $this->model->where('company_id', $company_id);
        is_null($from) ? null:  $query->whereBetween('created_at', [$from, $to]);
        is_null($department_id) ? null : $query->where('department_id', $department_id);
        is_null($is_complete) ? null : $query->where('is_personal_information_complete', $is_complete);
        // $query = $this->handleIsComplete($query, $is_complete);
        $query = $this->handleSort($query, $sort);
        $query = $query->with(['reports_to_minimum'],'department','gender');
        return $paginate == 1 ?  $query->paginate($this->paginate) : $query->get();
    }


    public function searchArchive(int $company_id, $from, $to, $sort, $paginate = 1)
    {
        $query = $this->model->where('company_id', $company_id);
        $query = $query->whereBetween('created_at', [$from, $to]);
        $query = $this->handleSort($query, $sort);
        return $paginate == 1 ?  $query->onlyTrashed()->paginate($this->paginate) : $query->onlyTrashed()->get();
    }
}
