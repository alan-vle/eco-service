<?php

$azerty =  password_hash("azerty", PASSWORD_DEFAULT);

if(password_verify("azerty", $azerty )) echo $azerty . '<br>' . password_hash("azerty", PASSWORD_DEFAULT);


$test