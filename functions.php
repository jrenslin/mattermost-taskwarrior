<?PHP

// ########
// Function to insert output string to a suitable output string (in JSON),
// that can be parsed by mattermost
// Output text is returned as code (hence markdown's ```)
// ########

function sendOutput ($text, $response_type = "in_channel") {
    $text = trim($text);
    $output = array (
        "response_type" => $response_type,
        "text" => "
```
$text
```"
    );
    echo json_encode ($output);
    exit;
}

// ########
// Function for adding tasks
// ########

function addTask ($description, $project) {

    // Check: If the description is not an array, return an error message and exit.
    if (!is_array($description)) sendOutput ("Input is not an array.");

    $description = join(" ", $description);

    // Run taskwarrior to add the new task
    $output = shell_exec ("task add project:".escapeshellarg($project)." ".escapeshellarg($description));
    return $output;

}

// ########
// Function for completing tasks
// ########

function completeTask ($id, $project) {

    // Check whether the provided ID can be an integer. If it's not a valid ID, return an error message.
    if (!is_numeric($id)) {
        sendOutput ("Error: The provided ID is no ID.");
    }

    $allowedIDs = shell_exec ("task _ids project:".escapeshellarg($project)); // Get ids associated with the current channel / project
    $allowedIDs = explode (PHP_EOL, trim($allowedIDs));                       // Get an array of the IDs
    $allowedIDs = array_diff ($allowedIDs, array(" "));                       // Remove empty entries from array

    // Check if the current task really belongs to this channel.
    if (!in_array($id, $allowedIDs)) {
        sendOutput ("Error: Completing task with this ID is not allowed in this channel.");
    }

    // Tell taskwarrior that the task is complete
    $output = shell_exec ("task ".escapeshellarg($id)." done");
    return $output;

}

// ########
// Function for reading tasks associated to some project
// ########

function getTasks ($project) {

    // Tell taskwarrior to return all tasks with the specified project / channel
    $output = shell_exec ("task project:".escapeshellarg($project));
    return $output;
    
}

?>
