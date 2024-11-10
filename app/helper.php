<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\WalletTransaction;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



if (!function_exists('updateWallet')) {
    function updateWallet($customer_ids = NULL)
    {
        if($customer_ids){
            $customers = Customer::whereIn('id', $customer_ids)->get();
        }else{
            $customers = Customer::all();
        }
        foreach ($customers as $customer) {
            $wallet_balance = $customer->wallet_balance;

            $songs = $customer->songs()->where('reward', '!=', 0)->where(['is_added' => 0])->get();
            $wallet_balance += $songs->sum('reward');

            $video_songs = $customer->videoSongs()->where('reward', '!=', 0)->where(['is_added' => 0])->get();
            $wallet_balance += $video_songs->sum('reward');

            $customer->update(['wallet_balance' => $wallet_balance]);
            $songs->each->update(['is_added' => 1]);
            $video_songs->each->update(['is_added' => 1]);
        }
    }
}


if (!function_exists('refreshWallet')) {
    function refreshWallet($customer_id = NULL)
    {
        // Get all wallet transactions for the customer
        $WalletTransactions = WalletTransaction::where(['customer_id' => $customer_id])->get();

        // Initialize WalletBalance as a string to ensure precision
        $WalletBalance = '0.00';
        
        foreach ($WalletTransactions as $WalletTransaction) {
            // Check transaction type and update the balance accordingly
            if ($WalletTransaction['type'] === 'deposit') {
                $WalletBalance = bcadd($WalletBalance, $WalletTransaction['amount'], 2);
            } elseif ($WalletTransaction['type'] === 'withdraw') {
                $WalletBalance = bcsub($WalletBalance, $WalletTransaction['amount'], 2);
            }
        }

        Customer::find($customer_id)->update(['wallet_balance'=> (float)$WalletBalance]);

    }
}


if (!function_exists('truncateString')) {
    function truncateString($string, $length = 30, $append = '...')
    {
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length) . $append;
        }
        return $string;
    }
}

if (!function_exists("settings")) {
    function settings($key = null)
    {
        if ($key) {
            $setting = Settings::where('key', $key)->first();
            if ($setting) {
                return $setting->value;
            } else {
                return NULL;
            }
        } else {
            $settings = Settings::all()->pluck('value', 'key');
            return $settings;
        }
    }
}

if (!function_exists("dateFormat")) {
    function dateFormat($date_time, $fromformat = 'd/m/Y h:i A', $toformat = 'Y-m-d H:i:s')
    {
        // Convert to DateTime object with specified format
        $datetime_object = DateTime::createFromFormat($fromformat, $date_time);

        // Get the Unix timestamp
        $timestamp = $datetime_object->getTimestamp();

        // Format the timestamp in MySQL timestamp format
        $mysql_timestamp = date($toformat, $timestamp);

        return $mysql_timestamp;
    }
}

if (!function_exists('unlinkFiles')) {
    /**
     * Unlink (delete) single or multiple files.
     *
     * @param string|array $filePaths
     * @return bool
     */
    function unlinkFiles($filePaths)
    {
        if (!is_array($filePaths)) {
            $filePaths = [$filePaths];
        }

        $success = true;

        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                $deleted = unlink($filePath);

                if (!$deleted) {
                    // Handle deletion failure if needed
                    $success = false;
                }
            } else {
                // File doesn't exist
                $success = false;
            }
        }

        return $success;
    }
}

if (!function_exists('uploadFiles')) {
    /**
     * Upload single or multiple files.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $inputName
     * @param string $destinationPath
     * @return array
     */
    function uploadFiles($request, $inputName, $destinationPath, $isUnique = true)
    {
        $uploadedFiles = [];

        // Check if files were uploaded
        if ($request->hasFile($inputName)) {
            $files = $request->file($inputName);

            // If a single file is uploaded, convert it to an array for consistency
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                // Generate a unique name for the file
                if ($isUnique) {
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                } else {
                    $fileName = $file->getClientOriginalName();
                }

                // Move the file to the specified destination path
                $file->move($destinationPath, $fileName);

                // Store the file details in the array
                $uploadedFiles[] = [
                    'file_name' => $fileName,
                    'file_path' => $destinationPath . '/' . $fileName,
                ];
            }
            return $uploadedFiles;
        } else {
            return [];
        }
    }
}

if (!function_exists("isCustomerLoggedIn")) {
    function isCustomerLoggedIn()
    {
        // return auth('customer')->check();
        return Auth::guard('customer')->check();
    }
}

if (!function_exists("getCurrentCustomer")) {
    function getCurrentCustomer()
    {
        // return auth('customer')->user();
        return Auth::guard('customer')->user();
    }
}

if (!function_exists("p")) {
    function p($x)
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";
    }
}

if (!function_exists("prx")) {
    function prx($x, $exit = 0)
    {
        echo '<h1 style="top:0;position:fixed;color:white;background:red;text-align:center;width:30%;right:0;">PAGE UNDER CONSTRACTION</h1>';
        echo $res = "<pre>";
        if (is_array($x) || is_object($x)) {
            print_r($x);
        } else {
            var_dump($x);
        }
        echo "</pre>";
        if ($exit == 0) {
            die();
        }
    }
}

if (!function_exists("lock")) {
    function lock($string, $action = 'encrypt')
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'CONSTA_KG_2023'; // user define private key
        $secret_iv = 'oO0o90O0OoO8o0oOo60o10o'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt(json_encode($string), $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = json_decode(openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv));
        }
        return $output;
    }
}
