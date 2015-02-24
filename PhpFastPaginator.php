<?php

/**
 * The PFPaginator class, This is the main class for paging
 */
class PFPaginator
{

    /**
     * #@+
     * Constants
     */
    
    /**
     * constant default start page
     */
    const DEFAULT_START_PAGE = 1;

    /**
     * constant default quantity per page data
     */
    const DEFAULT_QUANTITY = 5;

    /**
     * All the private variables
     * option
     * 
     * @access private
     */
    private $db, $query, $table, $where, $bind, $page, $quantity, $limitStart, $limitEnd, $error;

    /**
     * All the protected variable
     * option
     * 
     * @access protected
     */
    protected $data, $menu;

    /**
     * Class Constructor
     */
    function __construct($pdoDb = null, $page = self::DEFAULT_START_PAGE, $quantity = self::DEFAULT_QUANTITY, $table = '', $where = '', $bind = null)
    {
        $this->menu = array();
        $this->data = array();
        
        (is_a($pdoDb, 'PDO')) ? $this->db = $pdoDb : $this->error = "PDO Instance not found!.";
        
        if ($this->error == "") {
            $this->table = $table;
            $this->where = $where;
            $this->bind = $bind;
            $this->page = $page;
            $this->quantity = $quantity;
            $this->limitStart = ($page > 1) ? ($page * $quantity) - $quantity : 0;
            $this->limitEnd = $quantity;
        } else
            throw new Exception("Error : " . $this->error);
        
        $this->retriveData();
    }

    /**
     * Return the page data
     * 
     * @param
     *            null
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return the paging menu information
     * 
     * @param
     *            null
     * @return array
     */
    public function getMenu()
    {
        $select = "SELECT count(*) as ALL_DATA_COUNT 
                 FROM " . $this->table . "
                 WHERE " . trim($this->where);
        $stmt = $this->db->prepare($select);
        $stmt->execute($this->bind);
        $tmpData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->menu['ALL_DATA_COUNT'] = $tmpData[0]['ALL_DATA_COUNT'];
        $this->menu['MAX_PAGINATION_INDEXES'] = ceil($tmpData[0]['ALL_DATA_COUNT'] / $this->quantity);
        $this->menu['ACTUAL_INDEX'] = $this->page;
        $this->menu['NEXT_INDEX'] = ($this->page == $this->menu['MAX_PAGINATION_INDEXES']) ? $this->page : $this->page + 1;
        $this->menu['PREVIOUS_INDEX'] = ($this->page > 1) ? $this->page - 1 : 1;
        
        return $this->menu;
    }

    /**
     * This function retrive the paging data
     * 
     * @param boolean $paramie            
     * @return integer|babyclass
     */
    private function retriveData()
    {
        // Add limit in the select query
        $this->createQuery();
        // Db call
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->bind);
        $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function allows, depending on the database used,
     * to add the limits to select in order to recover only the values required for paging.
     *
     * @param
     *            null
     * @return string
     */
    private function createQuery()
    {
        // Recovery the driver used by PDO class
        $driverName = $this->db->getAttribute(PDO::ATTR_DRIVER_NAME);
        /**
         * Not all DBMSs support the same LIMIT syntax.
         *
         * So in this switch statement you can write the appropriate syntax to limit the data.
         *
         * Below the working examples for the db:
         * mysql;
         * postegreSQL;
         * sqLite;
         * Cubrid;
         * Oracle;
         */
        switch (strtolower($driverName)) {
            case 'mysql':
            case 'postgresql':
            case 'sqlite':
            case 'cubrid':
                $this->query = "SELECT * 
                              FROM " . $this->table . " 
                              WHERE " . trim($this->where) . " 
                                 LIMIT " . $this->limitStart . "," . $this->limitEnd;
                break;
            
            case 'oracle':
                $this->query = "SELECT * 
                            FROM (
                              SELECT b.*, ROWNUM RN 
                              FROM (
                                SELECT * FROM" . $this->table . " WHERE " . trim($this->where) . "
                              ) b
                              WHERE ROWNUM <= " . $this->limitStart . "
                            ) 
                            WHERE RN > " . $this->limitEnd;
                break;
        }
    }
}