<?php 
namespace App\Repositories;
use Closure;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements BaseRepositoryInterface {
    protected $model;
	protected $query;
	protected $take;
	protected $whereById;
	protected $with = array();
	protected $wheres = array();
	protected $whereNull = array();
	protected $whereIns = array();
	protected $orderBys = array();
	protected $scopes = array();
    protected $whereHas = array();
    public function all()
	{
		$this->newQuery()->eagerLoad();
		$models = $this->query->get();
		$this->unsetClauses();
		return $models;
	}
	public function count()
	{
		return $this->get()->count();
	}
	public function create(array $data)
	{
		$this->unsetClauses();
		return $this->model->create($data);
	}
	public function createMultiple(array $data)
	{
		$models = new Collection();
		foreach($data as $d)
		{
			$models->push($this->create($d));
		}
		return $models;
	}
	public function delete()
	{
		$this->newQuery()->setClauses()->setScopes();
		$result = $this->query->delete();
		$this->unsetClauses();
		return $result;
	}
	public function deleteById($id)
	{
		$this->unsetClauses();

		return $this->getById($id)->delete();
	}
	public function deleteMultipleById(array $ids)
	{
		return $this->model->destroy($ids);
	}
	public function first()
	{
		$this->newQuery()->eagerLoad()->setClauses()->setScopes();

		$model = $this->query->firstOrFail();

		$this->unsetClauses();

		return $model;
	}
	public function get()
	{
		$this->newQuery()->eagerLoad()->setClauses()->setScopes();
		$models = $this->query->get();
		$this->unsetClauses();
		return $models;
	}
	public function getById($id)
	{
		$this->unsetClauses();
		$this->newQuery()->eagerLoad();
		return $this->query->findOrFail($id);
	}
	public function limit($limit)
	{
		$this->take = $limit;
		return $this;
	}
    public function orderBy($column, $direction = 'asc')
	{
		$this->orderBys[] = compact('column', 'direction');
		return $this;
	}
	public function updateById($id, array $data)
	{
		$this->unsetClauses();
		$model = $this->getById($id);
		$model->update($data);
		return $model;
	}
	public function where($column, $value, $operator = '=')
	{
		$this->wheres[] = compact('column', 'value', 'operator');
		return $this;
	}
	public function whereById($column, $value, $operator = '=')
	{
		$this->whereById = compact('column', 'value', 'operator');
		return $this;
	}
	public function whereNull($column)
	{
		$this->whereNull[] = compact('column');
		return $this;
	}
	public function whereIn($column, $values)
	{
		$values = is_array($values) ? $values : array($values);
		$this->whereIns[] = compact('column', 'values');
		return $this;
	}
	public function with($relations)
	{
		if (is_string($relations)) $relations = func_get_args();

		$this->with = $relations;

		return $this;
	}
	protected function newQuery()
	{
		$this->query = $this->model->newQuery();
		return $this;
	}
	protected function eagerLoad()
	{
		foreach($this->with as $relation)
		{
			$this->query->with($relation);
		}
		return $this;
	}
	protected function setClauses()
	{
		foreach($this->wheres as $where)
		{
			$this->query->where($where['column'], $where['operator'], $where['value']);
		}
		foreach($this->whereIns as $whereIn)
		{
			$this->query->whereIn($whereIn['column'], $whereIn['values']);
		}
		foreach($this->orderBys as $orders)
		{
			$this->query->orderBy($orders['column'], $orders['direction']);
		}

		if(isset($this->take) and ! is_null($this->take))
		{
			$this->query->take($this->take);
		}

		return $this;
	}
	protected function setScopes()
	{
		foreach($this->scopes as $method => $args)
		{
			$this->query->$method(implode(', ', $args));
		}
		return $this;
	}
	protected function unsetClauses()
	{
		$this->wheres   = array();
		$this->whereIns = array();
		$this->scopes   = array();
		$this->take     = null;
		return $this;
	}
    public function whereHas($relation, Closure $callback = null, $operator = '>=', $count = 1){                
        $this->whereHas[] = [$relation, $callback, $operator ?: '>=', $count ?: 1];        
        return $this;
    }   

}
