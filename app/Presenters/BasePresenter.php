<?php


namespace App\Presenters;


use Jenssegers\Mongodb\Eloquent\Model;

abstract class BasePresenter
{
    // текущая модель
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }

}