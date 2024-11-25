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

if (!function_exists("MusicGenreList")) {
    function MusicGenreList()
    {
        return [
            'bollywood' => 'Bollywood',
            'classical' => 'Classical',
            'pop' => 'Pop',
            'folk' => 'Folk',
            'hip_hop' => 'Hip Hop',
            'trance' => 'Trance',
            'reggae' => 'Reggae',
            'jazz' => 'Jazz',
            'metal' => 'Metal',
            'rnb' => 'R&B',
            'dance' => 'Dance',
            'house' => 'House',
            'electronic' => 'Electronic',
            'rock' => 'Rock',
            'blues' => 'Blues',
            'country' => 'Country',
            'soul' => 'Soul',
            'rnb' => 'R&B',
            'salsa' => 'Salsa',
            'funk' => 'Funk',
            'disco' => 'Disco',
            'alternative' => 'Alternative',
            'indie' => 'Indie',
            'trap' => 'Trap',
            'world' => 'World',
            'new_age' => 'New Age',
            'soundtrack' => 'Soundtrack',
            'afrobeat' => 'Afrobeat',
            'dubstep' => 'Dubstep',
            'future_bass' => 'Future Bass',
            'indian' => 'Indian',
            'world_music' => 'World Music',
            'devotional' => 'Devotional',
        ];
    }
}


