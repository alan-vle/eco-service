<?php
function config(): PDO
{
    try{
        return new PDO('mysql:host=mysql-ecoservice.alwaysdata.net;dbname=ecoservice_ecommerce;charset=utf8',
            '221023_admin', 'GfXn5rys5g');
    }
    catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}
