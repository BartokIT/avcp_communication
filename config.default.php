<?php

$config =  array(
    "init_status"=> array(
        "site_view"=>"general",
        "area"=>"home"
    ),
    "authentication"=> array(
        "authenticator"=>'ldap',
        "userinforetriever"=>'ldap',
        "rolemapper"=>'simple',
        "external"=>false   //permitted: false, "auto" (login without prompt), true
    ),
    "login_status"=> array(
        "site_view"=>"general",
        "area"=>"login"
    ),
    "debug"=> array(
        "framework"=>true,
        "smarty"=>false
    ),
    "error_page"=> "error.tpl",
    "missing_action_error"=> false,
    "flow_name"=> "main",
    "history_len"=> 20 ,
    "public_folder"=>".\\templates_c\\",
    "pdf"=>array(
        "exec"=>"C:\Progra~1\wkhtmltopdf\bin\wkhtmltopdf.exe"
    ),
    "database"=>array(
        "host"=>"host_name",
        "name"=>"database_name",
        "user"=>"root",
        "pass"=>"root"
    ),
    "ldap"=>array(
        "host"=>"IP LDAP",
        "port"=>3268,
        "root_dn"=>'CN=Utente,CN=Users,DC=Contoso,DC=local',
        "root_dn_password"=>'UserPWD',
        "base_dn"=>'DC=contoso,DC=local',
        "id_attribute"=>"samaccountname",
        "filter"=>'(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))'
    ),
    "ldap_mapper"=>array(
        'users'=>array("administrator"=>"administrator"), //single-user mapper
        'groups'=>array( //group mapper
            'CN=Intranet Administrators,CN=Users,DC=Contoso,DC=local'=>"administrator",
            'CN=AVCP Communication Users,CN=Users,DC=Contoso,DC=local'=>"editor"
        )
    )
);

global $config;