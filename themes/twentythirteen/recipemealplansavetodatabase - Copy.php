
<?php

/*
Template Name: mealplansavetodatabase
*/


$monlist = $_POST['mon'];
$tueslist = $_POST['tues'];
$wedlist = $_POST['wed'];
$thurslist = $_POST['thurs'];
$frilist = $_POST['fri'];
$satlist = $_POST['sat'];
$sunlist = $_POST['sund'];

// print_r($list);
$sortableoutputmon=array();
$sortableoutputtues=array();
$sortableoutputwed=array();
$sortableoutputthurs=array();
$sortableoutputfri=array();
$sortableoutputsat=array();
$sortableoutputsun=array();

$monlist = parse_str($monlist,$sortableoutputmon);
$tueslist = parse_str($tueslist,$sortableoutputtues);
$wedlist = parse_str($wedlist,$sortableoutputwed);
$thurslist = parse_str($thurslist,$sortableoutputthurs);
$frilist = parse_str($frilist,$sortableoutputfri);
$satlist = parse_str($satlist,$sortableoutputsat);
$sunlist = parse_str($sunlist,$sortableoutputsun);

// // print_r ($sortableoutput);
$monday = implode(',', $sortableoutputmon['monday']);
$tuesday = implode(',', $sortableoutputtues['tuesday']);
$wednesday = implode(',', $sortableoutputwed['wednesday']);
$thursday = implode(',', $sortableoutputthurs['thursday']);
$friday = implode(',', $sortableoutputfri['friday']);
$saturday = implode(',', $sortableoutputsat['saturday']);
$sunday = implode(',', $sortableoutputsun['sunday']);
// $tuesday = implode(',', $sortableoutput['tuesday']);


// echo "Monday Meal is $monday";
// echo '<br>';
// echo "Tuesday Meal is $tuesday";
// echo '<br>';
// echo "Wednesday Meal is $wednesday";
// echo '<br>';
// echo "Thursday Meal is $thursday";
// echo '<br>';
// echo "Friday Meal is $friday";
// echo '<br>';
// echo "Saturday Meal is $saturday";
// echo '<br>';
// echo "Sunday Meal is $sunday";

$query ="INSERT INTO recipe_mealplan (monday,tuesday,wednesday,thursday,friday,saturday,sunday)
VALUES ('$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday')";
mysql_query($query);

?>