<?php
namespace Sizzle\Database;

/**
 * This class is for interacting with the recruiting_company_image table.
 */
class RecruitingCompanyImage extends \Sizzle\DatabaseEntity
{
    protected $recruiting_company_id;
    protected $file_name;

    /**
     * This function creates an entry in the recruiting_company_image table
     *
     * @param int    $recruiting_company_id - id of the company
     * @param string $file_name             - name of image file
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_company_id, $file_name)
    {
        $this->unsetAll();
        $this->recruiting_company_id = $recruiting_company_id;
        $this->file_name = $file_name;
        $this->save();
        return $this->id;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param int $recruiting_token_id - id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenId($recruiting_token_id)
    {
        $return = array();
        $recruiting_token_id = (int) $recruiting_token_id;
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image, recruiting_token
                  WHERE recruiting_company_image.recruiting_company_id = recruiting_token.recruiting_company_id
                  AND recruiting_token.id = '$recruiting_token_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param string $long_id - long id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenLongId($long_id)
    {
        $return = array();
        $long_id = escape_string($long_id);
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image, recruiting_token
                  WHERE recruiting_company_image.recruiting_company_id = recruiting_token.recruiting_company_id
                  AND recruiting_token.long_id = '$long_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param int $id - company id of the company to get images for
     *
     * @return array - images associated with the company
     */
    public function getByCompanyId($id)
    {
        $return = array();
        $id = (int) $id;
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image
                  WHERE recruiting_company_image.recruiting_company_id = '$id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function deletes the database entry & the image file
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;

        // Delete from file system
        $cwd = getcwd();
        $full_path = FILE_STORAGE_PATH.$this->file_name;
        if (file_exists($full_path)) {
            $success = unlink($full_path);
        }

        // Delete from database
        if (isset($this->id)) {
            // delete from db
            $sql = "DELETE FROM recruiting_company_image WHERE id = {$this->id}";
            execute($sql);
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key=>$value) {
                unset($this->$key);
            }
        }
        return $success;
    }
}
