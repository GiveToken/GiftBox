<?php
namespace Sizzle\Database;

class City extends \Sizzle\DatabaseEntity
{
    protected $name;
    protected $image_file;
    protected $population;
    protected $longitude;
    protected $latitude;
    protected $county;
    protected $country;
    protected $timezone;
    protected $temp_hi_spring;
    protected $temp_lo_spring;
    protected $temp_avg_spring;
    protected $temp_hi_summer;
    protected $temp_lo_summer;
    protected $temp_avg_summer;
    protected $temp_hi_fall;
    protected $temp_lo_fall;
    protected $temp_avg_fall;
    protected $temp_hi_winter;
    protected $temp_lo_winter;
    protected $temp_avg_winter;

    /**
     * Gets the city id given the city name
     *
     * @param string $name - the name of the city to pull from the database
     *
     * @return int - the id of the named city
     */
    public static function getIdFromName($name)
    {
        $sql = "SELECT id FROM city WHERE name = '$name'";
        $id = execute_query($sql)->fetch_object()->id;
        return $id;
    }

    /**
     * Inserts or updates a city in the database
     *
     * @return boolean - success of update or insert
     */
    public function save()
    {
        if (!$this->id) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    /**
     * Inserts a city into the database if all required fields are set
     *
     * @return boolean - success of insert
     */
    protected function insert()
    {
        $success = true;

        // check for required columns
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $this->readOnly)) {
                $success = $success && isset($value);
            }
        }
        if ($success) {
            parent::insertRow();
            if ($success = $success && ((int) $this->id > 0)) {
                $sql = "SELECT created
                      FROM {$this->tableName()}
                      WHERE id = $this->id";
                $this->created = execute_query($sql)->fetch_object()->created;
            }
        }

        // return results
        return $success;
    }

    /**
     * Updates a city in the database
     *
     * @return boolean - success of update
     */
    protected function update()
    {
        $success = false;
        return $success;
    }

    /**
     * Gets a list of possible cities from first part.
     *
     * @param string $part - partially typed city name
     *
     * @return array - 10 or fewer matches; none if there's more
     */
    public function match10($part)
    {
        $part = escape_string($part);
        $cities = execute_query(
            "SELECT * FROM city
             WHERE name LIKE '$part%'
             ORDER BY name"
        )->fetch_all(MYSQLI_ASSOC);
        if (count($cities) < 11) {
            return $cities;
        } else {
            return [];
        }
    }

    /**
     * Deletes from the database using $this->id
     */
    public function delete()
    {
        $table_name = substr(get_class(), strrpos(get_class(), '\\')+1);
        $sql = "DELETE FROM {$this->tableName()} WHERE id = '$this->id'";
        execute($sql);
    }
}
