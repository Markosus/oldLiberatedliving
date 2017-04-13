<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$query ="SELECT * FROM `recipe_ingredients` WHERE ingredient_name like '" . $_POST["keyword"] . "%' ORDER BY ingredient_name LIMIT 0,6";
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectCountry('<?php echo $country["ingredient_name"]; ?>');"><?php echo $country["ingredient_name"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>