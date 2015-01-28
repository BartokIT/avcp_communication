<?php


interface UserInfoRetriever
{
/**
 *Retrieve user information as name and other information
 * @param User $user Pass the user object to be filled with information
 * */
    public function getUserInfo($user);
}

interface Authenticator
{
    /**
     * Method to verify the authenticity of who claim to be
     * */
    public function authenticate($id,$password=NULL,$domain=NULL);
}

interface UserRoleMapper
{
 /**
 * Map the user and its group to application roles
 * @param User $user Pass the user object to refer
 * */
    public function setUserRoles($user);
}


