<?php

namespace App\Repositories;

interface EmailRepositoryInterface
{
    public function getList();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
