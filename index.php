<?php

$query = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$ch = curl_init();
echo "Want to Buy All Kind Shop?(y/n):";
$autobuyShop = trim(fgets(STDIN));
echo "Want to clear all task?(y/n):";
$claimer = trim(fgets(STDIN));
foreach($query as $index => $queries){
$url = "https://wonton.food/api/v1/user/auth";
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, true);

$headers = [
    'Content-Type: application/json',
    'Accept: */*',
    'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
    'X-Requested-With: org.telegram.messenger',
    'Origin: https://www.wonton.restaurant',
    'Referer: https://www.wonton.restaurant/',
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = [
    'initData' => $queries,
    'inviteCode' => 'F6IH66PV',
    'newUserPromoteCode' => '',
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Gagal Login Respons' . $response . "\n";
} else {
    $data = json_decode($response, true);
    $username = $data['user']['username'];
    $token = $data['tokens']['accessToken'];
    $refresh = $data['tokens']['refreshToken'];
    $tiket = $data['ticketCount'];
    echo "Berhasil Login Dengan Username $username\n";
    echo "Jumlah Tiket: $tiket\n";

$ch = curl_init();

$url = "https://wonton.food/api/v1/checkin";
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = [
    'Authorization: bearer '.$token.'',
    'Content-Type: application/json',
    'Accept: */*',
    'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
    'X-Requested-With: org.telegram.messenger',
    'Origin: https://www.wonton.restaurant',
    'Referer: https://www.wonton.restaurant/',
    'If-None-Match: W/"775-50+ncepWvmRbGDI+tsSEtkv3lx0"',
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    $totalCheckin = $data['lastCheckinDay'];
    echo "Total Checkin: $totalCheckin\n";
    echo "Getting farming status....\n";
}

curl_close($ch);
if($autobuyShop == 'y'){
            // Initialize cURL session
            $ch = curl_init();

            // Set the URL for the request
            $url = "https://wonton.food/api/v1/shop/list";
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set the HTTP method to GET
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            // Set the request headers
            $headers = [
                'Authorization: bearer '.$token.'',
                'Content-Type: application/json',
                'Accept: */*',
                'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
                'X-Requested-With: org.telegram.messenger',
                'Origin: https://www.wonton.restaurant',
                'Referer: https://www.wonton.restaurant/',
                'If-None-Match: W/"86ac-ho84DLZ68A3kI5auk1ViCqTHTuQ"',
            ];

            // Set headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Set options to return the response as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the request
            $response = curl_exec($ch);

            // Check for errors
            if ($response === false) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                // Get HTTP response code
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                // Check if the response code is 200 OK
                if ($httpCode === 200) {
                    $data = json_decode($response, true);
                    $shopItems = $data['shopItems'];
                    
                    foreach($shopItems as $shopId){
                        if($shopId['inventory'] <= 1){
                        $ch = curl_init();

                        // Set the URL for the request
                        $url = "https://wonton.food/api/v1/shop/use-item";
                        curl_setopt($ch, CURLOPT_URL, $url);
                        
                        // Set the HTTP method to POST
                        curl_setopt($ch, CURLOPT_POST, true);
                        
                        // Set the request headers
                        $headers = [
                            'Authorization: bearer '.$token.'',
                            'Content-Type: application/json',
                            'Accept: */*',
                            'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
                            'X-Requested-With: org.telegram.messenger',
                            'Origin: https://www.wonton.restaurant',
                            'Referer: https://www.wonton.restaurant/',
                        ];
                        
                        // Set headers
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                        // Set the JSON payload
                        $data = [
                            'itemId' => $shopId['id'],
                        ];
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        
                        // Set options to return the response as a string
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        
                        // Execute the request
                        $response = curl_exec($ch);
                        
                        // Check for errors
                        if ($response === false) {
                            echo 'Curl error: ' . curl_error($ch);
                        } else {
                            // Get HTTP response code
                            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            
                            // Check if the response code is 200 OK
                            if ($httpCode === 200) {
                                $itemName = $shopId['name'];
                                echo "Succes Buy Items $itemName\n";
                            } else {
                                echo 'Error: Received HTTP code ' . $httpCode . "\n"; // Print an error message with the code
                            }
                        }
                        
                        // Close cURL session
                        curl_close($ch);
                    }
                    }
                } else {
                    echo 'Error buy items: Received HTTP code ' . $httpCode . "\n"; // Print an error message with the code
                }
            }

            // Close cURL session
            curl_close($ch);

}
if($claimer === 'y'){
    $ch = curl_init();

// Set the URL for the request
$url = "https://wonton.food/api/v1/task/list";
curl_setopt($ch, CURLOPT_URL, $url);

// Set the HTTP method to GET
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

// Set the request headers
$headers = [
    'Authorization: bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI4MzcxZDk5My03OGY3LTRjMGYtYmE4Yi1kMjQwYTc4ODM4YmYiLCJpYXQiOjE3MjczMDY3NDAsImV4cCI6MTcyNzMwODU0MH0.88gFN2cdOZWRdUaLThwmOu488L9h6-eXMCpBhNyHP10',
    'Content-Type: application/json',
    'Accept: */*',
    'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
    'X-Requested-With: org.telegram.messenger',
    'Origin: https://www.wonton.restaurant',
    'Referer: https://www.wonton.restaurant/',
];

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Set options to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    // Print the response
    $data = json_decode($response, true);
    $taskId = $data['tasks'];
    foreach($taskId as $tasks){
        $taskName = $tasks['name'];
        $statusTask = $tasks['status'];
        if($statusTask !== 2){
            $ch = curl_init();

            $url = "https://wonton.food/api/v1/task/verify";
            curl_setopt($ch, CURLOPT_URL, $url);
    
            // Set the HTTP method to POST
            curl_setopt($ch, CURLOPT_POST, true);
    
            // Set the request headers
            $headers = [
                'Authorization: bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI4MzcxZDk5My03OGY3LTRjMGYtYmE4Yi1kMjQwYTc4ODM4YmYiLCJpYXQiOjE3MjczMDY3NDAsImV4cCI6MTcyNzMwODU0MH0.88gFN2cdOZWRdUaLThwmOu488L9h6-eXMCpBhNyHP10',
                'Content-Type: application/json',
                'Accept: */*',
                'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
                'X-Requested-With: org.telegram.messenger',
                'Origin: https://www.wonton.restaurant',
                'Referer: https://www.wonton.restaurant/',
            ];
    
            // Set headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            // Set the JSON payload
            $data = [
                'taskId' => $tasks['id'],
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
            // Set options to return the response as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            // Execute the request
            $response = curl_exec($ch);
    
            // Check for errors
            if ($response === false) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                echo "Trying to complete task $taskName ......\n";
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode === 200) {
                    echo "Berhasil Verify task $taskName\n"; // Print the response if OK
                }
            }
    
            // Close cURL session
            curl_close($ch);
            $ch = curl_init();
            $url = "https://wonton.food/api/v1/task/claim";
            curl_setopt($ch, CURLOPT_URL, $url);
    
            // Set the HTTP method to POST
            curl_setopt($ch, CURLOPT_POST, true);
    
            // Set the request headers
            $headers = [
                'Authorization: bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI4MzcxZDk5My03OGY3LTRjMGYtYmE4Yi1kMjQwYTc4ODM4YmYiLCJpYXQiOjE3MjczMDY3NDAsImV4cCI6MTcyNzMwODU0MH0.88gFN2cdOZWRdUaLThwmOu488L9h6-eXMCpBhNyHP10',
                'Content-Type: application/json',
                'Accept: */*',
                'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
                'X-Requested-With: org.telegram.messenger',
                'Origin: https://www.wonton.restaurant',
                'Referer: https://www.wonton.restaurant/',
            ];
    
            // Set headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            // Set the JSON payload
            $data = [
                'taskId' => $tasks['id'],
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
            // Set options to return the response as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            // Execute the request
            $response = curl_exec($ch);
    
            // Check for errors
            if ($response === false) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                // Print the response
                echo "Trying to claim $taskName ..........\n";
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode === 200) {
                    echo "Berhasil Claim task $taskName\n"; // Print the response if OK
                } else {
                    echo "Gagal Claim Task $taskName\n";
                }
            }
    
            // Close cURL session
            curl_close($ch);
        }
        
    }
}
curl_close($ch);
}
$ch = curl_init();

