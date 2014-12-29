<?php

/*
 * Once the ablility for the user to enter questions and store them in a database
 * is available, these arrays can be built dynamically from the database, in place 
 * of being statically declared here. The user can CRUD questions to thier hearts
 * desire after that and nothing in spcc_docx_template.php needs to be altered 
 * unless conditional logic is required for new questions.
 * 
 * query generated arrays would be a better solution, but for the present time this
 * method will work.
 */

    $op_info = array('OO_number'=>'Operator Number: ', 
                     'OO_mailing_address'=>'Operator Mailing Address:',
                     'OO_physical_address'=>'Operator Physical Address:', 
                     'OO_day_phone'=>'Operator Day Phone:', 
                     'OO_fax'=>'Operator Fax:',
                     'AR_name'=>'Authorized Representative:',
                     'AR_title'=>'Title:',
                     'AR_home_address'=>'Auth. Rep. Home Address:',
                     'AR-phone'=>'Auth. Rep. 24 Hr Cell/Phone:',
                     'AR_email'=>'Auth. Rep. Email', 
                     'FOM_name'=>'field Operations Manager (FOM):',
                     'FOM_home_address'=>'FOM Home Address:',
                     'FOM_phone'=>'FOM 24 Hr Cell/Phone:',
                     'RC_name'=>'Response Coordinator:',
                     'RC_address'=>'RC Home Address:',  
                     'RC_phone'=>'RC 24 Hr Cell/Phone',
                     'full_time_RC'=>'Does Owner/Operator Employ a Full Time RC?',
                     'experience'=>'Whose work experience will be referred to in plan? [Title] ',
                     'years_experience'=>'Number Years Experience in Oil Production: [# ONLY] ',
                     'plans_kept'=>'Where are SPCC plans and reports kept? ',
                     'greater_sixteen_fac'=>'Are there greater than 16 Facilities for this Owner/Operator that Scientific is providing SPCC\'s for? '
                    );
    
    $fac_location = array('facility_state'=>'Facility State', 
                         'facility_county'=>'Facility County',
						 'facility_type'=>'Facility Type', 
						 'legal_desc' => 'Legal Description:',
                         'rrc_num'=>'Lease Permit Number:', 
                         'latitude'=>'Center of Facility GPS Latitude',
                         'longitude'=>'Center of Facility GPS Logitude' 
                       );

    $fac_security = array('gate_entrance'=>'Is there a gate at the entrance?', 
                          'entrance_locked'=>'Is the gate open or locked?',
                          'sign_entrance'=>'Is there a sign at the entrance?',
                          'sign_entrance_condition'=>'What is the condition of the sign?',
                          'main_road'=>'What is the lease road constructed of?',
                          'road_comp'=>'What is the condition of the lease road?',
                          'signage_tank'=>'Is there a sign at the tank battery?',
                          'signage_tank_condition'=>'What is the condition of the sign?',
                          'signage_well'=>'Is there a sign at the wellhead?',
                          'signage_well_condition'=>'What is the condition of the sign?',
                          'h2s_gas'=>'Is there H2S gas present?',
                          'h2s_gas_sign'=>'Is there a sign?',
                          'h2s_gas_ppms'=>'What is the H2S Measurement?',
						  'h2s_wind_condtion'=>'What is the Wind Condition?',
						  'facility_monitored'=>'Is Facility Monitored'
						  // containment area questions need to be generated dynamically
						  // area_fenced
						  // emergency_shut_off
                       );
    /*
     *  Everything will work for this array except the 'sump pump for area 1' question and the dike drain 
     *  for area ### question. If this is asked for each area then inside the for loop through the array 
     *  in the SPCCDX.php file there will need to be logic to handle the sump pump questions for each area.
     */
   
    $facility_equipment_conditions = array('well_sludge'=>'Does Wellhead have sludge in surrounding area or signs of seepage or leaks?',
                                           'direction_flow'=>'What is the direction of flow if a discharge should occur?',
                                           'terrain'=>'The terrain is:',
                                           'close_water'=>'Nearest water areas:',
                                           'loadlines_bullplugs'=>'Are loadlines equipped with bullplugs?',
                                           'loadline_buckets_with_lids'=>'Are loadlines extending beyond containment area equipped with drip buckets that have lids?',
                                           'cont_beneath_lines'=>'Is there containment beneath loadlines extending beyond the containment area?',
                                           'tank_level'=>'Are tanks level?',
                                           'ladder_safe'=>'Are ladders in safe condition?',
                                           'buried_tanks'=>'Are there any buried tanks or partially buried tanks?',
                                           'is_ves_corrision'=>'Do vessels show signs of corrosion?',
                                           'vessels_are_corroded'=>'Which tanks?',
                                           'is_ves_painted'=>'Do vessels need painting?',
                                           'vessels_need_painting'=>'Which Tanks?',
                                           'salt_water_nets'=>'Are all open top water tanks covered with nets? N/A for closed top tanks.',
                                           'smoke_stack_covered'=>'Are there screens covering all smoke stacks of heater treaters?',
                                           'trash_in_cont'=>'Are there trash bins inside of containment or trash/debris on the ground inside of containment?',
                                           'ele_poles_in_cont'=>'Are there electric boxes or poles inside of containment?', 
                                           'foilage_in_cont'=>'Is there foliage (grass, weeds, trees, etc.) inside containment?',
                                           'connection_leak'=>'Are there leaks or seepage at any connections?',
                                           'signs_spills'=>'Is there any sludge or signs of salt water spills inside or outside of containment?'
                                         );
        
    
/*
 *  create deficiency array to match answers up with actual deficiencies recorded, 
 *  this way you can use php's in_array to grab an answer if it is actually in the deficiency table.
 * 
 *  nia_ stands for not in the array... meaning additional logic will be needed fro display of these 
 *  questions.
 * 
 * This table will most likely need to be added to. I do not currently have a list of all deficiencies,
 * and there will surely be some that pup up. Simply adding them to the array and providing logic if 
 * needed to the actual table in spcc_docx_template.php should suffice for any needed additions.
 */
    
    $deficiency_answers = array('nia_breaches'=>'Repair any breaches in the berm.',
                                'signage_tank'=>'Install sign.', 
                                'signage_well'=>'Install sign.',
                                'loadlines_bullplugs'=>'Add bullplugs to all loadlines.',
                                'trash_in_cont'=>'Remove all trash bins and debris from inside of containment.',
                                'nia_other'=>'Ensure all tanks are properly identified.',
                                'nia_other'=>'Ensure all tanks have proper NFPA fire diamonds.'
                               );
    ?>
