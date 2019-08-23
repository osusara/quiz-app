<?php

	// to verify queries
	function verify_query($result_set){

		global $connection;

		if(!$result_set){
			die("Database query failed!".mysqli_error($connection));
		}
	}

	// to check required fields
	function check_req_fields($req_fields){
		$errors = array();

		foreach ($req_fields as $field) {
			if(empty(trim($_POST[$field]))){
				$errors[] = $field.' is required';
			}
		}

		return $errors;
	}

	// To check max character count in a field
	function check_max_len($max_len_fields){

		$errors = array();

		// Check max length
		foreach ($max_len_fields as $field => $max_len) {
            if(strlen(trim($_POST[$field])) > $max_len){
                $errors[] = $field.' length must be less than '.$max_len.' characters.';
            }
        }

        return $errors;
	}


	// To display errors
	function display_errors($errors){

		// Format and display form errors
		echo '<div class="alert alert-danger">';
        echo '<b>There are '.count($errors).' errors in your form! Please check before go any further.</b><br>';
        foreach ($errors as $error) {
        	$error = ucfirst(str_replace("_", " ", $error));
            echo ' - '.$error.'<br>';
        }
        echo '</div>';
	}

	// To display messeges
	function display_messege($messege){

		// Format and display form errors
		echo '<div class="alert alert-success text-center">';
        echo '<span class="text-center">'.$messege.'</span>';
        echo '</div>';
	}

	// To display warnings
	function display_warning($warning){

		// Format and display form errors
		echo '<div class="alert alert-warning text-center">';
        echo '<span class="text-center">'.$warning.'</span>';
        echo '</div>';
	}

?>