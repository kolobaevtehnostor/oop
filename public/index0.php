<?php
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Plants\Tree;
use App\Models\Animals\Cat;
use App\Models\SentientAnimal\Human;

use App\Config\ConfigService;
use App\Config\ConfigPorecessor;


ConfigService::setValueSetting('NamePlanet', 'Земля');

$processor = new ConfigPorecessor();

echo '<h1> Планета ' . $processor->getValue('NamePlanet') . '</h1>';

$tree = Tree::getIdentity('Дуб', 2000);
$cat =  Cat::getIdentity('Кот', 5);
$human =  Human::getIdentity('Человек', 90);


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


