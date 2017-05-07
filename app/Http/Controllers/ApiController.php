<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 03/05/17
 * Time: 20:11
 */

namespace App\Http\Controllers;


use App\Transformers\AbstractTransformer;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ApiController extends Controller
{

    /**
     * @var Model
     */
    protected $_model;

    /**
     * @var AbstractTransformer
     */
    protected $_transformer;

    /**
     * @var Manager
     */
    protected $_fractal;

    public function __construct()
    {
        $this->_fractal = new Manager();
    }

    protected function transform($result, TransformerAbstract $transform = null) {


        if (is_null($transform)) {
            if (!$this->_transform) {
                throw new \Exception('You have to define at last one transforme to this repository '. __CLASS__);
            }

            $transform = $this->_transform;
        }

        $data = $result;

        if ($result instanceof LengthAwarePaginator) {
            $data = $result->getCollection();
        }

        if ($result instanceof Model) {
            // TODO para row
            $resource = new Item($data, $transform);
        } else {
            $resource = new Collection($data, $transform);
        }

        if ($result instanceof LengthAwarePaginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($result));
        }

        $dataTransformed = $this->_fractal->createData($resource)->toArray();

        if ($result instanceof LengthAwarePaginator) {
            return $result->setCollection(collect(json_decode(json_encode($dataTransformed['data']), false)));
        }

        if ($result instanceof Model) {
            return $dataTransformed['data'];
        }

        return json_decode(json_encode($dataTransformed['data']), false);
    }

    /**
     * Method how receive a $_POST or $_GET array to be mapped like the database table
     *
     * @param $data
     * @return mixed
     */
    protected function prepare(array $data)
    {
        if (!$this->_transformer) {
            throw new \Exception('You have to define at last one transforme to this repository '. __CLASS__);
        }

        $prepared = [];
        $arrayMap = array_flip($this->_transformer->arrayMap);

        array_walk($arrayMap, function($val, $key) use ($data, &$prepared) {
            if (isset($data[$val])) {
                $prepared[$key] = $data[$val];
            }
        });

        return $prepared;
    }

    public function _validate($vo, $request)
    {
        return Validator::make($request, [], []);
    }

}