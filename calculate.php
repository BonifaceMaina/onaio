<?php 
define("FORMAT", "%.2f");
	function Calculator($json){
		//initialize variables we need
		$counter=0;//number of functioining water points
		$counts=array();
		$community=array();
		$community_water_points=array(); //waterpoint for each community
		$non_functional_water_points=array();
		$array_to_rank=array();

		//looping through the data to get total points per community
		foreach ($json as $data => $value) {
			if(isset($value['water_functioning'])){
				$status= $value['water_functioning'];
				$community=$value['communities_villages'];
				if(!in_array($community, $non_functional_water_points)){
					array_push($non_functional_water_points, $community);
				}	
				if(strcasecmp($status, "yes")==0){
					++$counter;
				}	
			}
		}
		$total_broken_water_points=array();
		//passing data to calculating functions to get total
		for($i=0; $i<count($non_functional_water_points); ++$i){
			$comm=$non_functional_water_points[$i];
			$community_water_points[$comm]=total_water_points($json, $comm);
			$total_broken_water_points[$comm]=get_total_broken_water_points($json, $comm);
			$array_to_rank=$total_broken_water_points;
		}

		$count['functional_points']=$counter;
		$count['total_water_points']= json_encode($community_water_points);
		$count['ranking']= community_ranking($array_to_rank);

		return $count;
	}

//calculating the number of water point for each community
function total_water_points($json, $community, $functioning='yes'){
			
			$counter=0;
			foreach($json as $data=>$value){
				if(isset($value['communities_villages'])){
					$community_compare=$value['communities_villages'];
					if(strcasecmp($community, $community_compare)==0){
						if($functioning==NULL|| empty($functioning)){
						++$counter;
					}
					else{
						$status=$value['water_functioning'];
						if(strcasecmp($functioning, $status)==0){
							++$counter;
						}
					}
				}

				}
			}
			return $counter;

		}

//calculating broken water points
 function get_total_broken_water_points($json, $community){
			$counter=0;
			foreach($json as $data=>$value){
				if(isset($value['communities_villages'])){
					$community_compare=$value['communities_villages'];
					if(strcasecmp($community, $community_compare)==0){
						if(isset($value['water_point_condition'])){
							$status=$value['water_point_condition'];
							if(strcasecmp($status, "broken")==0){
								++$counter;
							}
						}
					}
				}
			}
			return $counter;

		}

	 function community_ranking($data){
			$percentages=array();
			$total=0;
			foreach ($data as $community=>$total_broken_water_points) {
				$total=$total+$total_broken_water_points;
				# code...
			}
			//now to calculate the percentages
			$percentages=array();
			foreach($data as $community=>$total_broken_water_points){
				$percentage=($total_broken_water_points*100)/$total;
				$percentages[$community]=sprintf(FORMAT, $percentage);
			}
			//sorting the percentages
			array_multisort($percentages);

			return json_encode($percentages);

		}
 ?>