if (!function_exists("MusicSubGenreList")) {
    function MusicSubGenreList()
    {
        return [
            // Sub-genres of Bollywood
            'bollywood_pop' => 'Bollywood Pop',
            'bollywood_classical' => 'Bollywood Classical',
            'bollywood_rock' => 'Bollywood Rock',
            'bollywood_folk' => 'Bollywood Folk',
            'bollywood_dance' => 'Bollywood Dance',
            'bollywood_romantic' => 'Bollywood Romantic',
            'bollywood_hiphop' => 'Bollywood Hip-Hop',
            'bollywood_qawwali' => 'Bollywood Qawwali',
            'bollywood_sufi' => 'Bollywood Sufi',
            'bollywood_ghazal' => 'Bollywood Ghazal',
            'bollywood_jazz' => 'Bollywood Jazz',
            'bollywood_blues' => 'Bollywood Blues',
            'bollywood_punjabi' => 'Bollywood Punjabi',
            'bollywood_bhajan' => 'Bollywood Bhajan',
            'bollywood_lullaby' => 'Bollywood Lullaby',
            'bollywood_item_number' => 'Bollywood Item Number',
            'bollywood_bhangra' => 'Bollywood Bhangra',
            'bollywood_devotional' => 'Bollywood Devotional',
            'bollywood_melodic' => 'Bollywood Melodic',
            'bollywood_indie' => 'Bollywood Indie',

            // Sub-genres of Classical
            'classical' => 'Classical',
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'renaissance' => 'Renaissance',
            'medieval' => 'Medieval',
            'contemporary' => 'Contemporary',
            'neoclassical' => 'Neoclassical',
            'impressionism' => 'Impressionism',
            'expressionism' => 'Expressionism',
            'minimalism' => 'Minimalism',
            'early_classical' => 'Early Classical',
            '20th_century' => '20th Century Classical',
            'modern' => 'Modern',
            'galant' => 'Galant',

            // Sub-genres of Pop
            'pop_rock' => 'Pop Rock',
            'synthpop' => 'Synthpop',
            'dance_pop' => 'Dance Pop',
            'teen_pop' => 'Teen Pop',
            'k_pop' => 'K-Pop',
            'electropop' => 'Electropop',
            'latin_pop' => 'Latin Pop',
            'chamber_pop' => 'Chamber Pop',
            'indie_pop' => 'Indie Pop',
            'power_pop' => 'Power Pop',
            'hyperpop' => 'Hyperpop',
            'j_pop' => 'J-Pop',
            'baroque_pop' => 'Baroque Pop',
            'art_pop' => 'Art Pop',
            'dream_pop' => 'Dream Pop',
            'pop_punk' => 'Pop Punk',
            'twee_pop' => 'Twee Pop',
            'folk_pop' => 'Folk Pop',
            'sophisti_pop' => 'Sophisti-Pop',
            'psychedelic_pop' => 'Psychedelic Pop',
            'trap_pop' => 'Trap Pop',

            // Sub-genres of Folk
            'baul' => 'Baul',
            'bhojpuri' => 'Bhojpuri',
            'bhangra' => 'Bhangra',
            'ghazal' => 'Ghazal',
            'bhajan' => 'Bhajan',
            'marathi' => 'Marathi',
            'punjabi' => 'Punjabi',
            'rajasthani' => 'Rajasthani',
            'tamil' => 'Tamil Folk',
            'telugu' => 'Telugu Folk',
            'kannada' => 'Kannada Folk',
            'garhwali' => 'Garhwali',
            'kumaoni' => 'Kumaoni',
            'bengali' => 'Bengali Folk',
            'malayalam' => 'Malayalam Folk',
            'oriya' => 'Oriya Folk',
            'assamese' => 'Assamese Folk',
            'lavani' => 'Lavani',
            'narrative' => 'Narrative Folk',
            'sufi' => 'Sufi',
            'tribal' => 'Tribal Folk',
            'haryanvi' => 'Haryanvi Folk',
            'santali' => 'Santali Folk',
            'sufi_qawwali' => 'Sufi Qawwali',
            'northeastern' => 'Northeastern Folk',
            'folk_ballad' => 'Folk Ballad',
            'bluegrass' => 'Bluegrass',
            'country' => 'Country Folk',
            'celtic' => 'Celtic',
            'american' => 'American Folk',
            'nordic' => 'Nordic Folk',
            'arabic' => 'Arabic Folk',
            'latin' => 'Latin Folk',
            'gypsy' => 'Gypsy',

            // Sub-genres of Hip Hop
            'old_school' => 'Old School',
            'new_school' => 'New School',
            'trap' => 'Trap',
            'gangsta' => 'Gangsta',
            'conscious' => 'Conscious',
            'lofi' => 'Lo-fi',
            'crunk' => 'Crunk',
            'mumble' => 'Mumble',
            'boom_bap' => 'Boom Bap',
            'gfunk' => 'G-Funk',
            'drill' => 'Drill',
            'cloud' => 'Cloud Rap',
            'phonk' => 'Phonk',
            'trap_metal' => 'Trap Metal',
            'jazz_rap' => 'Jazz Rap',
            'emo_rap' => 'Emo Rap',
            'alternative' => 'Alternative Hip Hop',
            'underground' => 'Underground',
            'southern' => 'Southern Hip Hop',
            'west_coast' => 'West Coast Hip Hop',
            'east_coast' => 'East Coast Hip Hop',
            'chopper' => 'Chopper',
            'bounce' => 'Bounce',
            'grime' => 'Grime',
            'boom_bap' => 'Boom Bap',
            'trap' => 'Trap',
            'drill' => 'Drill',
            'lofi' => 'Lo-fi',
            'conscious' => 'Conscious',
            'gangsta' => 'Gangsta',
            'trap_metal' => 'Trap Metal',
            'cloud_rap' => 'Cloud Rap',
            'trap_soul' => 'Trap Soul',
            'jazz_rap' => 'Jazz Rap',
            'underground' => 'Underground',
            'west_coast' => 'West Coast',
            'east_coast' => 'East Coast',
            'alternative' => 'Alternative',
            'southern' => 'Southern',
            'grime' => 'Grime',
            'nerdcore' => 'Nerdcore',
            'hyphy' => 'Hyphy',
            'crunk' => 'Crunk',
            'freestyle' => 'Freestyle',
            'new_school' => 'New School',
            'old_school' => 'Old School',
            'melodic_rap' => 'Melodic Rap',

            // Sub-genres of Trance
            'progressive' => 'Progressive',
            'psychedelic' => 'Psychedelic',
            'uplifting' => 'Uplifting',
            'vocal' => 'Vocal',
            'hard' => 'Hard',
            'tech' => 'Tech',
            'acid' => 'Acid',
            'euphoric' => 'Euphoric',
            'goa' => 'Goa',
            'ambient' => 'Ambient',
            'dream' => 'Dream',
            'progressive_psytrance' => 'Progressive Psytrance',
            'full_on' => 'Full-On',
            'dark' => 'Dark',
            'forest' => 'Forest',
            'classic' => 'Classic',
            'deep' => 'Deep',
            'liquid' => 'Liquid',
            'tribal' => 'Tribal',

            // Sub-genres of Reggae
            'roots' => 'Roots Reggae',
            'dub' => 'Dub',
            'dancehall' => 'Dancehall',
            'ragga' => 'Ragga',
            'lovers_rock' => 'Lovers Rock',
            'reggaeton' => 'Reggaeton',
            'rocksteady' => 'Rocksteady',
            'early_reggae' => 'Early Reggae',
            'conscious_reggae' => 'Conscious Reggae',
            'rub_a_dub' => 'Rub-a-Dub',
            'digital_reggae' => 'Digital Reggae',
            'steppers' => 'Steppers',
            'bashment' => 'Bashment',
            'nyabinghi' => 'Nyabinghi',
            'modern_reggae' => 'Modern Reggae',
            'reggae_fusion' => 'Reggae Fusion',
            'dubstep' => 'Dubstep',
            'jungle' => 'Jungle',

            // Sub-genres of Jazz
            'traditional' => 'Traditional',
            'swing' => 'Swing',
            'bebop' => 'Bebop',
            'hard_bop' => 'Hard Bop',
            'cool_jazz' => 'Cool Jazz',
            'modal_jazz' => 'Modal Jazz',
            'free_jazz' => 'Free Jazz',
            'fusion' => 'Fusion',
            'smooth_jazz' => 'Smooth Jazz',
            'latin_jazz' => 'Latin Jazz',
            'afro_cuban' => 'Afro-Cuban Jazz',
            'gypsy_jazz' => 'Gypsy Jazz',
            'avant_garde' => 'Avant-Garde Jazz',
            'post_bop' => 'Post-Bop',
            'bossa_nova' => 'Bossa Nova',
            'nu_jazz' => 'Nu Jazz',
            'acid_jazz' => 'Acid Jazz',
            'jazz_rap' => 'Jazz Rap',
            'contemporary_jazz' => 'Contemporary Jazz',
            'jazz_funk' => 'Jazz Funk',

            // Sub-genres of Metal
            'heavy_metal' => 'Heavy Metal',
            'thrash_metal' => 'Thrash Metal',
            'death_metal' => 'Death Metal',
            'black_metal' => 'Black Metal',
            'doom_metal' => 'Doom Metal',
            'power_metal' => 'Power Metal',
            'folk_metal' => 'Folk Metal',
            'gothic_metal' => 'Gothic Metal',
            'progressive_metal' => 'Progressive Metal',
            'nu_metal' => 'Nu Metal',
            'groove_metal' => 'Groove Metal',
            'speed_metal' => 'Speed Metal',
            'symphonic_metal' => 'Symphonic Metal',
            'industrial_metal' => 'Industrial Metal',
            'sludge_metal' => 'Sludge Metal',
            'metalcore' => 'Metalcore',
            'melodic_death_metal' => 'Melodic Death Metal',
            'viking_metal' => 'Viking Metal',
            'blackened_death_metal' => 'Blackened Death Metal',
            'post_metal' => 'Post-Metal',
            'technical_death_metal' => 'Technical Death Metal',
            'djent' => 'Djent',
            'stoner_metal' => 'Stoner Metal',

            // Sub-genres of R&B
            'r&b_soul' => 'R&B Soul',
            'neo_soul' => 'Neo Soul',
            'contemporary_r&b' => 'Contemporary R&B',
            'funk' => 'Funk',
            'hip_hop_soul' => 'Hip Hop Soul',
            'smooth_r&b' => 'Smooth R&B',
            'new_jack_swing' => 'New Jack Swing',
            'southern_soul' => 'Southern Soul',
            'quiet_storm' => 'Quiet Storm',
            'progressive_r&b' => 'Progressive R&B',
            'blue_eyed_soul' => 'Blue-Eyed Soul',
            'modern_soul' => 'Modern Soul',
            'alternative_r&b' => 'Alternative R&B',
            'jazz_r&b' => 'Jazz R&B',
            'vintage_r&b' => 'Vintage R&B',

            // Sub-genres of Dance
            'dance-pop' => 'Dance-pop',
            'deep-house' => 'Deep House',
            'techno' => 'Techno',
            'trance' => 'Trance',
            'dubstep' => 'Dubstep',
            'drum-and-bass' => 'Drum and Bass',
            'house' => 'House',
            'disco' => 'Disco',
            'breakbeat' => 'Breakbeat',
            'hardstyle' => 'Hardstyle',
            'progressive-house' => 'Progressive House',
            'synth-pop' => 'Synth-pop',
            'future-bass' => 'Future Bass',
            'ethnic-dance' => 'Ethnic Dance',
            'electro-swing' => 'Electro Swing',
            'garage' => 'Garage',
            'tech-house' => 'Tech House',
            'samba' => 'Samba',
            'hip-hop' => 'Hip Hop',
            'reggaeton' => 'Reggaeton',
            'street-dance' => 'Street Dance',
            'contemporary' => 'Contemporary',

            // Sub-genres of House
            'soulful' => 'Soulful House',
            'deep' => 'Deep House',
            'progressive' => 'Progressive House',
            'tech' => 'Tech House',
            'disco' => 'Disco House',
            'futuristic' => 'Futuristic House',
            'vocal' => 'Vocal House',
            'minimal' => 'Minimal House',
            'garage' => 'Garage House',
            'afro' => 'Afro House',
            'tribal' => 'Tribal House',
            'funky' => 'Funky House',
            'electro' => 'Electro House',
            'Chicago' => 'Chicago House',
            'Detroit' => 'Detroit House',
            'new' => 'New House',
            'ambient' => 'Ambient House',
            'lo-fi' => 'Lo-fi House',
            'hard' => 'Hard House',

            // Sub-genres of Electronic
            'electro' => 'Electro',
            'house' => 'House',
            'techno' => 'Techno',
            'trance' => 'Trance',
            'dubstep' => 'Dubstep',
            'drum_and_bass' => 'Drum and Bass',
            'ambient' => 'Ambient',
            'industrial' => 'Industrial',
            'glitch' => 'Glitch',
            'future_bass' => 'Future Bass',
            'deep_house' => 'Deep House',
            'progressive_house' => 'Progressive House',
            'trap' => 'Trap',
            'retrowave' => 'Retrowave',
            'liquid_dnb' => 'Liquid Drum and Bass',
            'hardstyle' => 'Hardstyle',
            'synthwave' => 'Synthwave',
            'breakbeat' => 'Breakbeat',
            'psytrance' => 'Psytrance',
            'minimal' => 'Minimal',
            'big_room' => 'Big Room',

            // Sub-genres of Rock
            'shard' => 'Shred',
            'alternative' => 'Alternative Rock',
            'indie' => 'Indie Rock',
            'grunge' => 'Grunge',
            'punk' => 'Punk Rock',
            'progressive' => 'Progressive Rock',
            'metal' => 'Heavy Metal',
            'soft' => 'Soft Rock',
            'blues' => 'Blues Rock',
            'southern' => 'Southern Rock',
            'psychedelic' => 'Psychedelic Rock',
            'garage' => 'Garage Rock',
            'new_wave' => 'New Wave',
            'pop_punk' => 'Pop Punk',
            'emo' => 'Emo',
            'post_rock' => 'Post-Rock',
            'metalcore' => 'Metalcore',
            'pop_rock' => 'Pop Rock',
            'math_rock' => 'Math Rock',
            'industrial' => 'Industrial Rock',
            'hardcore' => 'Hardcore Punk',
            'acid' => 'Acid Rock',
            'grunge' => 'Grunge',
            'stoner' => 'Stoner Rock',
            'prog_metal' => 'Progressive Metal',
            'space' => 'Space Rock',
            'folk_rock' => 'Folk Rock',
            'surf' => 'Surf Rock',
            'rockabilly' => 'Rockabilly',
            'cowpunk' => 'Cowpunk',
            'emo' => 'Emo',

            // Sub-genres of Blues
            'delta_blues' => 'Delta Blues',
            'chicago_blues' => 'Chicago Blues',
            'electric_blues' => 'Electric Blues',
            'country_blues' => 'Country Blues',
            'jump_blues' => 'Jump Blues',
            'southern_blues' => 'Southern Blues',
            'rhythm_and_blues' => 'Rhythm and Blues (R&B)',
            'blues_rock' => 'Blues Rock',
            'swamp_blues' => 'Swamp Blues',
            'boogie_woogie' => 'Boogie Woogie',

            // Sub-genres of Country
            'southern_rock' => 'Southern Rock',
            'bluegrass' => 'Bluegrass',
            'country_rock' => 'Country Rock',
            'traditional_country' => 'Traditional Country',
            'contemporary_country' => 'Contemporary Country',
            'outlaw_country' => 'Outlaw Country',
            'alt_country' => 'Alternative Country',
            'bro_country' => 'Bro Country',
            'swing' => 'Country Swing',
            'cowpunk' => 'Cowpunk',
            'country_pop' => 'Country Pop',
            'americana' => 'Americana',
            'texas_country' => 'Texas Country',
            'country_folk' => 'Country Folk',
            'country_blues' => 'Country Blues',
            'honky_tonk' => 'Honky Tonk',

            // Sub-genres of Soul
            'southern_soul' => 'Southern Soul',
            'neo_soul' => 'Neo Soul',
            'deep_soul' => 'Deep Soul',
            'psychadelic_soul' => 'Psychedelic Soul',
            'soul_blues' => 'Soul Blues',
            'funk' => 'Funk',
            'contemporary_r&b' => 'Contemporary R&B',
            'motown' => 'Motown',
            'gospel' => 'Gospel',
            'vintage_soul' => 'Vintage Soul',

            // Sub-genres of Salsa
            'salsa_dura' => 'Salsa Dura',
            'salsa_romantica' => 'Salsa Romántica',
            'new_york_style' => 'New York Style',
            'puerto_rican_style' => 'Puerto Rican Style',
            'latin_jazz' => 'Latin Jazz',
            'colombian_salsa' => 'Colombian Salsa',
            'charanga' => 'Charanga',
            'crossbody' => 'Crossbody Salsa',
            'cuban_salsa' => 'Cuban Salsa',
            'urban_salsa' => 'Urban Salsa',

            // Sub-genres of Funk
            'funk' => 'Funk',
            'boogie' => 'Boogie',
            'p-funk' => 'P-Funk',
            'soul-funk' => 'Soul Funk',
            'jazz-funk' => 'Jazz Funk',
            'psychadelic-funk' => 'Psychedelic Funk',
            'disco-funk' => 'Disco Funk',
            'funk-rock' => 'Funk Rock',
            'funk-metal' => 'Funk Metal',
            'new-funk' => 'New Funk',
            'funk-house' => 'Funk House',
            'blaxploitation' => 'Blaxploitation',
            'retro-funk' => 'Retro Funk',
            'lo-fi-funk' => 'Lo-Fi Funk',

            // Sub-genres of Disco
            'classic' => 'Classic Disco',
            'french' => 'French Disco',
            'italo' => 'Italo Disco',
            'hi_nrg' => 'Hi-NRG',
            'disco_funk' => 'Disco Funk',
            'soul' => 'Soul Disco',
            'disco_rock' => 'Disco Rock',
            'disco_house' => 'Disco House',
            'disco_tech' => 'Disco Tech',
            'nu_disco' => 'Nu Disco',
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',

            // Sub-genres of Alternative
            'alternative_rock' => 'Alternative Rock',
            'indie_rock' => 'Indie Rock',
            'post_punk' => 'Post Punk',
            'grunge' => 'Grunge',
            'dream_pop' => 'Dream Pop',
            'shoegaze' => 'Shoegaze',
            'folk_rock' => 'Folk Rock',
            'progressive_rock' => 'Progressive Rock',
            'noise_rock' => 'Noise Rock',
            'ambient' => 'Ambient',
            'new_wave' => 'New Wave',
            'synthpop' => 'Synthpop',
            'industrial' => 'Industrial',
            'ethereal_wave' => 'Ethereal Wave',
            'math_rock' => 'Math Rock',
            'emo' => 'Emo',
            'garage_rock' => 'Garage Rock',
            'surf_rock' => 'Surf Rock',

            // Sub-genres of Indie
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'folk' => 'Folk',
            'lo-fi' => 'Lo-fi',
            'synth-pop' => 'Synth-pop',
            'alternative' => 'Alternative',
            'indie-rock' => 'Indie Rock',
            'indie-pop' => 'Indie Pop',
            'post-rock' => 'Post Rock',
            'chamber-pop' => 'Chamber Pop',
            'art-pop' => 'Art Pop',
            'dream-pop' => 'Dream Pop',
            'math-rock' => 'Math Rock',
            'indie-folk' => 'Indie Folk',
            'electro-folk' => 'Electro Folk',

            // Sub-genres of Trap
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'lofi' => 'Lofi',
            'hardtrap' => 'Hard Trap',
            'cloudtrap' => 'Cloud Trap',
            'trapmetal' => 'Trap Metal',
            'dirtysouth' => 'Dirty South',
            'chicago' => 'Chicago',
            'phonk' => 'Phonk',
            'future' => 'Future Trap',

            // Sub-genres of World
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'african' => 'African',
            'eggae' => 'Reggae',
            'flamenco' => 'Flamenco',
            'klezmer' => 'Klezmer',
            'celtic' => 'Celtic',
            'latin' => 'Latin',
            'samba' => 'Samba',
            'bossa_nova' => 'Bossa Nova',
            'gamelan' => 'Gamelan',
            'bluegrass' => 'Bluegrass',
            'fado' => 'Fado',
            'tuvan' => 'Tuvan',
            'native_american' => 'Native American',
            'polka' => 'Polka',
            'worldbeat' => 'Worldbeat',

            // Sub-genres of New Age
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'ambient' => 'Ambient',
            'tribal' => 'Tribal',
            'neoclassical' => 'Neoclassical',
            'world' => 'World',
            'nature' => 'Nature Sounds',
            'spiritual' => 'Spiritual',
            'meditative' => 'Meditative',
            'healing' => 'Healing',
            'instrumental' => 'Instrumental',

            // Sub-genres of Soundtrack New Age
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'ambient' => 'Ambient',
            'neoclassical' => 'Neoclassical',
            'chillout' => 'Chillout',
            'cinematic' => 'Cinematic',
            'electronic' => 'Electronic',
            'fusion' => 'Fusion',
            'instrumental' => 'Instrumental',
            'new_age' => 'New Age',
            'ethereal' => 'Ethereal',

            // Sub-genres of Afrobeat
            'afro-fusion' => 'Afro-Fusion',
            'afro-soul' => 'Afro-Soul',
            'afro-house' => 'Afro-House',
            'afro-jazz' => 'Afro-Jazz',
            'afro-pop' => 'Afro-Pop',
            'afrobeat' => 'Afrobeat',
            'highlife' => 'Highlife',
            'juju' => 'Juju',
            'fela-kuti' => 'Fela Kuti Style',
            'contemporary-afrobeat' => 'Contemporary Afrobeat',
            'soukous' => 'Soukous',
            'kuduro' => 'Kuduro',
            'azonto' => 'Azonto',

            // Sub-genres of Dubstep
            'dub' => 'Dub',
            'brostep' => 'Brostep',
            'deep dubstep' => 'Deep Dubstep',
            'future garage' => 'Future Garage',
            'trap' => 'Trap',
            'wonky' => 'Wonky',
            'step' => 'Step',
            'halftime' => 'Halftime',
            'glitch hop' => 'Glitch Hop',
            'heavy dubstep' => 'Heavy Dubstep',
            'UK garage' => 'UK Garage',
            'post-dubstep' => 'Post-Dubstep',
            'moombahton' => 'Moombahton',
            'drumstep' => 'Drumstep',
            'skate punk' => 'Skate Punk',
            'jungle' => 'Jungle',

            // Sub-genres of Future Bass
            'hindustani' => 'Hindustani',
            'carnatic' => 'Carnatic',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',
            'chillstep' => 'Chillstep',
            'vaporwave' => 'Vaporwave',
            'trap' => 'Trap',
            'juke' => 'Juke',
            'futurepop' => 'Future Pop',
            'lofi' => 'Lofi Future Bass',

            // Sub-genres of World Music
            'samba' => 'Samba',
            'bhangra' => 'Bhangra',
            'reggae' => 'Reggae',
            'afrobeat' => 'Afrobeat',
            'flamenco' => 'Flamenco',
            'kuhmo' => 'Kuhmo',
            'celtic' => 'Celtic',
            'traditional' => 'Traditional',
            'folklore' => 'Folklore',
            'bluegrass' => 'Bluegrass',
            'jazz' => 'Jazz',
            'blues' => 'Blues',
            'latin' => 'Latin',
            'sufi' => 'Sufi',
            'ambient' => 'Ambient',
            'new-age' => 'New Age',
            'fusion' => 'Fusion',
            'worldbeat' => 'Worldbeat',
            'ethnic' => 'Ethnic',
            'tribal' => 'Tribal',
            'polka' => 'Polka',
            'gypsy' => 'Gypsy',
            'carnival' => 'Carnival',
            'socca' => 'Socca',
            'charanga' => 'Charanga',
            'caribbean' => 'Caribbean',
            'gypsy-jazz' => 'Gypsy Jazz',
            'bossa-nova' => 'Bossa Nova',
            'cumbia' => 'Cumbia',
            'kalinka' => 'Kalinka',
            'harlem' => 'Harlem',
            'klezmer' => 'Klezmer',
            'qabalah' => 'Qabalah',
            'istanbul' => 'Istanbul',
            'cuban' => 'Cuban',
            'maracatu' => 'Maracatu',
            'jig' => 'Jig',
            'ud' => 'Ud',
            'katak' => 'Katak',
            'balalaika' => 'Balalaika',
            'tuvan' => 'Tuvan',
            'paraguayan' => 'Paraguayan',
            'gnawa' => 'Gnawa',
            'koto' => 'Koto',
            'mandolin' => 'Mandolin',

            // Sub-genres of Indian
            'hindustani' => 'Hindustani Classical',
            'carnatic' => 'Carnatic Classical',
            'folk' => 'Folk Music',
            'devotional' => 'Devotional Music',
            'fusion' => 'Fusion',
            'sufi' => 'Sufi Music',
            'bollywood' => 'Bollywood Music',
            'qawwali' => 'Qawwali',
            'ghazal' => 'Ghazal',
            'bhangra' => 'Bhangra',
            'raaga' => 'Raaga',
            'dhruvapad' => 'Dhruvapad',
            'light' => 'Light Music',
            'instrumental' => 'Instrumental',
            'baroque' => 'Baroque',
            'romantic' => 'Romantic',

            // Sub-genres of Indian Devotional
            'hindustani' => 'Hindustani Classical',
            'carnatic' => 'Carnatic Classical',
            'bhajan' => 'Bhajan',
            'kirtan' => 'Kirtan',
            'arti' => 'Arti',
            'chalisa' => 'Chalisa',
            'sufi' => 'Sufi',
            'shloka' => 'Shloka',
            'mantra' => 'Mantra',
            'baroque' => 'Baroque',
            'folk' => 'Folk Devotional',
            'qawwali' => 'Qawwali',
            'gospel' => 'Gospel'
        ];
    }
}


