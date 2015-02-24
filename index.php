<?php
//this is only for the measurement of the running time
$executionStart = utime();
//this is only for the measurement of the running time

require_once 'PhpFastPaginator.php';
// PDO Instance
$db = new PDO('mysql:host=localhost;dbname=test', "root", "", null);
// SQL Information
$table = "myTable";
$where = "content LIKE :somevalue";
$bind = array(
    ':somevalue' => "%text%"
);

// Actual page 1 default
$page = (isset($_GET['page'])) ? (int) $_GET['page'] : PFPaginator::DEFAULT_START_PAGE;
// Quantity of data per page
$quantity = (isset($_GET['ndata'])) ? (int) $_GET['ndata'] : PFPaginator::DEFAULT_QUANTITY;
// Create the instance of PFPaginator
try {
    $Paginator = new PFPaginator($db, $page, $quantity, $table, $where, $bind);
} catch (Exception $e) {
    exit($e->getMessage());
}
// Retrive data
$dataPaginate = $Paginator->getData();
// Retrive pagination menu data
$menuPagination = $Paginator->getMenu();
?>

<html>
<head>
<title>PHP FAST PAGINATOR CLASS</title>
</head>

<body>
	<div class="container">
		<div class="data">
            <?php
                foreach ($dataPaginate as $data) {
                    echo "<p>" . $data['Id'] . " - " . $data['content'] . "</p>";
                }
            ?>
        </div>
		<div class="paginationMenu">
            <?php
                echo "<a href='?page=1&ndata=$quantity'> << First Page | </a>";
                echo "<a href='?page=" . $menuPagination['PREVIOUS_INDEX'] . "&ndata=$quantity'> < Previous Page | </a>";
                for ($i = 1; $i <= $menuPagination['MAX_PAGINATION_INDEXES']; $i ++) {
                    echo "<a href='?page=$i&ndata=$quantity' > $i </a>";
                }
                echo "<a href='?page=" . $menuPagination['NEXT_INDEX'] . "&ndata=$quantity'> | Next Page ></a>";
                echo "<a href='?page=" . $menuPagination['MAX_PAGINATION_INDEXES'] . "&ndata=$quantity'> | Last Page >></a>";
            ?>
        </div>
</div>
<?php 
//this is only for the measurement of the running time
$executionEnd= utime();
//this is only for the measurement of the running time
echo "<br/><h3>Execution time: ".$difference = $executionEnd - $executionStart." millisec.</h3>";
?>
</body>
</html>
<?php 
function utime() {
    $a=explode(' ', microtime());
    return reset($a);
}
?>