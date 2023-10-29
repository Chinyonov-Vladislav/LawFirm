<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationContoller extends Controller
{
    private $specializations;
    public function __construct()
    {
        $this->specializations = new Specialization();
    }

    public function getSpecialization()
    {
        $specializations = $this->specializations->getAllSpecializations();
        return response()->json(["specializations"=>$specializations]);
    }
}
