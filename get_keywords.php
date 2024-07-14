<?php
include("../config/config.php");


     $api_key=[];
              $api_key[]  = "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";

              $api_key[]  = "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";

              $api_key[]  = "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";

              $api_key[]  = "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";

              $api_key[]  = "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";
	
    
              $county_zip=$_POST['county_zip'];

             
             
             


			$prompt   = 'Objective: to get answer on following question in text format for Zip code '.$county_zip.' from USA Country and Georgia State. 
        Dont mention zip code in answer. Only add actual data. dont put fake names:
        Include question title before answer like Question :  Answer format
        Dont add * in answer and after each answer make 2 line breaks using \n
        Dont add question in response. Only answers.. Dont add answer prefix also..
        Each answer should be on new line and after each answer add @@@
        County Name?
        City Name?
        Mayor Name?
        Total Population?
        
        Male Population?
       
        Female Population?
       
        Democratic Voters?
        Republic Voters?
       
        Independent Voters?

        Average Age of Voters?

        Total Schools?

        Schools Rating out of 10?

        City Manager?
        City Clerk?
        Finance Director?
        Public Works Director?
        Police Chief?
        Fire Chief?
        Parks and Recreation Director?
        Planning and Zonning Director?
        Economic Development Director?
        Human Resource Director?
        Information Technology Director?
        Utilities Director?
        Housing and Community Development Director?
        Envirnmental Services Director?
        City Attorney?

        All Forthcoming elections and dates(separate line for each election and its date)?
        ';

       
      $max_token = 1000;

	
      $ch = curl_init('https://api.openai.com/v1/chat/completions');

      $data = array(
          'model' => 'gpt-4-turbo', // GPT-4 Turbo model identifier
          'messages' => array(
              array('role' => 'system', 'content' => 'You are a helpful assistant.'),
              array('role' => 'user', 'content' => $prompt)
          ),
          'max_tokens' => $max_token,
          'temperature' => 0.7, // Example temperature setting, adjust as needed
          'stop' => '\n', // Stop condition for the completion
      );
      
      $headers = array(
          'Content-Type: application/json',
          'Authorization: Bearer ' . $api_key[0],
      );
      
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      
      $response = curl_exec($ch);
      


			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      //echo "<pre>";
      //print_r(json_decode($response));

			if (curl_errno($ch)) {
				$error_message = curl_error($ch);
        echo $error_message;
        $response=array("result"=>"");
			} else {
				$response_data = json_decode($response, true);
				$new_description = trim($response_data['choices'][0]['message']['content'])!='' ?trim($response_data['choices'][0]['message']['content']):"";
				$response=array("result"=>$new_description);

        
        $db_data=mysqli_fetch_assoc(mysqli_query($con,"select * from tbl_zip_data where zip='".$county_zip."'"));

        $data=explode("@@@",$new_description);

        $county=$db_data['county']!=''?$db_data['county']:$data[0];
        $city=$db_data['city']!=''?$db_data['city']:$data[1];
        $mayor=$db_data['mayor']!=''?$db_data['mayor']:$data[2];                 
        $total_population=$db_data['total_population']!=''?$db_data['total_population']:$data[3];          
        $male_population=$db_data['male_population']!=''?$db_data['male_population']:$data[4];     
        $female_population=$db_data['female_population']!=''?$db_data['female_population']:$data[5];   
        $democratic_voters=$db_data['democratic_voters']!=''?$db_data['democratic_voters']:$data[6];    
        $rupblic_voters=$db_data['rupblic_voters']!=''?$db_data['rupblic_voters']:$data[7];           
        $independent_voters=$db_data['independent_voters']!=''?$db_data['independent_voters']:$data[8];             
        $avg_age=$db_data['avg_age']!=''?$db_data['avg_age']:$data[9];              
        $total_school=$db_data['total_school']!=''?$db_data['total_school']:$data[10];   
        $school_rating=$db_data['school_rating']!=''?$db_data['school_rating']:$data[11];  
        
        $city_manager=$data[12]; 
        $city_clerk=$data[13]; 
        $finance_director=$data[14]; 
        $public_work_director=$data[15]; 
        $police_chief=$data[16]; 
        $fire_chief=$data[17]; 
        $park_recretion_director=$data[18]; 
        $planning_director=$data[19]; 
        $economic_director=$data[20]; 
        $human_resource_director=$data[21]; 
        $it_director=$data[22]; 
        $utility_director=$data[23]; 
        $housing_director=$data[24]; 
        $environment_director=$data[25]; 
        $city_attorney=$data[26]; 

        $upcoming_elections=$data[27]; 
       

        $arr=array(
          "county"=>$county,            
          "city"=>$city,             
          "mayor"=>$mayor,                   
          "total_population"=>$total_population,          
          "male_population"=>$male_population,     
          "female_population"=>$female_population,   
          "democratic_voters"=>$democratic_voters,    
          "rupblic_voters"=>$rupblic_voters,           
          "independent_voters"=>$independent_voters,             
          "avg_age"=>$avg_age,              
          "total_school"=>$total_school,   
          "school_rating"=>$school_rating,

          "city_manager"=>$city_manager,          
          "city_clerk"=>$city_clerk,             
          "finance_director"=>$finance_director,       
          "public_work_director"=>$public_work_director,   
          "police_chief"=>$police_chief,          
          "fire_chief"=>$fire_chief,           
          "park_recretion_director"=>$park_recretion_director,
          "planning_director"=>$planning_director,      
          "economic_director"=>$economic_director,      
          "human_resource_director"=>$human_resource_director,
          "it_director"=>$it_director,          
          "utility_director"=>$utility_director,     
          "housing_director"=>$housing_director,     
          "environment_director"=>$environment_director,  
          "city_attorney"=>$city_attorney,     
          "upcoming_elections"=>$upcoming_elections   

        );

        mysqli_query($con,"insert into tbl_county_information(
          zip,               
          county,            
          city,              
          mayor,             
          total_population,  
          male_population,   
          female_population, 
          democratic_voters, 
          rupblic_voters,    
          independent_voters,
          avg_age,           
          total_school,      
          school_rating,  
          
          city_manager ,          
          city_clerk,             
          finance_director,       
          public_work_director,   
          police_chief,           
          fire_chief,             
          park_recretion_director,
          planning_director,      
          economic_director ,     
          human_resource_director,
          it_director,            
          utility_director,       
          housing_director,       
          environment_director,   
          city_attorney,          
          upcoming_elections,     

          
          user_id           
          )
          values
          (
          '".$county_zip."',
          '".mysqli_real_escape_string($con,$county)."',
          '".mysqli_real_escape_string($con,$city)."',            
          '".mysqli_real_escape_string($con,$mayor)."',        
          '".mysqli_real_escape_string($con,$total_population)."',    
          '".mysqli_real_escape_string($con,$male_population)."',  
          '".mysqli_real_escape_string($con,$female_population)."',   
          '".mysqli_real_escape_string($con,$democratic_voters)."',         
          '".mysqli_real_escape_string($con,$rupblic_voters)."',            
          '".mysqli_real_escape_string($con,$independent_voters)."',             
          '".mysqli_real_escape_string($con,$avg_age)."',  
          '".mysqli_real_escape_string($con,$total_school)."',         
          '".mysqli_real_escape_string($con,$school_rating)."',  

          '".mysqli_real_escape_string($con,$city_manager)."' ,          
          '".mysqli_real_escape_string($con,$city_clerk)."',             
          '".mysqli_real_escape_string($con,$finance_director)."',       
          '".mysqli_real_escape_string($con,$public_work_director)."',   
          '".mysqli_real_escape_string($con,$police_chief)."',           
          '".mysqli_real_escape_string($con,$fire_chief)."',             
          '".mysqli_real_escape_string($con,$park_recretion_director)."',
          '".mysqli_real_escape_string($con,$planning_director)."',      
          '".mysqli_real_escape_string($con,$economic_director)."' ,     
          '".mysqli_real_escape_string($con,$human_resource_director)."',
          '".mysqli_real_escape_string($con,$it_director)."',            
          '".mysqli_real_escape_string($con,$utility_director)."',       
          '".mysqli_real_escape_string($con,$housing_director)."',       
          '".mysqli_real_escape_string($con,$environment_director)."',   
          '".mysqli_real_escape_string($con,$city_attorney)."',          
          '".mysqli_real_escape_string($con,$upcoming_elections)."', 

          '".$_POST['user_id']."'
          )");

			}

         
         echo json_encode($arr);
												
                   
