<?php
namespace Slimvc\Core;

/**
 * Base Abstract Object class
 *
 */
class Object
{

    protected $data = array();

    /**
     * The function is used to get data, it will be following data returns,
     *
     * 1. data of the related field for a valid field name
     * 2. data list for all fields for empty field name
     *
     * @param string $field the name of the field
     *
     * @return multitype: null | array
     */
    public function getData($field = '')
    {
        if (empty($field)) {
            return $this->data;
        } else
            if (isset($this->data[$field])) {
                return $this->data[$field];
            } else {
                return null;
            }
    }

    /**
     * Add data to the object, and retains previous data in the object.
     *
     * @param array $data the data array list
     *
     * @return Object
     */
    public function addData(array $data)
    {
        foreach ($data as $field => $value) {
            $this->setData($field, $value);
        }
        return $this;
    }

    /**
     * The function is used to set data, the field value could be an array, then
     * the full value will be assigned to data array
     *
     * @param mixed $field the name of the field/a list of data array
     * @param mixed $value the field value
     *
     * @return Object
     */
    public function setData($field, $value = null)
    {
        if (is_assoc_array($field)) {
            $this->data = $field;
        } else
            if (is_string($field)) {
                $this->data[$field] = $value;
            } else {
                // do nothing here
                throw new \RuntimeException("Invalid field value assigned (must be string or associated array)");
            }
        return $this;
    }

    /**
     * Unsets data associated with the object, all data will be unset if an empty
     * field name assigned
     *
     * @param string $field the field name
     *
     * @return Object
     */
    public function unsetData($field = '')
    {
        if (empty($field)) {
            $this->data = array();
        } else {
            unset($this->data[$field]);
        }
        return $this;
    }

    /**
     * Indicates if current data array list is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        if (empty($this->data)) {
            return true;
        }
        return false;
    }

    /**
     * the magic method to implement getXXX(), setXXX(), delXXX(), hasXXX() methods
     *
     * @param string $method the method name
     * @param array  $args   the related arguments
     * @throws \Exception
     * @return Ambigous <\Slimvc\Core\multitype:, NULL, multitype:>|Ambigous <object, \Slimvc\Core\Object>|boolean
     */
    public function __call($method, $args)
    {
        $prefix = substr($method, 0, 3);
        $name = substr($method, 3);
        $field = underscore($name);

        switch ($prefix) {
            case 'get': // get
                $data = $this->getData($field);
                return $data;

            case 'set': // set
                $result = $this->setData($field, isset($args[0]) ? $args[0] : null);
                return $result;

            case 'del': // unset
                $result = $this->unsetData($field);
                return $result;

            case 'has': // isset
                return isset($this->data[$field]) ? true : false;
            default:
                throw new \Exception("Calling method '" . $name . "' not found");
                break;
        }
    }

    /**
     * Returns the object data as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Returns the object data as json string
     *
     * @param options int[optional]
     *
     * @return array
     */
    public function toJson($options = null)
    {
        return json_encode($this->data, $options);
    }
}
