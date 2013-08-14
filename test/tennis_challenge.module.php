<?php
require_once(DRUPAL_ROOT . "/modules/node/node.pages.inc");
	function tennis_challenge_menu(){

		$items['accept-deny-reproposed-date/%/%'] = array(
			'page callback' => 'reproposedDate_callback',
    		'page arguments' => array(1, 2),
			'access callback' => true,
			'type' => MENU_CALLBACK,
		);

		$items['verify-result/%'] = array(
			'page callback' => 'verifyResult',
			'page arguments' => array(1),
			'access callback' => true,
			
		);
		
		$items['join-ladder/%'] = array(
			'page callback' => 'registerPlayerToLadder',
			'page arguments' => array(1),
			'access callback' => true,
		);
		
		$items['notify-me/%/%'] =  array(
			'page callback' => 'notifyMe',
			'page arguments' => array(1, 2),
			'access callback' => true,
		);

		$items['freeze-player/%/%'] = array(
			'page callback' => 'freezePlayer',
			'page arguments' => array(1, 2),
			'access callback' => true,
		);
		
		$items['de-freeze-player/%/%'] = array(
			'page callback' => 'deFreezePlayer',
			'page arguments' => array(1, 2),
			'access callback' => true,
		);
		
		$items['submit-review/%/%'] = array(
			'page callback' => 'submitReview',
			'page arguments' => array(1, 2),
			'access callback' => true,
		);
		
		$items['toggle'] = array(
			'page callback' => 'toggleRole',
			'access callback' => true,
		);
		
		$items['dispute/%/%'] = array(
			'page callback' => 'drupal_get_form',
			'page arguments' => array('enter_dispute_form'),
			'access callback' => true,
		);
		
		$items['remove/%/%'] = array(
			'page callback' => 'removePlayer',
			'page arguments' => array(1, 2),
			'access callback' => true,
		);
		
		return $items;
	}

	function tennis_challenge_cron(){ 
	
		deleteUncofirmedRequests(); // delete challenge requests if the time has passed
		
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.frozen', '1', '=')
			->fields('t', array('sno', 'defreeze_date'));
		  
		$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
		  
		foreach($results as $result){
			if(time() >= $result['defreeze_date']){
				db_update('tennis_challenge_ladder_player')
					->fields(array(
						'frozen' => 0,
					))
					->condition('sno', $result['sno'], '=')
					->execute();
			}
		}
		
		$query = new EntityFieldQuery();

		$query->entityCondition('entity_type', 'node')
		  ->propertyCondition('status', 1)
		  ->propertyCondition('type', 'challenge_request')
		  ->fieldCondition('field_challenge_verified', 'value', 'not verified', '=')
		  ->fieldCondition('field_challenge_result', 'value', 'Result has not been entered yet', '!=')
		  ->addMetaData('account', user_load(1)); // Run the query as user 1.
		  
			$currentDate = strtotime('now');
			$results = $query->execute();

		 foreach($results['node'] as $result){		

			$node = node_load($result->nid);
			$verifyResultDate = strtotime($node->field_result_verifying_date['und'][0]['value']);
			
			if($currentDate >= $verifyResultDate){	
				verifyResult($node->nid);
			}
		 }
	}

	function tennis_challenge_menu_alter(&$items) {
		$items['coach/register']['type'] = MENU_CALLBACK;
		$items['player/register']['type'] = MENU_CALLBACK;
		$items['user/register']['type'] = MENU_CALLBACK;
		$items['user/%/hybridauth']['type'] = MENU_CALLBACK;
		$items['user/%/view']['type'] = MENU_CALLBACK;
		//$items['user/%/edit']['type'] = MENU_CALLBACK;
	}
	
	function tennis_challenge_form_alter(&$form, &$form_state, $form_id){
		
		global $user;
		
		if($form_id == "views_exposed_form"){
			$form['submit']['#value'] = "Search";
		}
		
		if($form_id == "user_profile_form"){
			unset($form['account']['fboauth']);
			$form['#submit'][] = 'create_pwd_redirect';
		}

		if($form_id == 'ladder_node_form'){

			$profile = profile2_load_by_user($user, 'coach_profile');
			if(!in_array('administrator', $user->roles)){
				$form['field_free_ladder_']['#type'] = 'hidden';
			}
			
			$form['field_ladder_venue']['und'][0]['value']['#default_value'] = $profile->field_preferred_venue['und'][0]['value'];
			$form['actions']['submit']['#value'] = 'Create and Save this Challenge Ladder';
			//$form['#submit'][] = 'ladder_submit_redirect';

			//$form['#validate'][1] = 'custom_validate_redirect';
			//$form['#submit']['value'] = "Create and Save This Challenge Ladder";


		}
		
		 if ($form_id == 'uc_cart_view_form') {
		
			$form['actions']['update']['#type'] = 'hidden';

			foreach ($form['items'] as $k => $item) {
				if (is_array($item) && isset($item['qty'])) {
				  //$form['items'][$k]['qty']['#type'] = 'value';
				  //$form['items'][$k]['qty']['#value'] = 1;
				}
			}
			 unset($form['items']['#columns']['qty']);
		}
		  
		  
		if($form_id == 'user_profile_form'){
			
			$form['#submit'][] = 'profile_form_redirect';
			$form['actions']['submit']['#value'] = 'Save and Login';
		
		}
		
		
	}
	
	function ladder_submit_redirect(){
		global $base_url;
		$link = $base_url.'/coach-panel?qt-ladder_challenge=3#qt-ladder_challenge';
		drupal_goto($link);
	}
	
	function create_pwd_redirect(){
		global $base_url;
		global $user;
		
		if(in_array('coach', $user->roles)){
			$link = $base_url.'/coach-panel';
		}else if(in_array('player', $user->roles)){
			$link = $base_url.'/player-panel';
		}
		
		//drupal_set_message('CONGRATULATIONS!!!! You have been successfully registered.');
		drupal_goto($link);
	}
	
	function custom_validate_redirect(){
		global $base_url;
		$link = $base_url.'/coach-panel?qt-ladder_challenge=1#qt-ladder_challenge';
		drupal_goto($link);
	}

	function profile_form_redirect(){
	
		global $base_url;
		if(in_array('coach', $user->roles)){
			$link = $base_url.'/coach-panel';
		}else if(in_array('player', $user->roles)){
			$link = $base_url.'/player-panel';
		}
		drupal_goto($link);
	}
	
	
	function tennis_challenge_form($form, &$form_state) {
	
			global $user;

			$players = getPlayerListByCoach($user->uid); // players uploaded/created by the coach
			$ladders = getLadderListByCoach($user->uid); // ladders created by the coach
	

		//	$lid = !empty($form_state['values']['name']) ? $form_state['values']['name'] : key($ladders);

			$header = array(
			  'username' => t('Name'),
			  'standard' => t('Standard'),
			  'gender'	 => t('Gender'),
			  'status'	 => t('Status'),
			  //'matches'	 => t('# Matches'),
			);
				
			$form['usertable'] = array(
				'#type' => 'tableselect',
				'#header' => $header,
				'#empty' => t('No content available.'),
				'#options' => $players,
				'#required' => TRUE,
				//'#prefix' => '<ul class="ladder-list"><li>',
				//'#suffix' => '</li>',
			);
			
			$form['name'] = array(
				//'#prefix' => '<b>',
				//'#suffix' => '</b>',
				'#type' => 'select',
				'#title' => t('Ladders List'),
				'#options' => $ladders,
				/*'#default_value' => $lid,
				'#ajax' => array(
				  'callback' => 'tennis_challenge_existingPlayers_callback', 
				  'wrapper' => 'checkboxes-div',
				  'effect' => 'slide',
				  'speed' => 'slow',
				),*/
			 );
			 
			if(!empty($players)){
				$form['dataTab'] = array(
					'#markup' => "<script class='jsbin' src='http://datatables.net/download/build/jquery.dataTables.nightly.js'></script><script>$(document).ready(function(){
									$('table.sticky-enabled').dataTable({
										'oLanguage': {
											'sSearch': 'Search For a Player: '
										}					
									});									
								})</script>",
				);
			}
			
			$form['submit'] = array(
				'#type' => 'submit',
				'#value' => 'Add these players now',
				//'#prefix' => '<li>',
				/*'#suffix' => '</li>
						<div style="clear:both;"></div>
						</ul>',*/
			);
  
			
			
		  return $form;
	}
	
	function tennis_challenge_form_submit($form, &$form_state){
		global $base_url;
		global $user;
		
		$ladder = $form_state['values']['name'];
		foreach($form_state['values']['usertable'] as $key => $value){
		
			//check to see if the user already exists in the ladder
			$exists = db_query('SELECT 1 FROM {tennis_challenge_ladder_player} WHERE playerId = :playerId AND lid = :lid', array(':playerId' => $value, ':lid' => $ladder))->fetchField();
			
			if($value != 0 && $exists == FALSE){
				db_insert('tennis_challenge_ladder_player')
					->fields(array(
						'playerId' => $value,
						'ranking' => 0,
						//'coachId' => $user->uid,
						'lid' => $ladder,
						'won' => 0,
						'lost' => 0,
						'no_of_matches' => 0,
				))
				->execute();
			}
		}
		
		$node = node_load($ladder);
		//if($node->field_ladder_payments['und'][0]['value'] == 1){
			drupal_goto($base_url.'/assign-credits?ladder='.$ladder);
		//}

		//drupal_goto($base_url.'/node/'.$ladder);
		
	}

	function tennis_challenge_get_player_list($ladderId){
		
			$query1 = db_select('tennis_challenge_ladder_player', 'n');

			$query1->join('users', 'u', 'n.playerId = u.uid'); //JOIN node with users
			$query1->condition('n.lid', $ladderId, '=');
			$query1->groupBy('u.uid');//GROUP BY user ID

			$query1->fields('n',array('sno', 'ranking', 'lid', 'playerId','won', 'lost', 'no_of_matches', 'can_challenge'))//SELECT the fields from node
			->fields('u',array('name'))
			->condition('n.ranking', '0', '>')// changed
			->orderby('n.ranking', 'ASC');//SELECT the fields from user


			$results1 = $query1->execute()->fetchAll(PDO::FETCH_ASSOC);

			$query2 = db_select('tennis_challenge_ladder_player', 'n');

			$query2->join('users', 'u', 'n.playerId = u.uid'); //JOIN node with users
			$query2->condition('n.lid', $ladderId, '=');
			$query2->groupBy('u.uid');//GROUP BY user ID

			$query2->fields('n',array('sno', 'ranking', 'lid', 'playerId','won', 'lost', 'no_of_matches', 'can_challenge'))//SELECT the fields from node
			->fields('u',array('name'))
			->condition('n.ranking', '0', '=')
			->orderby('n.sno', 'ASC');
			$results2 = $query2->execute()->fetchAll(PDO::FETCH_ASSOC);

			$results = array_merge($results1, $results2);
			
			return (tennis_challenge_list_render($results, $ladderId));
	}
	
	function tennis_challenge_list_render($results, $ladderId){

		global $base_url;
		global $user;

		$node = node_load($ladderId);
		$coachId = $node->uid;
		
		$endDate = $node->field_ladder_end_date['und'][0]['value'];
		$currentDate = date('Y-m-d H:i:s', strtotime('now'));
		
		$isSignedUp = isSignedUpInLadder($user->uid, $ladderId);
		$paid = feeIsPaid($user->uid, $ladderId);

		$exists = db_query('SELECT 1 FROM {tennis_challenge_ladder_player} WHERE playerId = :playerId AND lid = :lid AND can_challenge = :can_challenge' , array(':playerId' => $user->uid, ':lid' => $ladderId, ':can_challenge' => 0))->fetchField();
		
		if(getChallengedPlayerId($ladderId) != 0){
			$challengedId = getChallengedPlayerId($ladderId);
		}
		
		$output = "<table class='playerList'><thead><th>Ranking</th><th>Player Name</th><th>Won</th><th>Lost</th><th># Matches</th>";

		if($isSignedUp && ($paid || isFree($ladderId)) && in_array('player', $user->roles) && ($currentDate <= $endDate)){
			$output .= "<th>Challenge</th>";
		}
		if(in_array('coach', $user->roles) && $coachId == $user->uid){
			$output .= "<th>Freeze Player</th>";
			$output .= "<th>Remove Player</th>";
		}

		
		$output .= '</thead>';
		//$i = 0;
		//$j = 0;

	if(in_array('player', $user->roles)){
	
		$totalPlayers =  count($results);
		$limit = ceil($totalPlayers * (20/100));
		$playerRank = getRank($user->uid, $ladderId);
		$maxRankToChallenge = $playerRank - $limit;
		
		
		
		foreach($results as $result){ 

			$playerName = getNameById($result['playerId'], 'player_profile');

			$rank = $result['ranking'];
			
			$output .= "<tr>";//<td>".$j."</td>";
			$output .= "<td>".$rank."</td>";
			$output .= "<td><a href='".$base_url.'/user/'.$result['playerId']."'>".$playerName."</a></td>";
			$output .= "<td>".$result['won']."</td>";
			$output .= "<td>".$result['lost']."</td>";
			$output .= "<td>".$result['no_of_matches']."</td>";
			
			//TODO: which players is in a challenge with who.
			
			if($isSignedUp && (isFree($ladderId) || $paid) && ($currentDate <= $endDate)){
				if($user->uid == $result['playerId']){
					$output .= "<td>This is you</td>";
				}else if($result['playerId'] == $challengedId){
					$output .= "<td title='This player has not responded to your challenge request yet.'>Challenged By You: Awaiting Response</td>";
				}else if($rank > 0 && $rank < $maxRankToChallenge){
					$output .= "<td>Out Of Range</td>";
				}else if(isFrozen($result['playerId'], $ladderId) != 0){
					$output .= "<td title='The position of this player is frozen.'>Frozen</td>";
				}else if(isChallenger($ladderId, $result['playerId'])){
					$output .= "<td title='This player has sent a request to another player. But the challenged player has not responded yet'>Awaiting approval from another player.</td>";
				}else if($exists){ // if the loggedIn Player is already a part of a challenge.
					$output .= "<td title='cannot challenge because you have already challenged a player in this ladder'>Cannot Challenge</td>";
				}else{
					$output .= "<td><a href='".$base_url."/challenge-player?ladder=".$result['lid']."&challenged=".$result['playerId']."'><img title='Challenge' src = '".base_path().path_to_theme()."/images/ball_tennis_clock.png'/></a></td>";
				}
			}
		}
	
	}else if(in_array('coach', $user->roles)){
	
		foreach($results as $result){ 

			$playerName = getNameById($result['playerId'], 'player_profile');
			$rank = $result['ranking'];
			
			$output .= "<tr>";//<td>".$j."</td>";
			$output .= "<td>".$rank."</td>";
			$output .= "<td><a href='".$base_url.'/user/'.$result['playerId']."'>".$playerName."</a></td>";
			$output .= "<td>".$result['won']."</td>";
			$output .= "<td>".$result['lost']."</td>";
			$output .= "<td>".$result['no_of_matches']."</td>";
			
			if($user->uid == $coachId){
				if(isFrozen($result['playerId'], $ladderId) == 0){
					$output .= "<td><a href='".$base_url."/freeze-player/".$result['playerId']."/".$ladderId."'>Freeze</a></td>";
				}else{
					$output .= "<td><a href='".$base_url."/de-freeze-player/".$result['playerId']."/".$ladderId."'>De-Freeze</a></td>";
				}
				$output .= "<td><a href='".$base_url."/remove/".$result['playerId']."/".$ladderId."'>Remove</a></td>";;
			}
		}
	
	}else{
		foreach($results as $result){ 

			$playerName = getNameById($result['playerId'], 'player_profile');

			$rank = $result['ranking'];
			
			$output .= "<tr>";//<td>".$j."</td>";
			$output .= "<td>".$rank."</td>";
			$output .= "<td><a href='".$base_url.'/user/'.$result['playerId']."'>".$playerName."</a></td>";
			$output .= "<td>".$result['won']."</td>";
			$output .= "<td>".$result['lost']."</td>";
			$output .= "<td>".$result['no_of_matches']."</td>";
	
		}
	}
		
		$output .= "</tr></table>";
									
		return $output;
	}
	
	function getPlayerListByCoach($uid){
	
			global $base_url;
			
			$exists = db_query('SELECT 1 FROM {coach_player_relation} WHERE coach_id = :coachId', array(':coachId' => $uid))->fetchField();
			if($exists){
			
				$query = db_select('coach_player_relation', 'cpr');
				$query->condition('cpr.coach_id', "$uid")
					->fields('cpr', array('player_id'));
				$results = $query->execute()->fetchall(PDO::FETCH_ASSOC);
					
				foreach($results as $result){
					$playerIds[] = $result['player_id'];
				}
	
				foreach($playerIds as $playerId){
					$player = user_load($playerId);
					$profile = profile2_load_by_user($player, 'player_profile');
					
					$standard 	= $profile->field_standard['und'][0]['value'];
					$playerName = '<a href="'.$base_url.'/user/'.$playerId.'">'.$profile->field_first_name['und'][0]['value']. " " . $profile->field_last_name['und'][0]['value'].'</a>';
					$gender = "Female";
					if($profile->field_player_gender['und'][0]['value'] == 0){
						$gender = "Male";
					};
					$status = "Active";
					if($player->status == 0){
						$status = "InActive";
					}
					$matches = "";
						
					$users[$player->uid] = array(
						'username' => $playerName,
						'standard' => $standard,
						'gender'   => $gender,
						'status'   => $status,
						'matches'  => $matches,
					);
				}

					return $users;
			}
	}
	
	function getLadderListByCoach($uid){
	
		$sql = db_select('node', 'n');
		$sql->condition('n.uid', $uid, '=')
			->condition('n.type', "ladder", '=')
			->condition('n.status', '1', '=')
			->fields('n', array('nid', 'title'));
		$results = $sql->execute()->fetchAll(PDO::FETCH_ASSOC);
			
		foreach($results as $result){
			$ladders[$result['nid']] = $result['title'];
		}
			
		return $ladders;
	}
	
	function csvUploadPlayers_form($form, &$form_state){
		$form['name'] = array(
				'#type' => 'file',
				//'#required' => true,
				'#title' => t('Upload players using CSV'),
		);
		
		$form['submit'] = array(
				'#type' => 'submit',
				'#value' => t('Create Players'),
		);
		
			$createdPlayersCount = 0;
			$existingPlayersCount = 0;
			$createdPlayers = "";
			$existingPlayers = "";

			if(isset($_SESSION['createdPlayers'])){
		
				
				$createdPlayers .= "<ul>";
				foreach($_SESSION['createdPlayers'] as $player){
					$createdPlayers .= '<li>'.$player.'</li>'; 
					$createdPlayersCount ++;
				}
					$createdPlayers .= "</ul>";
					unset($_SESSION['createdPlayers']);
			}
		
			if(isset($_SESSION['existingPlayers'])){
		
				
				$existingPlayers .= "<ul>";
				foreach($_SESSION['existingPlayers'] as $player){
					$existingPlayers .= '<li>'.$player.'</li>'; 
					$existingPlayersCount ++;
				}
					$existingPlayers .= "</ul>";
					unset($_SESSION['existingPlayers']);
			}

		
		$form['uploadStatus']= array(
			'#markup' => '<br /><table><th>Created Players ('.$createdPlayersCount.')</th><th>Existing Players ('.$existingPlayersCount.')</th><tr><td>'.$createdPlayers.'</td><td>'.$existingPlayers.'</td></tr></table>',
		);


		return $form;
	}
	
	function csvUploadPlayers_form_submit($form, &$form_state){
		global $user;
		
		$form_state['redirect'] = array(
		    'coach-panel',array(
		      			'query' => array(
		        			'qt-ladder_challenge' => 3,
		      			),
		    		),
	  	);

		$file = $_FILES['files']['tmp_name']['name'];
		$handle = fopen($file,"r");

		$count = 0;
		
		while($data = fgetcsv($handle,1000,",","'")){
			if($count == 0){ // skip the headers of the csv
				$count ++;
				continue;
			}
			if($data[2] == 'johncitizen@hotmail.com' || $data[2] == 'marydow@gmail.com'){
				continue;
			}
			$value = array();
			$value['firstName'] = $data[0];
			$value['lastName'] = $data[1];
			$value['email'] = $data[2];
			$value['mobileNo'] = $data[3];
			$value['standard'] = $data[4];
			if($data[5] == 'M'){
				$value['gender'] = 0;
			}else if($date[5] == 'F'){
				$value['gender'] = 1;
			}
			
			tennis_challenge_create_player($value);
			
		}
		
		drupal_set_message('Player Upload Complete');
		drupal_redirect_form($form_state);
		//drupal_goto($base_url. '/coach-panel?qt-ladder_challenge=3');
	}
	
	function playerAdd_form($form, &$form_state){
		
		$form['first_name'] = array(
			'#title' => 'First Name',
			'#type' => 'textfield',
			'#required' => TRUE,
			'#maxlength' => 30,
			'#size' =>30,
		);
		
		$form['last_name'] = array(
			'#title' => 'Last Name',
			'#type' => 'textfield',
			'#required' => TRUE,
			'#maxlength' => 30,
			'#size' =>30,
		);
		
		$form['email'] = array(
			'#title' => 'Email Address',
			'#type' => 'textfield',
			'#required' => TRUE,
			'#maxlength' => 30,
			'#size' =>30,
		);
		
		$form['phone_no'] = array(
			'#title' => 'Mobile Phone Number',
			'#type' => 'textfield',
			'#maxlength' => 11,
			'#required' => TRUE,
			'#size' =>30,
		);
		
	
		$form['standard'] = array(
			'#type' => 'select',
			'#title' => 'Standard',
			'#options' => array(
				'CTR 1' => 'CTR 1',
				'CTR 2' => 'CTR 2',
				'CTR 3' => 'CTR 3',
				'CTR 4' => 'CTR 4',
				'CTR 5' => 'CTR 5',
				'CTR 6' => 'CTR 6',
				'CTR 7' => 'CTR 7',
				'CTR 8' => 'CTR 8',
				'CTR 9' => 'CTR 9',
				'CTR 10' => 'CTR 10',
			),
			'#required' => TRUE,
		);
		
		$form['gender'] = array(
			'#type' => 'select',
			'#title' => 'Gender',
			'#options' => array(
				'0' => 'Male',
				'1' => 'Female',
			),
			'#required' => TRUE,
		);
		
		$form['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Create Player',
		);
		
		return $form;
	}
	
	function playerAdd_form_submit($form, &$form_state){
	
		$value = array();
		$value['firstName'] = $form_state['values']['first_name'];
		$value['lastName'] = $form_state['values']['last_name'];
		$value['email'] = $form_state['values']['email'];
		$value['mobileNo'] = $form_state['values']['phone_no'];
		$value['standard'] = $form_state['values']['standard'];
		$value['gender'] = $form_state['values']['gender'];
			
		tennis_challenge_create_player($value);
		drupal_set_message("A new player has been created");
	}
	
	
	function tennis_challenge_create_player($values){ // function to create players.
	
		global $user;
		global $base_url;
	
		if(!user_load_by_mail($values['email'])){ // if the user is not already in the system then create it. 
				$password = user_password(8);
				$fields = array(
					'name' => $values['email'],
					'mail' => $values['email'],
					'pass' => $password,
					'status' => 1,
					'init' => $values['email'],
					'roles' => array(
					  DRUPAL_AUTHENTICATED_RID => 'authenticated uers',
					  '5' => 'player',
					),
				);
				 
				  //the first parameter is left blank so a new user is created
				user_save('', $fields);

				$player = user_load_by_mail($values['email']);
				$profile = profile_create(array('user' => $player, 'type' => 'player_profile')); // adding data to profile2 fields for the player
				$profile->field_first_name[LANGUAGE_NONE][0]["value"] = $values['firstName'];
				$profile->field_last_name[LANGUAGE_NONE][0]["value"] = $values['lastName'];
				$profile->field_mobile_phone_number[LANGUAGE_NONE][0]["value"] = $values['mobileNo'];
				$profile->field_standard[LANGUAGE_NONE][0]["value"] = $values['standard'];
				$profile->field_player_gender['und'][0]['value'] = $values['gender'];
				profile2_save($profile) ;
				
				$profile = profile_create(array('user' => $player, 'type' => 'coach_profile'));
				$profile->field_first_name[LANGUAGE_NONE][0]["value"] = $values['firstName'];
				$profile->field_last_name[LANGUAGE_NONE][0]["value"] = $values['lastName'];
				$profile->field_mobile_phone_number[LANGUAGE_NONE][0]["value"] = $values['mobileNo'];
				profile2_save($profile) ;
				

				$params['account'] = $player;
   				$language = $language ? $language : user_preferred_language($player);
    			$mail = drupal_mail('user', $op, $player->mail, $language, $params);
				drupal_mail('user', 'register_no_approval_required', $player->mail, $language ,$params);
				
				// inserting coach and player ids to the custom table to know which coach created which users.
				
				db_insert('coach_player_relation')
					->fields(array(
						'coach_id' => $user->uid,
						'player_id' => $player->uid,
				))
				->execute();

				$_SESSION['createdPlayers'][] = $values['firstName']." ".$values['lastName'];
				
			}else{

				$_SESSION['existingPlayers'][] = $values['firstName']." ".$values['lastName'];
				
				$player = user_load_by_mail($values['email']);
				
				db_insert('coach_player_relation')
					->fields(array(
						'coach_id' => $user->uid,
						'player_id' => $player->uid,
				))
				->execute();	
			}

	}
	
	function playerChallengeForm_form($form, &$form_state){
		
		global $user;
		
		$playerId = $_GET['challenged'];
		$ladderId = $_GET['ladder'];
		
		if(!feeIsPaid($playerId, $ladderId)){
			$subject = "Pay the Fee";
			$message = getNameById($user->uid, 'player_profile')." wants to challenge you in the ladder ".getLadderTitleById($ladderId)."Please pay the fee so other players could challenge you in the ladder.";
			privatemsg_new_thread(array(user_load($playerId)), $subject, $message);
			
			drupal_set_message("You cannot challenge this player yet because he/she has not paid ladder fee. A message has been sent to the player as a reminder of fee payment.");
			drupal_goto(drupal_lookup_path('alias', 'node/'.$ladderId));
		}
		
		
		$form['date1'] = array(
			'#type' => 'date_popup',
			'#title' => 'First Date',
			'#required' => true,
		);

		$form['date2'] = array(
			'#type' => 'date_popup',
			'#title' => 'Second Date',
			'#required' => true,
		);

		$form['date3'] = array(
			'#type' => 'date_popup',
			'#title' => 'Third Date',
			'#required' => true,
		);

		$form['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Submit',
		);

		return $form;
	}

	function playerChallengeForm_form_validate($form, &$form_state){
		$node = node_load($_GET['ladder']);
		$startDate = $node->field_ladder_stard_date['und'][0]['value'];
		$endDate = $node->field_ladder_end_date['und'][0]['value'];
		$format = "jS M Y H:ia";
		$error = "The date must be between ".format_date(strtotime($startDate), 'custom', $format)." and ".format_date(strtotime($endDate), 'custom', $format);

		
		if($form_state['values']['date1'] < $startDate || $form_state['values']['date1'] > $endDate){
			form_set_error(date1, $error." in First Date");
		}
		if($form_state['values']['date2'] < $startDate || $form_state['values']['date2'] > $endDate){
			form_set_error(date2, $error." in Second Date");
		}
		if($form_state['values']['date3'] < $startDate || $form_state['values']['date3'] > $endDate){
			form_set_error(date3, $error." in Third Date");
		}
	}
	
	function playerChallengeForm_form_submit($form, &$form_state){

		global $user;
		global $base_url;


		db_insert('challenge_player')
		  ->fields(array(
		    'date1' => $form_state['values']['date1'],
		    'date2' => $form_state['values']['date2'],
		    'date3' => $form_state['values']['date3'],
			'lid'	=> $_GET['ladder'],
			'challenger_id' => $user->uid,
			'challenged_id' => $_GET['challenged'],
		  ))
		  ->execute();

		db_update('tennis_challenge_ladder_player')
		  ->fields(array(
		    'can_challenge' => 0,
		  ))
		  ->condition('playerId', $user->uid, '=')
		  ->condition('lid', $_GET['ladder'], '=')
		  ->execute();

		$link = $base_url.'/node/'. $_GET['ladder'];
		drupal_set_message('The challenge request has been sent to the player. Wait for him to accept your challenge');
		$subject = "New Challege";
		$message = "You have received a new challenge. <a href='".$base_url."/challenge-requests"."'>Click here</a> to view your pending challenge requests";
		privatemsg_new_thread(array(user_load($_GET['challenged'])), $subject, $message);
		drupal_goto($link);
	}


	function playerChallengeAccept_form($form, &$form_state){

		global $user;
		
			$query = db_select('challenge_player', 'cp');
			$query->condition('cp.id', $_GET['challenge_id'])
			//$query->fields('cp', array('date1', 'date2', 'date3', 'lid', 'challenger_id', 'challenged_id'));
			->fields('cp');
			$result = $query->execute()->fetchall(PDO::FETCH_ASSOC);
			
			$format = "j M Y - g:i:sa";
			$date1 = $result[0]['date1'];
			$date2 = $result[0]['date2'];
			$date3 = $result[0]['date3'];
			$date4 = format_date(strtotime($result[0]['date1']), 'custom', $format);
			$date5 = format_date(strtotime($result[0]['date2']), 'custom', $format);
			$date6 = format_date(strtotime($result[0]['date3']), 'custom', $format);
			
			$options = array(
				$date1 => $date4,
				$date2 => $date5, 
				$date3 => $date6,
			);
	
	
			$form['requested_dates'] = array(
				'#type' => 'radios',
				'#title' => 'Choose a date',
				'#options' => $options,
			);
	
			$form['accept_decline'] = array(
				'#type' => 'select',
				'#title' => 'Choose to accept or decline',
				'#options' => array('accept' => "Accept", 'decline' => "Decline"),
			);
		
			$form['submit'] = array(
				'#type' => "submit",
				'#value' => "Submit",
			);

		return $form;
	}

	function playerChallengeAccept_form_submit($form, &$form_state){
	
		global $base_url;

		$selectedDate = $form_state['values']['requested_dates'];
		$query = db_select('challenge_player', 'cp');
			$query->condition('cp.id', $_GET['challenge_id'])
			->fields('cp');
		
		$result = $query->execute()->fetchall(PDO::FETCH_ASSOC);
			
		$challengerId = $result[0]['challenger_id'];
		$challengedId = $result[0]['challenged_id'];
		$challengerName = getNameById($result[0]['challenger_id'], 'player_profile');
		$challengedName = getNameById($result[0]['challenged_id'], 'player_profile');
		$ladderId = $result[0]['lid'];

		if($form_state['values'][accept_decline] == "accept"){ // challenge creation code

			createChallengeRequest($selectedDate, $ladderId, $challengerId, $challengedId);
			
			$subject = "Challenge Accepted";
			$message = $challengedName." has accepted your challenge. Visit your panel to view all challenges.";
			privatemsg_new_thread(array(user_load($challengerId)), $subject, $message);
	
			
		}else{
			
			$subject = "Challenge Declined";
			$message = $challengedName." has declined your challege";
			privatemsg_new_thread(array(user_load($challengerId)), $subject, $message);
	
			
			db_update(' tennis_challenge_ladder_player')
			  ->fields(array(
			    'can_challenge' => 1,
			  ))
			  ->condition('playerId', $result[0]['challenger_id'], '=')
			  ->condition('lid', $ladderId, '=')
			  ->execute();
		
		}
		
		db_delete('challenge_player')
	 			->condition('id', $_GET['challenge_id'])
	  			->execute();

		$link = $base_url.'/node/'.$ladderId;
		drupal_goto($link);
	}	

	function getNameById($uid, $profile_type){
		
		$user = user_load($uid);
		$name = "";
		$user = profile2_load_by_user($user, $profile_type);	
		$name .= $user->field_first_name[LANGUAGE_NONE][0]["value"];
		$name .= " ". $user->field_last_name[LANGUAGE_NONE][0]["value"];
			
		return $name;
	}

	function getLadderTitleById($nid){
		
		$node = node_load($nid);
		return $node->title;
	}

	function isSignedUpInLadder($uid, $ladderId){
		//function to check if the user is in the ladder players list

		$exists = db_query('SELECT 1 FROM {tennis_challenge_ladder_player} WHERE playerId = :playerId AND lid = :lid', array(':playerId' => $uid, ':lid' => $ladderId))->fetchField();
		
		if($exists){
			return true;
		}else{
			return false;
		}

	}


	function reAlignLadderPlayers_form($form, &$form_state){

		$ladderId = $_GET['lid'];
		global $user;

		if($user->uid == node_load($ladderId)->uid){
		
				$query = db_select('tennis_challenge_ladder_player', 't');
				$query->condition('t.lid', $ladderId, '=');
				$query->fields('t', array('sno', 'ranking', 'playerId', 'lid', 'weight'));
				$query->orderBy('weight', 'ASC');
				$results = $query->execute()->fetchall(PDO::FETCH_ASSOC);

				 $form['player'] = array(
					'#prefix' => '<div id="red-dwarf">',
					'#suffix' => '</div>',
					'#tree' => TRUE,
					'#theme' => 'tennis_challenge_theme_realign'
				 );
		
				$i = 1 ;
				foreach($results as $key => $player){
				
					$playerName = getNameById($player['playerId'], 'player_profile');
					$ranking = $player['ranking'];
					$weight = $player['weight'];
		
					$form['player'][$key]['name'] = array(
					  '#type' => 'markup',
					  '#markup' => $playerName,
					);
					
					$form['player'][$key]['id'] = array(
					  '#type' => 'hidden',
					  '#default_value' => $player['sno'],
					);

					$form['player'][$key]['weight'] = array(
					  '#type' => 'textfield',
					  '#default_value' => $weight,
					  '#size' => 3,
						'#attributes' => array('class' => array('rank-weight')),
					);

				}
		
				$form['submit'] = array(
					'#type' => 'submit',
					'#value' => 'submit',
				);
		}else{
	
			$form['no_access'] =  array(
				'#markup' => '<b>You Donot have access to this Player List</b>',
			);
			
		}

		return $form;
	
	}

	function reAlignLadderPlayers_form_submit($form, $form_state){

		$values = $form_state['values'];
		$form_state['redirect'] = array(
		    'realign-players',array(
		      			'query' => array(
		        			'lid' => $_GET['lid'],
		      			),
		    		),
	  	);
	
		uasort($form_state['values']['player'], 'drupal_sort_weight');
		$values = $form_state['values']['player'];
		$i = 0;
		foreach($values as $value){
			$i++;
			$id = $value['id'];

			db_update('tennis_challenge_ladder_player')
				->fields(array(
				   'weight' => $value['weight'],
				   'ranking' => $i,
				))
  				->condition('sno', $id, '=')
				->execute();

		}

		drupal_set_message("Player List Re-Aligned");
		drupal_redirect_form($form_state);

	}

	
	function proposeNewDate_form($form, &$form_state){

		$form['new_date'] = array(
			'#type' => 'date_popup',
			'#description' => 'This date will be sent to the challenger',
			'#required' => true,
		);

		$form['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Send Date',
		);

		return $form;

	}

	function proposeNewDate_form_submit($form, $form_state){

		db_update('challenge_player')
		  ->fields(array(
		    'date4' => $form_state['values']['new_date'],
		  ))
		  ->condition('id', $_GET['challenge_id'], '=')
		  ->execute();
		  
		$query = db_select('challenge_player', 'c');
		$query->condition('c.id', $_GET['challenge_id'], '=');
		$query->fields('c', array('challenger_id', 'challenged_id'));

		$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
		// print_r(); exit;
		// $node = node_load($_GET['challenge_id']);
		// echo '<pre>';
		// print_r($node); exit;
		$challenger_id = $results[0]['challenger_id'];
		$challenged_id = $results[0]['challenged_id'];
		
		$challenged_name = getNameById($challenged_id, 'player_profile');
		$challenger_name = getNameById($challenger_id, 'player_profile');
		  
		drupal_set_message("You have proposed a new date to ".$challenger_name." Please wait for him to accept or decline.");
		$subject = "New Re-Proposed Date";
		$message = $challenged_name ." has proposed a new date for a challenge. Please click on <b>Re-Proposed Dates</b> in your player panel to view all re-proposed dates.";
		privatemsg_new_thread(array(user_load($challenger_id)), $subject, $message);
	}
	

	function getNewlyProposedDates(){

		global $user;

		$query = db_select('challenge_player', 'c');
		$query->condition('c.challenger_id', $user->uid, '=');
		$query->condition('c.date4', '', '!=');
		$query->fields('c', array('id', 'lid', 'challenged_id', 'date4'));

		$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}

	function getNewlyProposedDates_render($results){

		global $base_url;
		
		if(empty($results)){
			$output = "No Reproposed Dates";
		}else{

			$output = "<ul>";

			foreach($results as $result){

				$timestamp = strtotime($result['date4']);
				$date = format_date($timestamp, 'custom', 'l, Y-m-d').' at '.format_date($timestamp, 'custom', 'g:i a');
				$acceptLink = '<a href = "'.$base_url.'/accept-deny-reproposed-date/accept/'.$result['id'].'">Accept</a>';
				$denyLink 	= '<a href = "'.$base_url.'/accept-deny-reproposed-date/deny/'.$result['id'].'">Deny</a>';
				$output .= "<li><img src='".base_path().path_to_theme()."/images/ball_tennis_refresh.png' />'<u>".getNameById($result['challenged_id'], "player_profile")."</u> proposed a new challenge date for your challenge in ladder <u><a href='".$base_url."/node/".$result['lid']."'>".getLadderTitleById($result['lid'])."</a></u> <b>".$date."</b>";
				$output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$acceptLink.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$denyLink.'</li>';
			}

			$output .= "</ul>";
		}
		
		return $output;

	}

	function createChallengeRequest($date, $ladderId, $challengerId, $challengedId){

		$challengerName = getNameById($challengerId, 'player_profile');
		$challengedName = getNameById($challengedId, 'player_profile');
		$date = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s", strtotime($date))));
		$verifyingDate = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +3 day"));
		$resultEnteringDate = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +1 day"));
		//$date="2013-02-22 13:08:00";
//echo $date.'<br/>'.$verifyingDate.'</br>'.$resultEnteringDate; exit;
		$node = new stdClass(); 
		$node->type = "challenge_request"; 
		node_object_prepare($node);
		$node->title    = $challengerName." Vs ".$challengedName ;
		$node->language = LANGUAGE_NONE;
		
		$node->field_challenge_date['und'][0]['value'] = $date;	
		$node->field_result_verifying_date['und'][0]['value'] = $verifyingDate;		
		$node->field_result_entering_date['und'][0]['value'] = $resultEnteringDate;
		
		$node->field_associated_ladder['und'][0]['nid'] = $ladderId;
		$node->field_challenge_challenger['und'][0]['value'] = $challengerId;
		$node->field_challenge_challenged['und'][0]['value'] = $challengedId;
			
		if($node = node_submit($node)) { 
	    	node_save($node);
		}
		
		$ladder = node_load($ladderId);
		
		if(!isPaidFor($challengerId, $ladderId)){
		
			if(getRank($challengerId, $ladderId) == 0){
				db_update('tennis_challenge_ladder_player')
				->fields(array(
				   'paid' => 0,
				 ))
				->condition('playerId', $challengerId, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			}
		}	
		
		if(!isPaidFor($challengerId, $ladderId)){
			if(getRank($challengedId, $ladderId) == 0){
					db_update('tennis_challenge_ladder_player')
					->fields(array(
					   'paid' => 0,
					 ))
					->condition('playerId', $challengedId, '=')
					->condition('lid', $ladderId, '=')
					->execute();
				}
		}
		
		db_update('tennis_challenge_ladder_player')
			->fields(array(
			   'can_challenge' => 0,
			 ))
			->condition('playerId', $challengedId, '=')
			->condition('lid', $ladderId, '=')
			->execute();

	}

	function reproposedDate_callback($status, $challengeId){
		
		global $user;
		global $base_url;

		$exists = db_query('SELECT 1 FROM {challenge_player} WHERE id = :challengeId AND challenger_id = :challengerId', array(':challengeId' => $challengeId, ':challengerId' => $user->uid))->fetchField();
		
		if($exists){
			
			if($status == 'accept'){
				$query = db_select('challenge_player', 'c');
				$query->condition('c.id', $challengeId, '=')
					->fields('c', array('date4', 'lid', 'challenger_id', 'challenged_id'));
	
				$result = $query->execute()->fetchAssoc();
				$date = $result['date4'];
				$ladderId = $result['lid'];
				$challengerId = $result['challenger_id'];
				$challengedId = $result['challenged_id'];
	
				createChallengeRequest($date, $ladderId, $challengerId, $challengedId);
				drupal_set_message("You are a part of a new challenge.");

			}else{
				
				drupal_set_message("Challenge Denied.");
				
			}

			db_delete('challenge_player')
			 		->condition('id', $challengeId)
			  		->execute();
				
			$link = $base_url.'/node/'.$ladderId;
			drupal_goto($link);

		}else{
			echo "Access Denied";
		}
		
		
	}


	function enterResult_form($form, &$form_state){

		$options = array();
		
		$node = node_load(arg(1));
		$user1 = $node->field_challenge_challenger['und'][0]['value'];
		$user2 = $node->field_challenge_challenged['und'][0]['value'];
		$userName1 = getNameById($user1, 'player_profile');
		$userName2 = getNameById($user2, 'player_profile');
		
		$optionLabel[0] = $userName1." Won the Match by Defeating ".$userName2;
		$optionLabel[1] = $userName2." Won the Match by Defeating ".$userName1; 

		$options = array($optionLabel[0].'-'.$user1 => $optionLabel[0], $optionLabel[1].'-'.$user2 => $optionLabel[1]);

		$form['result_fieldset'] = array(
			'#type' => 'fieldset',
			'#title' => 'Enter Match Result',
		);

		$form['result_fieldset']['result'] = array(
			'#type' => 'select',
			'#title' => 'Result',
			'#options' => $options,
		);

		$form['result_fieldset']['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Submit Results',
		);

		return $form;

	}

	function enterResult_form_submit($form, &$form_state){

		global $user;
		global $base_url;
		
		$node = node_load(arg(1));

		$user1 = $node->field_challenge_challenger['und'][0]['value'];
		$user2 = $node->field_challenge_challenged['und'][0]['value'];
		
		$nid = $node->field_associated_ladder['und'][0]['nid'];
		$ladder =  node_load($nid);
		$user3 = $ladder->uid;
		
		$winnerId = explode('-', $form_state['values']['result']);
		
		
		if($user->uid == $winnerId[1]){

			$node->field_challenge_result['und'][0]['value'] = $winnerId[0];
			$node->field_challenge_winner_id['und'][0]['value'] = $winnerId[1];
			$node->field_challenge_verified['und'][0]['value'] = "Not Verified";
			node_save($node);
	
			if($winnerId[1] == $user1){
				$mailUser1 = $user2;
				$mailUser2 = $user3;
			}else if($winnerId[1] == $user2){
				$mailUser1 = $user1;
				$mailUser2 = $user3;
			}

			$enteringUser = getNameById($user->uid, 'player_profile');
	
			$subject = "Match Result Entered - Pending Verification";
			$message = $enteringUser ." has entered the match result. Please review the result.<a href='".$base_url."/".drupal_lookup_path('alias', 'node/'.$node->nid)."'><u>Click here to visit the challenge page</u></a>";
			privatemsg_new_thread(array(user_load($mailUser1)), $subject, $message);
		
			$subject = "Match Result Entered";
			$message = $enteringUser." has entered the result for a challenge in your Ladder ".getLadderTitleById($nid);
			privatemsg_new_thread(array(user_load($mailUser2)), $subject, $message);	

			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'can_challenge' => 1,
			  ))
			  ->condition('playerId',array($winnerId[1], $mailUser1) , 'IN')
			  ->condition('lid', $nid, '=')
			  ->execute();
			drupal_set_message("The result has been entered. Please wait for the other player to confirm and verify.");
		}else if($user->uid == $user3){
		
			$node->field_challenge_result['und'][0]['value'] = $winnerId[0];
			$node->field_challenge_winner_id['und'][0]['value'] = $winnerId[1];
			$node->field_challenge_verified['und'][0]['value'] = "Not Verified";
			node_save($node);
			
			$mailUser1 = $user1;
			$mailUser2 = $user2;
			$enteringUser = getNameById($user->uid, 'coach_profile');
			$winner = $winnerId[1];
		
			if($winner == $user1){
				$loser = $user2;
			}else if($winner == $user2){
				$loser = $user1;
			}
			
			$subject = "Match Result Entered - Pending Verification";
			$message = $enteringUser ." has entered the match result. Please review the result <a href='../../".drupal_lookup_path('alias', 'node/'.$node->nid)."'><u>Click here to visit the challenge page</u></a>";
			privatemsg_new_thread(array(user_load($loser)), $subject, $message);
		
			$subject = "Match Result Entered";
			$message = $enteringUser."  has entered the match result, stating you as a Winner!!! <a href='../../".drupal_lookup_path('alias', 'node/'.$node->nid)."'><u>Click here to visit the challenge page</u></a>";
			privatemsg_new_thread(array(user_load($winner)), $subject, $message);	
			

			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'can_challenge' => 1,
			  ))
			  ->condition('playerId',array($winner, $loser) , 'IN')
			  ->condition('lid', $nid, '=')
			  ->execute();

		}else{

			drupal_set_message('Only Winner Can Enter The Result', 'error');
		}
	}

	function verifyResult($challengeNid){

		global $base_url;
		global $user;

		$node = node_load($challengeNid);

		$nid = $node->field_associated_ladder['und'][0]['nid'];

		$user1 = $node->field_challenge_challenger['und'][0]['value'];
		$user2 = $node->field_challenge_challenged['und'][0]['value'];
		$winner = $node->field_challenge_winner_id['und'][0]['value'];
	
		if($winner == $user1){
			$loser = $user2;
		}else if($winner == $user2){
			$loser = $user1;
		}
		
		$winnerRank = getRank($winner, $nid);
		$loserRank = getRank($loser, $nid);
		
		verifyResultDbUpdate($winner, $loser, $nid);
		
		if($winnerRank == 0 && $loserRank == 0){ // if the rank of both players is 0
			
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => getMaxRank($nid)+1,
			  ))
			  ->condition('playerId',$winner , '=')
			  ->condition('lid', $nid, '=')
			  ->execute();
			  
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => getMaxRank($nid)+1,
			  ))
			  ->condition('playerId',$loser, '=')
			  ->condition('lid', $nid, '=')
			  ->execute();

		}
		
		if($winnerRank == 0 && $loserRank > 0){ // if winner is 0 and loser is on higher rank
			
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => $loserRank,
			  ))
			  ->condition('playerId',$winner , '=')
			  ->condition('lid', $nid, '=')
			  ->execute();
			  
			$query = db_select('tennis_challenge_ladder_player', 't'); //select all players with the rank higher in number than the loser
			$query->condition('t.ranking', $loserRank, '>')
				->condition('t.lid', $nid, '=')
				->fields('t', array('sno', 'playerId', 'ranking', 'frozen'));
				
			$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($results as $result){
				db_update('tennis_challenge_ladder_player')
				  ->fields(array(
					'ranking' => $result['ranking'] + 1,
				  ))
				  ->condition('sno', $result['sno'] , '=')
				  ->execute();
			}

			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => $loserRank+1,
			  ))
			  ->condition('playerId',$loser, '=')
			  ->condition('lid', $nid, '=')
			  ->execute();

		}else if($winnerRank > 0 && $loserRank == 0){
		
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => getMaxRank($nid) + 1,
			  ))
			  ->condition('playerId',$loser, '=')
			  ->condition('lid', $nid, '=')
			  ->execute();
		}

		if(($winnerRank > 0) && ($loserRank > 0) && ($winnerRank > $loserRank)){
		
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => $loserRank,
			  ))
			  ->condition('playerId',$winner , '=')
			  ->condition('lid', $nid, '=')
			  ->execute();
			  
			$query = db_select('tennis_challenge_ladder_player', 't'); //select all players with the rank higher in number than the loser and lesser in number than the winner
			$query->condition('t.ranking', $loserRank, '>')
				->condition('t.ranking', $winnerRank, '<')
				->condition('t.lid', $nid, '=')
				->fields('t', array('sno', 'playerId', 'ranking'));
				
			$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($results as $result){
				db_update('tennis_challenge_ladder_player')
				  ->fields(array(
					'ranking' => $result['ranking'] + 1,
				  ))
				  ->condition('sno', $result['sno'] , '=')
				  ->execute();
			}

			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
			    'ranking' => $loserRank+1,
			  ))
			  ->condition('playerId',$loser, '=')
			  ->condition('lid', $nid, '=')
			  ->execute();
					
		}else if(($winnerRank > 0) && ($loserRank > 0) && ($loserRank > $winnerRank)){
			// no change
		}
		
		$node->field_challenge_verified['und'][0]['value'] = "Verified";
		node_save($node);	
		
		notifyAllPlayers($winner, $loser, $winnerRank, $loserRank, $nid, $challengeNid);
		
		drupal_goto($base_url.'/node/'.$challengeNid);

	}

	function notifyAllPlayers($winner, $loser, $winnerOldRank, $loserOldRank, $ladderId, $challengeNid){
	
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.notify', '1', '=')
		//->condition('t.ranking', $winner, '>')
		->condition('t.lid', $ladderId, '=')
		->fields('t',  array('playerId'));
		
		$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
		
		$winnerNewRank = getRank($winner, $ladderId);
		$loserNewRank = getRank($loser, $ladderId);
		$winnerName = getNameById($winner, 'player_profile');
		$loserName = getNameById($loser, 'player_profile');
		$node = node_load($challengeNid);
		$result = $node->field_challenge_result['und'][0]['value'];
		
		$subject = "New Result has been entered in ladder " . getLadderTitleById($ladderId);
		$message = "<b>Name of the Players:</b> ".$winnerName.", ".$loserName."\n
					<b>Match Result:</b> ".$result."\n
					<b>Old Position of ".$winnerName.":</b> ".$winnerOldRank."\n 
					<b>New Position of ".$winnerName.":</b> ".$winnerNewRank."\n
					<b>Old Position of ".$loserName.":</b> ".$loserOldRank."\n
					<b>New Position of ".$loserName.":</b> ".$loserNewRank."\n";
		
		foreach($results as $result){
			privatemsg_new_thread(array(user_load($result['playerId'])), $subject, $message);
		}
		
	}

	function getLaddersToJoin($playerId){

		$query = db_select('node', 'n');
		$query->condition('n.type', 'ladder', '=')
			->fields('n', array('nid'));
		$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);

		$output = "<table id='join-ladder'><thead><th>Ladder Name</th><th>Join</th></thead><tr>";
		
		foreach($results as $result){

			$ladder = getLadderTitleById($result['nid']);
			if(!isSignedUpInLadder($playerId, $result['nid'])){
				
				$output .= '<td>'.$ladder.'</td><td><a href="'.drupal_lookup_path('alias',"node/".$result['nid']).'">Join</a></td>';	
				$output .= '</tr>';
			}
		}

		$output .= "</table><script class='jsbin' src='http://datatables.net/download/build/jquery.dataTables.nightly.js'></script><script>$(document).ready(function(){
									$('#join-ladder').dataTable();									
								})</script>";

		return $output;
	
	}

	function registerPlayerToLadder($ladderId){
		
		global $user;
		

			db_insert('tennis_challenge_ladder_player')
				->fields(array(
					'playerId' => $user->uid,
					'ranking' => 0,
					'lid' => $ladderId,
					'won' => 0,
					'lost' => 0,
					'no_of_matches' => 0,
			))
				->execute();
		
		$subject = "Newly joined ladder";
		$message = "You have joined a new ladder ".getLadderTitleById($ladderId);
		$node = node_load(245);
		$message .= $node->body['und'][0]['value'];
		privatemsg_new_thread(array(user_load($user->uid)), $subject, $message);
		
		drupal_set_message('You have been successfully registered to the ladder');
		drupal_goto(drupal_lookup_path('alias',"node/".$ladderId));
	}
	
	
	function playerRatingForm_form($form, &$form_state){
		
		$options = array(
			'1' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
		);
		
		$form['punctuality'] = array(
			'#type'  =>	'select',
			'#title' => 'Punctuality',
			'#description' => '',
			'#options' => $options,
		);
		
		$form['on-court-demeanour'] = array(
			'#type'  =>	'select',
			'#title' => 'On Court Demeanour',
			'#description' => '',
			'#options' => $options,
		);
		
		$form['off-court-demeanour'] = array(
			'#type'  =>	'select',
			'#title' => 'Off Court Demeanour',
			'#description' => '',
			'#options' => $options,
		);
		
		$form['recommend-player'] = array(
			'#type'  =>	'select',
			'#title' => 'Would You Recommend This Player To Other Players ?',
			'#description' => '',
			'#options' => $options,
		);
		
		$form['submit'] = array(
			'#type'  => 'submit',
			'#value' => 'Submit Review',
		);
		
		return $form;
	
	}
	
	function playerRatingForm_form_submit($form, &$form_state){
		
		global $user;
		
		$node = node_load(arg(1));
		$challenger = $node->field_challenge_challenger['und'][0]['value'];
		$challenged = $node->field_challenge_challenged['und'][0]['value'];
		$challenger_reviewed = $node->field_challenger_reviewed['und'][0]['value'];
		$challenged_reviewed = $node->field_challenged_reviewed['und'][0]['value'];
		
		$punctuality = $form_state['values']['punctuality'];
		$on_court 	 = $form_state['values']['on-court-demeanour'];
		$off_court	 = $form_state['values']['off-court-demeanour'];
		$recommend 	 = $form_state['values']['recommend-player']; 
		
		if($user->uid == $challenger && ($challenged_reviewed == 'Not Reviewed' || $challenged_reviewed == '')){
			$node->field_challenged_punctuality['und'][0]['value'] = $punctuality;
			$node->field_challenged_on_court['und'][0]['value'] = $on_court;
			$node->field_challenged_off_court['und'][0]['value'] = $off_court;
			$node->field_challenged_recommend['und'][0]['value'] = $recommend;
			$node->field_challenged_reviewed['und'][0]['value'] = 'Reviewed';
			node_save($node);
		}else if($user->uid == $challenged && ($challenger_reviewed == 'Reviewed' || $challenger_reviewed == '')){
			$node->field_challenger_punctuality['und'][0]['value'] = $punctuality;
			$node->field_challenger_on_court['und'][0]['value'] = $on_court;
			$node->field_challenger_off_court['und'][0]['value'] = $off_court;
			$node->field_challenger_recommend['und'][0]['value'] = $recommend;
			$node->field_challenger_reviewed['und'][0]['value'] = 'Reviewed';
			node_save($node);
		}
		
		drupal_set_message('Your review has been submitted');
	}
	
	function submitReview($ladderId, $playerType){
	
		$node = node_load($ladderId);
		
		if($playerType == 'chr'){
			$node->field_challenger_reviewed['und'][0]['value'] = 'Reviewed';
			node_save($node);
		}else if($playerType == 'chd'){
			$node->field_challenged_reviewed['und'][0]['value'] = 'Reviewed';
			node_save($node);
		}
		
		drupal_goto(drupal_lookup_path('alias', 'node/',$ladderId));
	}


	function tennis_challenge_theme($existing, $type, $theme, $path) {
	  return array(
		'tennis_challenge_theme_realign' => array(
		  'render element' => 'element'
		),
	  );
	}

	function theme_tennis_challenge_theme_realign($vars) {
	  $element = $vars['element'];
	  drupal_add_tabledrag('form_id', 'order', 'sibling', 'rank-weight');

	  $header = array(
		'name' => t('Player Name'), 
		//'type' => t('Type'),
		'weight' => t('Weight'),
	  );
	  
	  $rows = array();
	  foreach (element_children($element) as $key) {
		$row = array();
		
		$row['data'] = array();
		foreach ($header as $fieldname => $title) {
		  $row['data'][] = drupal_render($element[$key][$fieldname]);
		  $row['class'] = array('draggable');
		}
		$rows[] = $row;
	  }
	  
	  return theme('table', array(
		'header' => $header, 
		'rows' => $rows,
		'attributes' => array('id' => 'form_id'),
		'empty' => '',
		'sticky' => FALSE,
	  ));
	}	
	
	function getRank($playerId, $ladderId){
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.playerId', $playerId, '=')
			->condition('t.lid', $ladderId, '=')
			->fields('t', array('ranking'));
			
		$result = $query->execute()->fetchAssoc();
		$rank = $result['ranking'];
		
		return $rank;
	}
	
	function getMaxRank($ladderId){
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.lid', $ladderId, '=')
			->fields('t', array('ranking'))
			->orderBy('ranking', 'DESC')
			->range(0, 1);
		
		$result = $query->execute()->fetchAssoc();
		
		return $result['ranking'];
	}
	
	function verifyResultDbUpdate($winner, $loser, $nid){
		db_update('tennis_challenge_ladder_player')
			  ->expression('no_of_matches', 'no_of_matches + 1')
			  ->condition('playerId',array($winner, $loser) , 'IN')
			  ->condition('lid', $nid, '=')
			  ->execute();

		db_update('tennis_challenge_ladder_player')
			->expression('won', 'won + 1')
			->condition('playerId',$winner , '=')
			->condition('lid', $nid, '=')
			->execute();

		db_update('tennis_challenge_ladder_player')
			->expression('lost','lost + 1')
			->condition('playerId',$loser , '=')
			->condition('lid', $nid, '=')
			->execute();
	}
	
	function notifyMe($op, $ladderId){
		global $user;
		
		if($op == 'notifyMe'){
			db_update('tennis_challenge_ladder_player')
				->fields(array(
					'notify' => 1,
				))
				->condition('playerId', $user->uid, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			drupal_set_message("You will be notified about the rankings and results from now on.");
		}else if($op == 'unNotifyMe'){
			db_update('tennis_challenge_ladder_player')
				->fields(array(
					'notify' => 0,
				))
				->condition('playerId', $user->uid, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			drupal_set_message("You will not be notified about any results on the ladder.");
		}
		
		drupal_goto(drupal_lookup_path('alias',"node/".$ladderId));
		
	}
	
	function getNotificationStatus($ladderId){
	
		global $user;
		
		$query = db_select("tennis_challenge_ladder_player", "t");
		$query->condition('t.lid', $ladderId, '=')
		->condition('t.playerId', $user->uid, '=')
		->fields('t', array('notify'));
		
		$result = $query->execute()->fetchAssoc();
		
		if($result['notify'] == 1){
			return 'Notify';
		}else{
			return 'Do Not Notify';
		}
		
	}
	
	function getTimestampByDays($days){
	
		$timestamp = strtotime('+' . $days. ' days');
		return $timestamp;

	}
	
	function freezePlayer($playerId, $ladderId){

		global $user;
		
		$node = node_load($ladderId);
		$coachId = $node->uid;
		
		if($user->uid == $coachId){
			db_update('tennis_challenge_ladder_player')
				->fields(array(
					'frozen' => 1,
					'defreeze_date' => getTimestampByDays(21),
				))
				->condition('playerId', $playerId, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			
			drupal_set_message(getNameById($playerId, 'player_profile').' has been frozen for 21 days.');
			$subject = "Frozen";
			$message = "You have been frozen for 21 days in ladder ".getLadderTitleById($ladderId);
			privatemsg_new_thread(array(user_load($playerId)), $subject, $message);
		}
		
		drupal_goto(drupal_lookup_path('alias', 'node/'.$ladderId));
		
	}
	
	function deFreezePlayer($playerId, $ladderId){

		global $user;
		
		$node = node_load($ladderId);
		$coachId = $node->uid;
		
		if($user->uid == $coachId){
			db_update('tennis_challenge_ladder_player')
				->fields(array(
					'frozen' => 0,
					//'defreeze_date' => getTimestampByDays(21),
				))
				->condition('playerId', $playerId, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			
			drupal_set_message(getNameById($playerId, 'player_profile').' has been De-Freezed successfully.');
			$subject = "Frozen";
			$message = "You have been de-freezed in ladder ".getLadderTitleById($ladderId);
			privatemsg_new_thread(array(user_load($playerId)), $subject, $message);
		}
		
		drupal_goto(drupal_lookup_path('alias', 'node/'.$ladderId));
		
	}
	
	function isFrozen($playerId, $ladderId){
		
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.playerId', $playerId, '=')
		->condition('t.lid', $ladderId, '=')
		->fields('t', array('frozen'));
		
		$result = $query->execute()->fetchAssoc();

		return $result['frozen'];
			
	}
	
	function toggleRole(){
		global $user;
		global $base_url;
		
		if(isset($user->roles[4])){
			db_delete('users_roles')
				->condition('uid', $user->uid, '=')
				->condition('rid', '4', '=')
				->execute();
			
			db_insert('users_roles')
				->fields(array('uid' => $user->uid, 'rid' => '5'))
				->execute();
			drupal_set_message("You are now in Player Mode.");
			drupal_goto($base_url.'/player-panel');
			
		}else if(isset($user->roles[5])){

			db_delete('users_roles')
				->condition('uid', $user->uid, '=')
				->condition('rid', '5', '=')
				->execute();
			
			db_insert('users_roles')
				->fields(array('uid' => $user->uid, 'rid' => '4'))
				->execute();
			drupal_set_message("You are now in Administrator Mode.");
			drupal_goto($base_url.'/coach-panel');
			
		}else if($_GET['role'] == 4){
		
			db_insert('users_roles')
				->fields(array('uid' => $user->uid, 'rid' => '4'))
				->execute();
			drupal_set_message("You are now in Player Mode. Please fill in your profile details by visiting 'Edit Profile' link.");
			drupal_goto($base_url.'/user');
				
		}else if($_GET['role'] == 5){
			db_insert('users_roles')
				->fields(array('uid' => $user->uid, 'rid' => '5'))
				->execute();
			drupal_set_message("You are now in Administrator Mode. Please fill in your profile details by visiting 'Edit Profile' link.");
			drupal_goto($base_url.'/user');
		}else{
			db_insert('users_roles')
				->fields(array('uid' => $user->uid, 'rid' => '4'))
				->execute();
			drupal_set_message("You are now in Player Mode. Please fill in your profile details by visiting 'Edit Profile' link.");
			drupal_goto($base_url.'/user');
		}
		
		//drupal_goto(drupal_lookup_path('alias', 'user/'.$user->uid));
	}
	
	function enter_dispute_form(){
		$form['dispute_description'] = array(
			'#type'  =>	'textarea',
			'#title' => 'Enter Dispute Description',
			'#description' => '',
			'#required' => true,
		);
		
		$form['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Submit Dispute',
		);
		
		return $form;
	}
	
	function enter_dispute_form_submit($form, $form_state){
		
		global $user;
		global $base_url;
		$ladderAdmin = node_load(arg(2));
		
		$challengeNode = node_load(arg(1));
		$challenger = $challengeNode->field_challenge_challenger['und'][0]['value'];
		$challenged = $challengeNode->field_challenge_challenged['und'][0]['value'];

		$subject = "Dispute";
		$message = "Ladder Name: ".getLadderTitleById(arg(2));
		$message .= "\nSubmitter's Name: ".getNameById($user->uid, 'player_profile');
		$message .= "\nChallenge: ". getLadderTitleById(arg(1));
		$message .= "\nDispute: ". $form_state['values']['dispute_description'];
		$message .= "\n<a href='".$base_url."/".drupal_lookup_path('alias', 'node/'.arg(1))."'>Click to visit the challenge page</a>";
		
		privatemsg_new_thread(array(user_load($ladderAdmin)), $subject, $message);
		privatemsg_new_thread(array(user_load($challenger)), $subject, $message);
		privatemsg_new_thread(array(user_load($challenged)), $subject, $message);
		
		$node = node_load(arg(1));
		$node->field_challenge_verified['und'][0]['value'] = "Disputed";
		node_save($node);	
		
		drupal_set_message("Your dispute has been submitted. The competition administrator will contact you shortly");
		drupal_goto(drupal_lookup_path('alias', 'node/'.arg(1)));
	}
	
	function removePlayer($playerId, $ladderId){
	
		global $user;
		global $base_url;
	
		$coachId = node_load($ladderId)->uid;
		if($user->uid == $coachId){
			$rank = getRank($playerId, $ladderId);
			if($rank > 0){
				$query = db_select('tennis_challenge_ladder_player', 't');
				$query->condition('t.lid', $ladderId, '=')
					->condition('t.ranking', $rank, '>')
					->fields('t', array('sno', 'playerId'))
					->orderBy('ranking', 'ASC');
				$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($results as $result){
					db_update('tennis_challenge_ladder_player')
						->fields(array(
							'ranking' => getRank($result['playerId'], $ladderId) - 1,
							//'defreeze_date' => getTimestampByDays(21),
						))
						->condition('sno', $result['sno'], '=')
						->execute();
				}
			}
			
			
			db_delete('tennis_challenge_ladder_player')
				->condition('playerId', $playerId, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			
			$playerName = getNameById($playerId, 'player_profile');
			drupal_set_message($playerName." has been removed from the ladder.");
			drupal_goto($base_url.'/node/'.$ladderId);
		}

	}
	
	function isChallenger($ladderId, $playerId){
		
		$exists = db_query('SELECT 1 FROM {challenge_player} WHERE challenger_id = :uid and lid = :lid', array(':uid' => $playerId, ':lid' => $ladderId))->fetchField();
		
		if($exists){
			return true;
		}else{
			return false;
		}
		
	}
	
	function getChallengedPlayerId($ladderId){
		global $user;
		$exists = db_query('SELECT 1 FROM {challenge_player} WHERE challenger_id = :uid and lid = :lid', array(':uid' => $user->uid, ':lid' => $ladderId))->fetchField();

		if($exists){
			$query = db_select('challenge_player', 'c');
			$query->condition('c.challenger_id', $user->uid, '=')
			->condition('c.lid', $ladderId, '=')
			->fields('c', array('challenged_id'));
			
			$result = $query->execute()->fetchAssoc();
			return $result['challenged_id'];
			
		}else{
			return 0;
		}
	}
	
	function isFree($ladderId){
		$node = node_load($ladderId);
		if($node->field_free_ladder_['und'][0]['value'] == 1){
			return true;
		}else{
			return false;
		}
	}

		
		
	function assignCredits_form(){
		
		//check if the ladder belongs to the logged in user
		
		global $user;
		
		$ladderId = $_GET['ladder'];
		/*$node = node_load($ladderId);
		
		if($node->uid !== $user->uid){
			echo 'The Ladder belongs to a different user';
		}else{*/
			$form = array();
			$header = array(
				'username' => t('Name'),
			);
			$players = getPlayerListByLadderId($ladderId);
			
			$form['usertable'] = array(
				'#type' => 'tableselect',
				'#header' => $header,
				'#empty' => t('All Users are already paid for.'),
				'#options' => $players,
				'#required' => TRUE,
			);
			
			$form['submit'] =  array(
				'#type' => 'submit',
				'#value' => 'Assign Credits',
			);

			return $form;
		//}
	}
	
	function assignCredits_form_validate(&$form, &$form_state){
		foreach($form_state['values']['usertable'] as $playerId){
			$playerIds[] = $playerId;
		}
		
		$ladderId = $_GET['ladder'];
		$price_per_player = pricePerPlayer($ladderId);
		
		if(count($playerIds)*($price_per_player/5) > getCredits()){
			form_set_error('You donot have enough credits');
		}
	}
	
	function assignCredits_form_submit(&$form, &$form_state){
		
		global $user;
		
		$ladderId = $_GET['ladder'];
		$price_per_player = pricePerPlayer($ladderId);
		
		foreach($form_state['values']['usertable'] as $playerId){
			if($playerId != 0){
				$playerIds[] = $playerId;
			}
		}
		
		$credits_to_deduct = count($playerIds)*($price_per_player/5);

		db_update('tennis_challenge_ladder_player')
			->fields(array(
				'paidFor' => 1,
				'paid' => 1,
			))
			->condition('playerId', $playerIds, 'IN')
			->condition('lid', $ladderId, '=')
			->execute();
		
		db_update('user_credits')
			->expression('credits', 'credits - ' . $credits_to_deduct)
			->condition('uid', $user->uid, '=')
			->execute();

		drupal_set_message("Credits assigned to the selected players.");
		drupal_goto(drupal_lookup_path('alias', 'node/'.$ladderId));
	}
	
	function getPlayerListByLadderId($ladderId){
				
		$query = db_select('tennis_challenge_ladder_player', 'tclp');
		$query->condition('tclp.lid', $ladderId, '=')
			->condition('tclp.paidFor', 0, '=')
			->fields('tclp', array('playerId'));
			
		$results = $query->execute()->fetchall(PDO::FETCH_ASSOC);
		
		foreach($results as $result){
			$playerIds[] = $result['playerId'];
		}
	
		foreach($playerIds as $playerId){
			$playerName = getNameById($playerId, 'player_profile');
			if($playerName == ""){
				continue;
			}
				$users[$playerId] = array(
					'username' => $playerName,
				);
			
		}

		return $users;

	}

	function getCredits(){
		global $user;
		
		$query = db_select('user_credits', 'u');
		$query->condition('u.uid', $user->uid, '=')
			->fields('u', array('credits'));
			
		$result = $query->execute()->fetchAssoc();
		return $result['credits'];
	}
	
	function tennis_challenge_node_delete($node){
		
		if($node->type == 'ladder'){

		  db_delete('tennis_challenge_ladder_player')
			->condition('lid', $node->nid)
			->execute();

		}
		
	}
	
	function pricePerPlayer($ladderId){
		$node = node_load($ladderId);
		
		$exploded = explode("$",$node->field_ladder_fee['und'][0]['value']); 
		$exploded = explode(".",$exploded[1]);
		
		$price_per_player = $exploded[0];
		
		return $price_per_player;

	}
	
	function deleteUncofirmedRequests(){
		$query = 'SELECT id, challenger_id, lid, GREATEST(date1, IFNULL(date2, 0), IFNULL(date3, 0), IFNULL(date4, 0)) as datemax FROM challenge_player';
		$results = db_query($query);

		$currentDate = new DateTime(date('Y-m-d H:i:s', time()));

		foreach ($results as $record) {
			$compareDate = new DateTime($record->datemax);
			$interval = $currentDate->diff($compareDate);
			if($interval->format('%R%a') < 0){
				$ids[] = $record->id;
				$challenges[]['challenger'] = $record->challenger_id;
				$challenges[]['lid'] = $record->lid;
			}
		}

		if(!empty($ids)){
			db_delete('challenge_player')
					->condition('id', $ids, 'IN')
					->execute();
		}
		
		foreach($challenges as $challenge){
			db_update('tennis_challenge_ladder_player')
			  ->fields(array(
				'can_challenge' => 1,
			  ))
			  ->condition('playerId', $challenge['challenger'], '=')
			  ->condition('lid', $challenge['lid'], '=')
			  ->execute();
		}

	}
	
	function removeUserFromAllLadders($playerId){
		$query = db_select('tennis_challenge_ladder_player', 't');
		$query->condition('t.playerId', $playerId, '=')
			 ->fields('t', array('lid'));
		
		$ladders = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($ladders as $ladder){
			$ladderId = $ladder['lid'];
			$rank = getRank($playerId, $ladderId);
			if($rank > 0){
				$query = db_select('tennis_challenge_ladder_player', 't');
				$query->condition('t.lid', $ladderId, '=')
					->condition('t.ranking', $rank, '>')
					->fields('t', array('sno', 'playerId'))
					->orderBy('ranking', 'ASC');
				$results = $query->execute()->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($results as $result){
					db_update('tennis_challenge_ladder_player')
						->fields(array(
							'ranking' => getRank($result['playerId'], $ladderId) - 1,
							//'defreeze_date' => getTimestampByDays(21),
						))
						->condition('sno', $result['sno'], '=')
						->execute();
				}
			db_delete('tennis_challenge_ladder_player')
				->condition('playerId', $playerId, '=')
				->condition('lid', $ladderId, '=')
				->execute();
			}
		}
	}
	
	function tennis_challenge_user_delete($account) {
		removeUserFromAllLadders($account->uid);
	}
	