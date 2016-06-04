<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-24
 * Time: 14:06
 */

namespace Antoree\Models\Plugins\OwnerInformation;


class OwnerInfo
{
    private static $instance;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public $name;
    public $description;
    public $tagLine;
    public $slogan;
    public $logo;
    public $email;
    public $brief;
    public $headOffice;
    public $branchOffices;

    private function __construct()
    {
    }
}