<?PHP

error_reporting(E_ALL);
ini_set("display_errors", 1);

// ########
// Read settings and check for token
// ########

include_once ("settings.php");
if (!in_array($_POST["token"], $allowedTokens)) {
    http_response_code (405); die ("Access not allowed.");
}

// ########
// Send HTTP headers 
// ########

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// ########
// Get functions from file
// ########

include_once ("functions.php");

// ########
// Read text as arguments for `task`
// ########

$commands = explode (" ", $_POST["text"]);          // Read words into an array
$commands = array_diff ($commands, array(" "));     // Remove empty strings from array

// ########
// Allow adding tasks
// ########

if (count($commands) > 1 && $commands[0] == "add") {
    $output = addTask (array_slice ($commands, 1), $_POST["channel_name"]);
    sendOutput ($output);
}

// ########
// Completing tasks
// ########

else if (count($commands) == 2 && $commands[1] == "done") {
    $output = completeTask ($commands[0], $_POST["channel_name"]);
    sendOutput ($output);
}

// ########
// Default: Show tasks for the project / channel you're in
// ########

$output = getTasks ($_POST["channel_name"]);
sendOutput ($output);

?>

