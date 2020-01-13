<?php

namespace App\Exports;

use App\time_management;
use App\User;
use DateTime;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

use DB;

class timeExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
 
    // public function columnFormats(): array
    // {
    //     return [
    //         'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    //         // 'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
    //     ];
    // }

    function __construct($selectEmployee, $filterByStatus, $passwordConfirm, $startDate, $endDate, $selectClass) {
        $this->userID = $selectEmployee;
        $this->filterByStatus = $filterByStatus;
        $this->passwordCheck = $passwordConfirm;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectClass = $selectClass;
	}

    public function headings(): array
    {
        return [
            'Employee Name',
            'Status',
            'Time',
            'Last Login',
            'Classification Type',
            'Date Created',
            'Remarks',
            '',
            '',
            '',
            '',
            '',
            'Employee Name',
            'Status',
            'Time',
            'Last Login',
            'Classification Type',
            'Date Created',
            'Remarks',
        ];
    }

    public function array(): array {

    	$arrayResultHolder = [];

    	$userID = $this->userID;
    	$filterByStatus = $this->filterByStatus;
    	$passwordGet = $this->passwordCheck;
    	$selectClass = $this->selectClass;

    	$startDate = new DateTime($this->startDate);
  		$startDate = date_format($startDate,'Y-m-d')." 00:00:00";

  		$endDate = new DateTime($this->endDate);
  		$endDate = date_format($endDate,'Y-m-d')." 23:59:59";

    	$arrayResult = array("Username","Status","Time","Date Created");

    	$arrayResult = [];
    	$arrayResult = [];

    	$queryOne = time_management::select('user_id', 'time_type', 'time', 'last_login', 'created_at', 'remarks', 'classification_type')
						->when($filterByStatus != "", function ($query) use($filterByStatus){
							return $query->where('time_type', $filterByStatus);
						})
						->when(!empty($userID) , function ($query) use($userID){
							return $query->WhereWithOperators('user_id', '=', $userID);
						})
						->when(!empty($startDate) && !empty($endDate), function ($query) use($startDate, $endDate){
							return $query->whereBetween('created_at', [$startDate, $endDate]);
						})
						->when($selectClass != "", function ($query) use($selectClass){
							return $query->where('classification_type', $selectClass);
						})
    					->get()
    					->toArray();

    	foreach ($queryOne as $key => $passResult) {
    		
    		$date_timeEntry = date_create($passResult['time']);
    		$date_timeEntry = date_format($date_timeEntry, "h:i:s A");

            $lastLogin = date_create($passResult['last_login']);
            $lastLogin = date_format($lastLogin, "h:i:s A");

    		$lastName = User::WhereWithOperators('id','=', $passResult['user_id'])->get()->pluck('last_name')[0];
    		$firstName = User::WhereWithOperators('id','=', $passResult['user_id'])->get()->pluck('first_name')[0];

    		$fullNameSet = $lastName.", ".$firstName;

    		if ($passResult['classification_type'] == 0) {
    			$displayClass = "Regular";
    		}else if($passResult['classification_type'] == 1){
    			$displayClass = "Rest Day";
    		}else{
    			$displayClass = "Over Time";
    		}

    		if ($passResult['time_type'] == 0) {
    			$arrayResult[] = array( $fullNameSet, "Time In", $date_timeEntry, $lastLogin, $displayClass, $passResult['created_at'], $passResult['remarks'], "", "", "","","", "", "", "", "", "");
    		}else{
    			$arrayResult[] = array("", "", "", "","", "", "", "", "", "", "", "",$fullNameSet, "Time Out", $date_timeEntry, $lastLogin, $displayClass, $passResult['created_at'], $passResult['remarks'] );
    		}
   
    	}

    	return [
    		$arrayResult
    	]; 

    }
}