if (!function_exists("MusicMood")) {
    function MusicMood()
    {
        return [
            'happy' => 'Happy',
            'sad' => 'Sad',
            'relaxed' => 'Relaxed',
            'energetic' => 'Energetic',
            'melancholic' => 'Melancholic',
            'uplifting' => 'Uplifting',
            'romantic' => 'Romantic',
            'nostalgic' => 'Nostalgic',
            'calm' => 'Calm',
            'intense' => 'Intense',
            'mysterious' => 'Mysterious',
            'joyful' => 'Joyful',
            'chill' => 'Chill',
            'motivational' => 'Motivational',
            'dark' => 'Dark',
            'playful' => 'Playful',
            'reflective' => 'Reflective',
            'dreamy' => 'Dreamy',
            'passionate' => 'Passionate',
            'soothing' => 'Soothing',
            'aggressive' => 'Aggressive',
            'festive' => 'Festive',
            'serene' => 'Serene',
            'adventurous' => 'Adventurous',
            'dramatic' => 'Dramatic',
            'haunting' => 'Haunting',
            'spiritual' => 'Spiritual',
            'uplifting' => 'Uplifting',
            'bittersweet' => 'Bittersweet',
            'hopeful' => 'Hopeful',
            'angry' => 'Angry',
            'silly' => 'Silly',
            'introspective' => 'Introspective',
            'whimsical' => 'Whimsical',
            'romantic' => 'Romantic',
            'mellow' => 'Mellow',
            'heartwarming' => 'Heartwarming',
            'suspenseful' => 'Suspenseful',
        ];
    }
}


