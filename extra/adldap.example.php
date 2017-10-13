<?php

return [
    'account_suffix' => "@example.com",
    'domain_controllers' => ["example.com"],
    'base_dn' => 'cn=Computers,dc=example,dc=com',
    'ad_port' => '389',
    'admin_username' => 'admin',
    'admin_password' => 'password',
    'recursive_groups' => true,
    'person_filter' => ['objectClass' => 'computer']
];
