<?php

include "../config/dbconnect.php";

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['name']) && isset($data['companyId'])
        && isset($data['minSalary']) && isset($data['maxSalary'])
        && isset($data['currency']) && isset($data['yearExperience'])
        && isset($data['typeJob']) && isset($data['numberCandidate'])
        && isset($data['address']) && isset($data['description'])
        && isset($data['candidateRequirement']) && isset($data['jobBenefit'])
        && isset($data['tag']) && isset($data['deadline'])
        && isset($data['active']) && isset($data['level'])) {

            $name = $conn->real_escape_string($data['name']);
			$companyId = $conn->real_escape_string($data['companyId']);
            $minSalary = $conn->real_escape_string($data['minSalary']);
            $maxSalary = $conn->real_escape_string($data['maxSalary']);
            $currency = $conn->real_escape_string($data['currency']);
            $yearExperience = $conn->real_escape_string($data['yearExperience']);
            $typeJob = $conn->real_escape_string($data['typeJob']);
            $numberCandidate = $conn->real_escape_string($data['numberCandidate']);
            $address = $conn->real_escape_string($data['address']);
            $description = $conn->real_escape_string($data['description']);
            $candidateRequirement = $conn->real_escape_string($data['candidateRequirement']);
            $jobBenefit = $conn->real_escape_string($data['jobBenefit']);
            $tag = $conn->real_escape_string($data['tag']);
            $date = $conn->real_escape_string($data['deadline']);
            $active = $conn->real_escape_string($data['active']);
            $level = $conn->real_escape_string($data['level']);
		
			$convert = DateTime::createFromFormat('d/m/Y', $date);
			$deadline = $convert->format('Y-m-d');

            $sql = "INSERT INTO jh_job_detail(name, companyId, minSalary, maxSalary, currency, 
            yearExperience, typeJob, numberCandidate, address, description, candidateRequirement, 
            jobBenefit, tag, deadline, active, level) VALUES ('$name','$companyId','$minSalary',
            '$maxSalary','$currency','$yearExperience','$typeJob','$numberCandidate','$address',
            '$description','$candidateRequirement','$jobBenefit','$tag','$deadline','$active','$level')";

            if ($conn->query($sql) === TRUE) {
                $response['success'] = 1;
                $response['message'] = 'create job successfully';
            } else {
                header("HTTP/1.1 500 Internal Server Error");
                $response['success'] = 0;
                $response['message'] = 'create job unsuccessfully + ' . $conn->error;
            }
            echo json_encode($response);
    
        } else {
            $response['success'] = 0;
            $response['message'] = 'Missing in the request';
        header("HTTP/1.1 400 Bad Request");
        echo json_encode($response);
    }
} else {
    $response['success'] = 0;
    $response['message'] = 'Method not allowed';
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode($response);
}

$conn->close();
