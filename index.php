<?php

$query = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$ch = curl_init();
echo "Want to Buy All Kind Shop?(y/n):";
$autobuyShop = trim(fgets(STDIN));
echo "Want to clear all task?(y/n):";
$claimer = trim(fgets(STDIN));
while(true){
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
    $statusFarm = $data['claimed'] ?? false;;
    $finishAt = $data['finishAt'] ?? null;
    $startAt = $data['startAt'] ?? null;
    echo "Start Farming At: $startAt\n";
    echo "status farming $finishAt\n";
    if(isset($statusFarm) === 'true'){
        ///////LOGIKA UNTUK CLAIM FARMING
        echo "Trying To Claim Farm..\n";
    }else{
        echo "Claim Not Available/Not Yet start\n";
        $url = 'https://wonton.food/api/v1/user/start-farming';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: bearer ' . $token,
            'Content-Type: application/json',
            'Accept: */*',
            'X-Tag: 8<[1$64.872q[pw>t[&/73i8+mz)#0>8~!c43zjed0*e&8qlk5.0]!b>314b'
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([])); // Sending empty JSON body

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo 'Start Response: ' . $httpCode . "\n";
        }

        curl_close($ch);
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
        sleep(5);
        // Close cURL session
        curl_close($ch);
        
    } else {
        echo "Gagal Start Game: $httpCode\n"; 
        sleep(2);
    }
}
}

// Close cURL session
curl_close($ch);
}
$url = "https://wonton.food/api/v1/task/claim-progress";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: bearer '.$token.'',
    'Content-Type: application/json',
    'X-Tag: t7+1rvu2272(p)d.(_3m73?@?0_;k0o8>$k549yfs3vz<7g(t4fgkt@_a0zi'
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode === 200) {
    $data = json_decode($response, true);
    print_r($data); // Output the response data
    }else{
        "GAGAL AMBIL PACK\n";
    }
}

curl_close($ch);

}


curl_close($ch);
echo "====================================================\n";
}
echo "SUCCES RUN ALL ACCOUNT SLEEP 1 HOURS\n";
sleep(3600);
}