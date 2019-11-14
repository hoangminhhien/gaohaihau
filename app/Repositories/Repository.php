<?php
namespace App\Repositories;
use App\Repositories\RepositoryInterface;

class Repository implements RepositoryInterface
{
    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // find record in the database by id
    public function find($id = null)
    {
        $record = $this->model->find($id);
        return $record;
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->find($id)->delete();;
    }

    // Pagination
    public function getWithPagination($query, $page = 1, $limit = null) {
        $result = [
            'count' => $query->count(),
            'data' => []
        ];

        if(!$limit) {
            $limit = config('common.paginateLimit');
        }

        $result['data'] = $query->take($limit);
        $skip = ($page - 1) * $limit;

        if($skip) {
            $result['data'] = $result['data']->skip($skip);
        }

        $result['data'] = $result['data']->get();

        return $result;
    }
}