<?php
session_start();
include 'db.php';

// Sample action file using a "users" table - make copies and tweak as necessary
$db = new \Main\db();
$tblName = 'pdo_users';
if(isset($_REQUEST['action_type']) && !empty($_REQUEST['action_type'])){
    if($_REQUEST['action_type'] == 'add'){
        $userData = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone']
        );
        $insert = $db->insert($tblName,$userData);
        $statusMsg = $insert?'User data has been inserted successfully.':'Some problem occurred, please try again.';
        $_SESSION['statusMsg'] = $statusMsg;
        header("Location:index.php");
    }elseif($_REQUEST['action_type'] == 'edit'){
        if(!empty($_POST['id'])){
            $userData = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            );
            $condition = array('id' => $_POST['id']);
            $update = $db->update($tblName,$userData,$condition);
            $statusMsg = $update?'User data has been updated successfully.':'Some problem occurred, please try again.';
            $_SESSION['statusMsg'] = $statusMsg;
            header("Location:index.php");
        }
    }elseif($_REQUEST['action_type'] == 'delete'){
        if(!empty($_GET['id'])){
            $condition = array('id' => $_GET['id']);
            $delete = $db->delete($tblName,$condition);
            $statusMsg = $delete?'User data has been deleted successfully.':'Some problem occurred, please try again.';
            $_SESSION['statusMsg'] = $statusMsg;
            header("Location:index.php");
        }
    }
}