// Set the URL for the request
$url = "https://wonton.food/api/v1/user/farming-status";
curl_setopt($ch, CURLOPT_URL, $url);

// Set the HTTP method to GET
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

// Set the request headers
$headers = [
    'Authorization: bearer '.$token.'',
    'Content-Type: application/json',
    'Accept: */*',
    'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
    'X-Requested-With: org.telegram.messenger',
    'Origin: https://www.wonton.restaurant',
    'Referer: https://www.wonton.restaurant/',
    'If-None-Match: W/"2-vyGp6PvFo4RvsFtPoIWeCReyIC8"',
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Set options to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    $statusFarm = $data['claimed'];
    $finishAt = $data['finishAt'];
    $startAt = $data['startAt'];
    echo "Start Farming At: $startAt\n";
    echo "status farming $finishAt\n";
    if($statusFarm === 'true'){
        ///////LOGIKA UNTUK CLAIM FARMING
        echo "Trying To Claim Farm..\n";
    }else{
        echo "Claim Not Available\n";
    }
}

// Close cURL session
curl_close($ch);
if($tiket > 0){
for($i = 0; $i < $tiket; $i++){
$ch = curl_init();

// Set the URL for the request
$url = "https://wonton.food/api/v1/user/start-game";
curl_setopt($ch, CURLOPT_URL, $url);

// Set the HTTP method to POST
curl_setopt($ch, CURLOPT_POST, true);

// Set the request headers
$headers = [
    'Authorization: bearer '.$token.'',
    'Content-Type: application/json',
    'Accept: */*',
    'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
    'X-Requested-With: org.telegram.messenger',
    'Origin: https://www.wonton.restaurant',
    'Referer: https://www.wonton.restaurant/',
];

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Set options to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    // Get HTTP response code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Check if the response code is 200 OK
    if ($httpCode === 200) {
        echo "Berhasil Start Game\n"; // Print the response if OK
        $ch = curl_init();

        // Set the URL for the request
        $url = "https://wonton.food/api/v1/user/finish-game";
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set the HTTP method to POST
        curl_setopt($ch, CURLOPT_POST, true);
        $point = rand(900, 1000);
        // Set the request body
        $data = json_encode([
            "points" => $point,
            "hasBonus" => true,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Set the request headers
        $headers = [
            'Authorization: bearer '.$token.'',
            'Content-Type: application/json',
            'Accept: */*',
            'User-Agent: Mozilla/5.0 (Linux; Android 9; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
            'X-Requested-With: org.telegram.messenger',
            'Origin: https://www.wonton.restaurant',
            'Referer: https://www.wonton.restaurant/',
        ];

        // Set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Set options to return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // Get HTTP response code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Check if the response code is 200 OK
            if ($httpCode === 200) {
                echo "Berhasil Bermain dengan point $point\n"; // Print the response if OK
            } else {
                echo 'Gagal Menyelesaikan Game' . "\n"; // Print an error message with the code
            }
        }
        sleep(2);
        // Close cURL session
        curl_close($ch);
        
    } else {
        echo "Gagal Start Game: $httpCode\n"; 
    }
}
}

// Close cURL session
curl_close($ch);
}
}


curl_close($ch);
echo "====================================================\n";
}