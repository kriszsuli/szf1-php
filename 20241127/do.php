<?php
    require_once('cookman.php');

    if(is_null($_GET["task"]) or is_null($_GET["id"]) or is_null($_GET["from"])) {
        header('Location: index.php');
        exit();
    }

    $stask = $_GET["task"];
    $id = $_GET["id"];
    $from = $_GET["from"];

    $tasks = get_cookie_array();
    $task = array();

    foreach($tasks as $itask) {
        if($itask["id"] == $id) {
            $task = $itask;
            break;
        }
    }

    if(empty($task)) {
        header("Location: index.php");
        exit();
    }

    switch($stask) {
        case "complete":
            foreach ($tasks as &$itask) {
                if ($itask["id"] == $id) {
                    $itask["completed"] = 1;
                    break;
                }
            }
            break;
        case "progress":
            foreach ($tasks as &$itask) {
                if ($itask["id"] == $id) {
                    $itask["completed"] = 0;
                    break;
                }
            }
            break;
        case "delete":
            $tasks = array_filter($tasks, function($itask) use ($id) {
                return $itask["id"] != $id;
            });
            $tasks = array_values($tasks);
            break;
        default:
            header('Location: index.php');
            exit();
    }

    save_cookie_array($tasks);
    if ($from === "view") {
        header("Location: view.php?id=" . $id);
    } else {
        header("Location: index.php");
    }

?>