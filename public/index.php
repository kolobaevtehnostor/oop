<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Plants\Tree;
use App\Models\Animals\Cat;
use App\Models\SentientAnimal\Human;

$tree = new Tree('Дуб', 2000);
$cat = new Cat('Кот', 5);
$human = new Human('Человек', 90);
?>

<?= $tree->printLifeFormsName(); ?>
<br>
<?= $tree->printLifeFormsDescription(); ?>

<hr>

<?= $cat->printLifeFormsName(); ?>
<br>
<?= $cat->printLifeFormsDescription(); ?>

<hr>

<?= $human->printLifeFormsName(); ?>
<br>
<?= $human->printLifeFormsDescription(); ?>


