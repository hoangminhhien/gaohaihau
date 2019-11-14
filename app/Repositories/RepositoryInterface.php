<?php
namespace App\Repositories;

interface RepositoryInterface
{
    public function all();
    public function find($id = null);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getWithPagination($query, $page = 1, $limit = null);
}