if (!function_exists("SongLanguages")) {
    function SongLanguages()
    {
        return [
            'hindi' => 'Hindi',
            'english' => 'English',
            'punjabi' => 'Punjabi',
            'bengali' => 'Bengali',
            'tamil' => 'Tamil',
            'telugu' => 'Telugu',
            'marathi' => 'Marathi',
            'gujarati' => 'Gujarati',
            'malayalam' => 'Malayalam',
            'kannada' => 'Kannada',
            'odia' => 'Odia',
            'assamese' => 'Assamese',
            'sanskrit' => 'Sanskrit',
            'dogri' => 'Dogri',
            'konkani' => 'Konkani',
            'sindhi' => 'Sindhi',
            'manipuri' => 'Manipuri',
            'bodo' => 'Bodo',
            'santali' => 'Santali',
            'kashmiri' => 'Kashmiri',
            'maithili' => 'Maithili',
            'nepali' => 'Nepali',
            'rajbanshi' => 'Rajbanshi',
            'bhili' => 'Bhili',
            'chhattisgarhi' => 'Chhattisgarhi',
            'magahi' => 'Magahi',
            'rajasthani' => 'Rajasthani',
            'marwari' => 'Marwari',
            'haryanvi' => 'Haryanvi',
            'angika' => 'Angika',
            'khasi' => 'Khasi',
            'mizo' => 'Mizo',
            'bishnupriya manipuri' => 'Bishnupriya Manipuri',
            'tulu' => 'Tulu',
            'halbi' => 'Halbi',
            'garhwali' => 'Garhwali',
            'kokborok' => 'Kokborok',
            'sourashtra' => 'Sourashtra',
            'gadaba' => 'Gadaba',
            'bhutia' => 'Bhutia',
            'ao' => 'Ao',
            'deori' => 'Deori',
            'gangte' => 'Gangte',
            'ghotuo' => 'Ghotuo',
            'gondi' => 'Gondi',
            'gujjar bhakha' => 'Gujjar Bhakha',
            'ho' => 'Ho',
            'juang' => 'Juang',
            'kannada kuri' => 'Kannada Kuri',
            'karbi' => 'Karbi',
            'kashmiri pahari' => 'Kashmiri Pahari',
            'khampti' => 'Khampti',
            'khamyang' => 'Khamyang',
            'khortha' => 'Khortha',
            'kodava' => 'Kodava',
            'kui' => 'Kui',
            'kurukh' => 'Kurukh',
            'ladakhi' => 'Ladakhi',
            'lamkang' => 'Lamkang',
            'lepcha' => 'Lepcha',
            'lotha' => 'Lotha',
            'mara' => 'Mara',
            'mishing' => 'Mishing',
            'mohpa' => 'Mohpa',
            'mru' => 'Mru',
            'nocte' => 'Nocte',
            'nyishi' => 'Nyishi',
            'pangchenpa' => 'Pangchenpa',
            'patelia' => 'Patelia',
            'rengma' => 'Rengma',
            'saraiki' => 'Saraiki',
            'sherpa' => 'Sherpa',
            'shina' => 'Shina',
            'singpho' => 'Singpho',
            'thado' => 'Thado',
            'thoibi' => 'Thoibi',
            'thulung' => 'Thulung',
            'tikhak' => 'Tikhak',
            'tongsa' => 'Tongsa',
            'wancho' => 'Wancho',
            'zeliangrong' => 'Zeliangrong',
            'zeme' => 'Zeme',
            'badaga' => 'Badaga',
            'bagheli' => 'Bagheli',
            'bagri' => 'Bagri',
            'barela' => 'Barela',
            'barma' => 'Barma',
            'bateri' => 'Bateri',
            'beary' => 'Beary',
            'bhilodi' => 'Bhilodi',
            'burushaski' => 'Burushaski',
            'dungra bhil' => 'Dungra Bhil',
            'dura' => 'Dura',
            'gadwali' => 'Gadwali',
            'gaddi' => 'Gaddi',
            'galatga' => 'Galatga',
            'gamit' => 'Gamit',
            'garasia' => 'Garasia',
            'gowlan' => 'Gowlan',
            'gowlan jantri' => 'Gowlan Jantri',
            'kathiyawadi' => 'Kathiyawadi',
            'kho' => 'Kho',
            'koli' => 'Koli',
            'kumaoni' => 'Kumaoni',
            'malto' => 'Malto',
            'mavchi' => 'Mavchi',
            'meena' => 'Meena',
            'muria' => 'Muria',
            'pali' => 'Pali',
            'pardhi' => 'Pardhi',
            'rangkas' => 'Rangkas',
            'riang' => 'Riang',
            'sambalpuri' => 'Sambalpuri',
            'seka' => 'Seka',
            'sholaga' => 'Sholaga',
            'sirha' => 'Sirha',
            'thakuri' => 'Thakuri',
            'tirunelveli' => 'Tirunelveli',
            'toda' => 'Toda',
            'vaalipora' => 'Vaalipora',
            'valvi' => 'Valvi',
            'vasava' => 'Vasava',
            'dogri' => 'Dogri',
            'konkani' => 'Konkani',
            'sindhi' => 'Sindhi',
            'manipuri' => 'Manipuri',
            'bodo' => 'Bodo',
            'santali' => 'Santali',
            'kashmiri' => 'Kashmiri',
            'maithili' => 'Maithili',
        ];
    }
}

