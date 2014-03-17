<?php

include('./Paginator.php');
include('./Rope.php');

$paginator	=	new Paginator('Nom', 80, 5);
$paginator->current	=	10;

print $paginator->generate();