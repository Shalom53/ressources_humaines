<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Types\TypeStatus;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function liste()
    {
        return $this->model->where('etat', TypeStatus::ACTIF)->get();
    }

    public function rechercher(int $id)
    {
        return $this->model->where('id', $id)->where('etat', TypeStatus::ACTIF)->first();
    }

    public function ajouter(array $data)
    {
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        return $this->model->create($data);
    }

    public function modifier(int $id, array $data)
    {
        $data['updated_at'] = Carbon::now();

        $instance = $this->model->findOrFail($id);
        $instance->update($data);
        return $instance;
    }

    public function supprimer(int $id): bool
{
    $instance = $this->model->findOrFail($id);
    
    return $instance->update([
        'etat' => TypeStatus::SUPPRIME,
        'updated_at' => Carbon::now(),
    ]);
}
}
