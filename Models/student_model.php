<?php

function m_get_data() {

    $query = "SELECT st.id,firstname,lastname,sex,cl.title 
                FROM student st 
                LEFT JOIN class cl ON cl.id = st.class_id";

    include "connection.php";
  
    $result = mysqli_query($connection,$query);
 
    $rows = [];
   
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
           
            $rec = [];
            $subject = [];
            $querySubject = "SELECT sub_title FROM subjects su
                                INNER JOIN student_has_subjects ss ON su.id = ss.subjects_id
                                INNER JOIN student st ON st.id = ss.student_id
                                WHERE st.id=".$record['id'];
      
            $res = mysqli_query($connection,$querySubject);
       
            foreach($res as $sub){
               array_push($subject,$sub['sub_title']);               
            }
           
            $rec = $record;
            $rec['sub_title'] = $subject;      
            array_push($rows,$rec);
        }
        
    }
  
    return $rows;
}

function get_class_data() {
    $query = "select * from class";
    include "connection.php";
    $result = mysqli_query($connection,$query);
    $rows = [];
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
            $rows[] = $record;
        }
    }
    return $rows;
}

function get_subject_data() {
    $query = "select * from subjects";
    include "connection.php";
    $result = mysqli_query($connection,$query);
    $rows = [];
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
            $rows[] = $record;
        }
    }
    return $rows;
}

function get_subject() {
    $query = "select * from subjects";
    include "connection.php";
    $result = mysqli_query($connection,$query);
    $rows = [];
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
            $rows[] = $record;
        }
    }
    return $rows;
}



function student_add_data($data) {
    include "connection.php";
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $sex = $_POST['sex'];
    $class_id = $_POST['class'];
    $subjects= $_POST['subjects'];

    $query = "INSERT INTO student(firstname,lastname,sex,class_id)
              VALUES('$firstname','$lastname','$sex','$class_id')";
    mysqli_query($connection, $query);

    foreach ($subjects as $subject) {
        $last_student = "SELECT id FROM student ORDER BY id DESC LIMIT 1";
        $last_student = mysqli_query($connection, $last_student);
        foreach ($last_student as $student_id) {
            $id = $student_id['id'];
            $query_subject = "INSERT INTO student_has_subjects(student_id, subjects_id) VALUES($id,$subject)";
        }
        $result = mysqli_query($connection, $query_subject);
    }

    return $result;
}

function delete_student() {
    $id = $_GET['id'];
    $query = "DELETE FROM student WHERE id = $id";
    include "connection.php";
    $result = mysqli_query($connection,$query);
   
    return $result;
}

function student_detail() {
    $id = $_GET['id'];
    $query = "SELECT st.id,firstname,lastname,sex,cl.title 
                FROM student st 
                LEFT JOIN class cl ON cl.id = st.class_id WHERE st.id = $id";

    include "connection.php";
  
    $result = mysqli_query($connection,$query);
 
    $rows = [];
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
            $rec = [];
            $subject = [];
            $querySubject = "SELECT sub_title FROM subjects su
                                INNER JOIN student_has_subjects ss ON su.id = ss.subjects_id
                                INNER JOIN student st ON st.id = ss.student_id
                                WHERE st.id=".$record['id'];
      
            $res = mysqli_query($connection,$querySubject);
       
            foreach($res as $sub){
               array_push($subject,$sub['sub_title']);               
            }
           
            $rec = $record;
            $rec['sub_title'] = $subject;      
            array_push($rows,$rec);
        }
    }
    return $rows;
}

function student_subject() {
    $id = $_GET['id'];
    $query = "SELECT sub_title FROM subjects su
                INNER JOIN student_has_subjects ss ON su.id = ss.subjects_id
                INNER JOIN student st ON st.id = ss.student_id
                WHERE st.id= $id";

    include "connection.php";
    $result = mysqli_query($connection,$query);
    $rows = [];
    if($result && mysqli_num_rows($result) > 0 ){
        foreach ($result as $record) {
            $rows[] = $record;
        }
    }
    return $rows;
}
function student_edit($data){
    $id = $_GET['id'];
    include "connection.php";
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $sex = $_POST['sex'];
    $class_id = $_POST['class'];
    
    $query = "UPDATE student SET firstname='$firstname',lastname='$lastname',sex='$sex', class_id='$class_id'  WHERE id = $id";
    mysqli_query($connection, $query);

    $subjects= $_POST['subjects'];
    $remove_subject = "DELETE FROM student_has_subjects WHERE student_id=$id";
    mysqli_query($connection, $remove_subject);
    foreach ($subjects as $subject) {
        $subject_id = "SELECT id FROM subjects WHERE sub_title ='$subject'";
        $select_subject = mysqli_query($connection, $subject_id);
        foreach ($select_subject as $sub) {
            $sub_id = $sub['id'];
            
            $update_subject = "INSERT INTO student_has_subjects(student_id, subjects_id) VALUES($id,$sub_id)";
        }
        $result = mysqli_query($connection, $update_subject);
    }

    return $result;
}


