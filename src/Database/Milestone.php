<?php
namespace Sizzle\Database;

/**
 * This class is for interacting with the milestone table.
 */
class Milestone extends \Sizzle\DatabaseEntity
{
    protected $name;

    /**
     * This function constructs the class from a valid id or name.
     * Fails silently for invalid input.
     *
     * @param mixed $milestone - name or id of milestone
     */
    public function __construct($milestone)
    {
        // see if it's a name or id
        if ((int)$milestone > 0) {
            $query = "SELECT id, name, created
                      FROM milestone
                      WHERE id = '$milestone'";
        } else {
            $milestone = escape_string($milestone);
            $query = "SELECT id, name, created
                      FROM milestone
                      WHERE name = '$milestone'";
        }

        $result = execute_query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created = $row['created'];
        }
    }
}
