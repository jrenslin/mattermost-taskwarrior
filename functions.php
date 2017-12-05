<?PHP

function sendOutput ($text, $response_type = "in_channel") {
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

function addTask ($description, $project) {

    if (!is_array($description)) die ("Input is not an array.");
    $description = join(" ", $description);

    $output = shell_exec ("task add project:".escapeshellarg($project)." ".escapeshellarg($description));
    return $output;

}

function getTasks ($project) {

    $output = shell_exec ("task project:".escapeshellarg($project));
    return $output;
    
}

?>
