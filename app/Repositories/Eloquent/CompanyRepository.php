<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CompanyRepository constructor.
     *
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function store($name, $domain, $industry_id, $logo = '', $plan_id = 0)
    {
        $industry = $this->model->create([
            'name' => $name,
            'domain' => $domain,
            'industry_id' => $industry_id,
            'logo' => $logo,
            'plan_id' => $plan_id,
        ]);

        return $industry;
    }

    public function get(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->first();
    }

    public function update(int $id, array $data)
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }
    
    public function subscribeToPlan($id, $plan_id)
    {
        $company = $this->model->whereId($id)->update(['plan_id' => $plan_id]);
        return $company;
    }

    public function getDomains()
    {
        $domains = $this->model->get(['id', 'name', 'domain']);
        return $domains;
    }


    public function findByDomain($domain)
    {
        return $this->model->where('domain', $domain)->first();
    }


    public function delete($companyId)
    {
        return $this->model->where('id', $companyId)->delete();
    }


    public function updateOrCreate($name, $domain, $industry_id, $logo = '', $plan_id = 0)
    {
        return $this->model->updateOrCreate([
            'domain' => $domain,
        ],[
            'name' => $name,
            'industry_id' => $industry_id,
            'logo' => $logo,
            'plan_id' => $plan_id,
        ]);
    }
}
