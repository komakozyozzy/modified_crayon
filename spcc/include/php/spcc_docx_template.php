<?php
include_once "calculations.php";
include_once "functions.php";
include_once "dbconn.php";
include_once "spcc_config.php";
include_once "../include/php/HTMLHelper.php";


// this array can be built in the logic of the inspection tables.
$deficiency_array = array('' => '');

class FIR {
	private $insp;
	private $areas;
	private $srow = "text-align:right;";
	public function __construct($inspection, $area){
		$this->insp = $inspection;
		$this->areas = $area;
	}
	public function template($title, $data){

		$style = "width:100%;border:3px solid black;";
		$shead = "border:3px solid black;";

        return '<thead >
			<tr style="'.$shead.'">
				<th style="text-align:center" colspan="2">'.$title.'</th>
			</tr>
		</thead>
		<tbody>'.$data.'</tbody>';
	}
	public function location(){

		global $fac_location;
		$html = '';
		foreach ($fac_location as $field => $text) {
            // logic in here to handle questions and build deficiency array
            $html .= '<tr style="'.$this->srow.'">
                          <td width="80%">' . $text . '</td>
                          <td width="20%" style="align:right">' . $this->insp[$field] . '</td>
                      </tr>';
		}
		return $this->template('FACILITY LOCATION',$html);
	}
	public function security(){
		global $fac_security;
		$html = '';
        // use a function with a switch statement to evaluate cases that may need coditional logic
        foreach ($fac_security as $field => $text) {
            // logic in here to handle questions and build deficiency array
            $html .= '<tr style="'.$this->srow.'">
                        <td width="80%">' . $text . '</td>
                        <td width="20%">' . $this->insp[$field] . '</td>
                      </tr>';
		}
		/**
		 * Get the data from the area
		 **/
		$num = 1;
		foreach ($this->areas as $area) {

			$ainfo = $area['props'];
			$html .= '<tr style="'.$this->srow.'">
						<td width="80%">Area # '.$num.' Emergency Shut Off</td>
						<td width="20%">' . $ainfo['emergency_shut_off'] . '</td>
					</tr>';

			$html .= '<tr style="'.$this->srow.'">
						<td width="80%">Area # '.$num.' Area Fenced</td>
						<td width="20%">' . $ainfo['area_fenced'] . '</td>
					</tr>';
			$num += 1;
		}
		return $this->template('FACILITY SECURITY & SIGNAGE',$html);
	}
	public function conditions(){

        global $facility_equipment_conditions;
		$html = '';
        foreach ($facility_equipment_conditions as $field => $text) {
            // logic in here to handle questions and build deficiency array
			$html .=  $this->row($text, $this->insp[$field]);
		}

		/**
		 * Get the data from the area
		 **/
		$num = 1;
		foreach ($this->areas as $area) {

			$ainfo = $area['props'];
			$html .= $this->row('Area # '.$num.' Dike Drain',$ainfo['dike_drain']);
			$num += 1;
		}

		return $this->template('FACILITY EQUIPMENT & CONDITIONS',$html);
	}

	public function berm(){
		//print '<pre>';
		//print_r($this->areas);
		//print '</pre>';
		//die();
		$x = 1;
		foreach ($this->areas as $area) {

			$ainfo = $area['props'];

			$x = $ainfo['areaNum'];
			
			if($ainfo['shape'] != '') {
				$html .= $this->row(
					'Area #'.$x.' Dimensions ',
					$this->dimensions($ainfo['width'],$ainfo['length'],$ainfo['height']));
			}
			if($ainfo['shape_one'] != '') {
				$html .= $this->row(
					'Area #'.$x.' A Dimensions ',
					$this->dimensions($ainfo['width_one'],$ainfo['length_one'],$ainfo['height_one']));
			}

			if($ainfo['shape_two'] != '') {
				$html .= $this->row(
					'Area #'.$x.' B Dimensions ',
					$this->dimensions($ainfo['width_two'],$ainfo['length_two'],$ainfo['height_two']));
			}


			if($ainfo['shape_three'] != '') {
				$html .= $this->row(
					'Area #'.$x.' C Dimensions ',
					$this->dimensions($ainfo['width_three'],$ainfo['length_three'],$ainfo['height_three']));
			}


			if($ainfo['shape_four'] != '') {
				$html .= $this->row(
					'Area #'.$x.' D Dimensions ',
					$this->dimensions($ainfo['width_four'],$ainfo['length_four'],$ainfo['height_four']));
			}

			$html .= $this->row('Area #'.$x.' Berm Construction', $ainfo['berm_constructed']);

			if($ainfo['shape'] != '') {
				$html .= $this->row(
					'Area #'.$x.' Proposed Dimensions ',
					$this->dimensions($ainfo['width_proposed'],$ainfo['length_proposed'],$ainfo['height_proposed']));
			}

			if($ainfo['shape_one'] != '') {
				$html .= $this->row(
					'Area #'.$x.' A Proposed Dimensions ',
					$this->dimensions($ainfo['width_one_proposed'],$ainfo['length_one_proposed'],$ainfo['height_one_proposed']));
			}

			if($ainfo['shape_two'] != '') {
				$html .= $this->row(
					'Area #'.$x.' B Proposed Dimensions ',
					$this->dimensions($ainfo['width_two_proposed'],$ainfo['length_two_proposed'],$ainfo['height_two_proposed']));
			}


			if($ainfo['shape_three'] != '') {
				$html .= $this->row(
					'Area #'.$x.' C Proposed Dimensions ',
					$this->dimensions($ainfo['width_three_proposed'],$ainfo['length_three_proposed'],$ainfo['height_three_proposed']));
			}


			if($ainfo['shape_four'] != '') {
				$html .= $this->row(
					'Area #'.$x.' D Proposed Dimensions ',
					$this->dimensions($ainfo['width_four_proposed'],$ainfo['length_four_proposed'],$ainfo['height_four_proposed']));
			}

		}

		return $this->template('BERM CONDITIONS & DIMENSIONS',$html);
	}
	public function row($question, $answer){

		return '<tr style="'.$this->srow.'">
					<td width="80%">'.$question.'</td>
					<td width="20%">' . $answer . '</td>
				</tr>';
	}
	public function dimensions($w,$l,$h){
		return 'W '.$w.' L '.$l.' H '.$h;
	}
}
class spcc_docx_template {
	/**
	 * @author Nicholas Smith
	 * 
	 * @todo Get all the data for the vessel inpection table
	 */
    private $hdrs = array('tankNum' => 'Tank Number', 'use' => 'Use of tank',
        'num_bbl' => 'Nominal Capacity (bbl)', 'numGal' => 'Nominal Capacity (gallons)',
        'flow' => 'Direction of Flow', 'diameter' => 'Nominal Diameter (ft.)',
        'height' => 'Nominal Height (ft.)', 'type' => 'Type',
        'material' => 'Material', 'top' => 'Top', 'foundation' => 'Foundation',
        'transportation' => 'Transportation');
    public $css = '<style>
                            .SPCC_Table {
                                margin: 0 auto;
                                border: 1px solid black;
                                border-collapse: collapse;
                             }
                            .SPCC_Table table{
                                border-collapse: collapse;

                            }
                            .SPCC_Table th{
                                background-color:#C3C3C3;
                                border:1px solid #000000;

                            }
                            .SPCC_Table td{
                                background-color:#F3F3F3;
                                border:1px solid #000000;
                                text-align:left; margin-left: auto;
    margin-right: auto;
                                font-size:12px;
                                font-family:Helvetica;
                                font-weight:bold;
                                color:#000000;
                            }
                           
                 </style>';
    // this array can be built in the logic of the inspection tables.
    public $deficiency_array = array('' => '');

    /*
     * Each table in the FIR will go in this function, since they are all sort of
     * jumbled in the same constant table in the PDF example I have. This way, 
     * they will page break if they need to. ALl of this is done with the idea of 
     * keeping the format and design as close to the original as possible.
     */

// Vessel/Area data may need to be added as parameters 
	public function fir($inspectionData, $areas) {
		$fir = new FIR($inspectionData[0]['props'],$areas);

		$style = "width:100%;border:3px solid black;";
		$shead = "border:3px solid black;";

		$html = $this->css.'<table class="SPCC_Table" style="'.$style.'">';
		$html .= $fir->location();
		$html .= $fir->security();
		$html .= $fir->conditions();
        $html .= $fir->berm();
        // SUMMARY OF DETAILS THAT NEED IMMEDIATE ATTENTION TABLE / DEFICIENCIES
        $html .='<tr style="'.$shead.'">
                    <th style="text-align:center; color:#fff; background-color:red" colspan="2">
                       SUMMARY OF DETAILS THAT NEED IMMEDIATE ATTENTION:
                    </th>
                 </tr></thead><tbody>';
        // for each entry in the deficiency array...
//        foreach($facility_equipment_conditions as $field => $text){
//            $html .= '<tr>
//                        <td width="80%">'.$text.'</td>
//                        <td width="20%">'.$info[$field].'</td>
//                      </tr>';
//        }
        $html .= '</tbody></table>';
        return $html;
    }

    /*
     *  PREPARED FOR
     *  Parameters: company data
     */

    public function prepared_for($data) {
        $comp_addr = $data['Company_Address'] . ' ' . $data['Company_City'] . ', ' .
                $data['Company_State'] . ' ' . $data['Company_Zipcode'];
        $comp_phone = '' . $data['Company_Area_Code'] . '' . $data['Company_Prefix'] .
                '' . $data['Company_Sufix'];
        $facType = 'Onshore ' . $data['Facility_Type'] . ' Facility';
        $h = new HTMLHelper();
		$style = array(
			'class' => 'SPCC_Table',
			'style' => 'text-align:center;');
        $srow = array('style' => 'text-align:center;');
        $class = array('class' => 'SPCC_Table');
        $html = $h->tag('div',
			$this->css.$h->tag('table', 
				$h->tag('thead', $h->tag('tr', $h->tag('th', 'Prepared For', $style))) .
					$h->tag('tbody', 
						$h->tag('tr', $h->tag('td', $data['Company_Name']),$srow) .
                      	$h->tag('tr', $h->tag('td', $comp_addr),$srow) .
                       	$h->tag('tr', $h->tag('td', $comp_phone),$srow) .
                       	$h->tag('tr', $h->tag('td', $h->tag('b', $data['Facility_Name'])),$srow) .
                       	$h->tag('tr', $h->tag('td', $data['Facility_Name']),$srow) .
                        $h->tag('tr', $h->tag('td', $facType),$srow)
					), $style), 
				array('style'=>' margin-left: auto;margin-right: auto;width:100%'));
        return $html;
    }

    public function area_statement($calc, $area) {
        $str = '';
        foreach ($area as $a) {
            $c = $l = $w = $n = $m = $ld = '';
            $str .= '';
            foreach (array(
        '' => '',
        '-A' => '_one',
        '-B' => '_two',
        '-C' => '_three',
        '-D' => '_four') as $letter => $append) {
                $c = $calc[$a['id']]->berm_calculation;
                $l = $a['props']['length' . $append];
                $w = $a['props']['width' . $append];
                $n = $a['props']['areaNum'];
                $ld = $a['props']['load_dir'];
                $m = $a['props']['berm_constructed'];
                $l_dir = "The truck loading area is located on the $ld side of the containment area.  ";
                $str .= "<p>Area $n $letter: $l' x $w' x $c\" and it is constructed of $m.  $l_dir </p>";
            }
            $str .= '';
        }
        return $str;
    }

    /*
     *  BERM TABLE CALCULATIONS
     *  Parameters: Area/Vessel Information
     */

    public function berm_calc_table($areas, $vessels, $cb, $objects, $calc) {
        $h = new HTMLHelper();
		$cnt = 0;
        //creates the seperate tables for the berm calc
       	return $this->css.implode(array_map(function($area) use ($vessels, $cb, $objects, $h, $calc, &$cnt) {
        	$html = "<p>Table 3-2.$cnt: Berm capacity calculations - 40 CFR Part 112.7(c) & 112.7(a)(3)(iii)</p>";
			$cnt += 1;
            $html .= $h->tag('table',
                     	$h->tag('tr',
                        	$h->tag('td',
                            	$this->get_vessel_area_table($vessels, $area['id'], $calc[$area['id']])
                            )
						).
					$h->tag('tr',
                        	$h->tag('td',
                                $this->get_containment_area_table($area, $calc[$area['id']])
                            )
						).                     	
					$h->tag('tr',
                 		$h->tag('td',
                                $this->get_cb_area_table($cb, $area['id'])
                            )
						).
					$h->tag('tr',
                		$h->tag('td',
                                $this->get_object_area_table($objects, $area['id'])
                            )
						),  array(
							'class' => 'SPCC_Table',
                      	    'style' => 'width:100%;'
							)
					);
			return $html;
        }, $areas));
    }
    private function get_vessel_area_table($vessels, $areaId, $calc){
        $h = new HTMLHelper();
        $get_vessels = function($_) use ($areaId) {
                    return ($_['parent'] == $areaId) ? True : False;
                };
        $header = $h->tag(
                        'tr', $h->tag('th', 'Area Taken Up By Vessels:', array('colspan' => '4'))).$h->tag(
                        'tr', $h->tag('th', 'Vessel No.') .
                        $h->tag('th', 'Diameter (ft)') .
                        $h->tag('th', 'Height (ft)') .
                        $h->tag('th', 'Sq. Ft.')
                        );
        $rows =  implode(array_map(function($_) use ($h) {
                                    $dia = $_['props']['diameter'];
                                          return $h->tag('tr', $h->tag('td', $_['props']['tankNum']) .
                                                    $h->tag('td', $_['props']['diameter']) .
                                                    $h->tag('td', $_['props']['height']) .
                                                    $h->tag('td', round(($dia / 2 * $dia / 2 * 3.1416)))
                                    );
                                }, array_filter($vessels, $get_vessels)));
        $footer = $h->tag('tr', 
                $h->tag('td', 'Total Area taken up by vessels other than the largest vessel=  ', 
                        array('colspan' => '3', 'style' => 'text-align:right;')).
                $h->tag('td', $calc->largest_vessel_area));
        
        return $h->tag(
                'table', $header . $rows . $footer,
                array('class' => 'SPCC_Table',
                      'style' => 'width:100%;')
        );
    }
    
    private function get_containment_area_table($area, $calc){
        $h = new HTMLHelper();
        $temp_calc = new Calculation();
        $sub = array('','_one','_two','_three','_four');
        $footer = $h->tag('tr', 
                $h->tag('td', 'Total (A) of Secondary Containment Area =',array('colspan' => '2')).
                $h->tag('td', $calc->contianment_area_volume));
        return $h->tag(
                'table', $h->tag(
                        'tr', $h->tag('th', 'Secondary Containment Area:', array('colspan' => '3'))).$h->tag(
                        'tr', $h->tag('th', 'Geometric Shape') .
                        $h->tag('th', '') .
                        $h->tag('th', '(A) Sq. Ft.')
                ) . implode(
                        array_map(function($_) use ($h, $area, $temp_calc) {
                                    $a_props = $area['props'];
                                    $desc = $a_props['width'.$_].' X '.$a_props['length'.$_];
                                    if($a_props['shape'.$_] != ''){
                                    return $h->tag('tr', $h->tag('td', $a_props['shape'.$_]) .
                                                    $h->tag('td', $desc) .
                                                    $h->tag('td', $temp_calc->add_area_volume($a_props['shape'.$_], $a_props['length'.$_], $a_props['width'.$_]))
                                    );
                                    } else {return '';}
                                }, $sub
                        )
                ).$footer, array(
            'class' => 'SPCC_Table', 'width' => '100%'
                )
        );
         die();    
        
    }
    private function get_cb_area_table($cb, $areaId){
        $h = new HTMLHelper();
		$tmp_calc = new Calculation();
        $get_cbs = function($_) use ($areaId) {
                    return ($_['parent'] == $areaId) ? True : False;
                };
		$cb = array_filter($cb, $get_cbs);
		if(count($cb) == 0){
			return '';
		} else {
        	return $h->tag(
                	'table', $h->tag(
                        	'tr', $h->tag('th', 'Total Volume of Catch Basin(s):',array('colspan' => '4'))).$h->tag(
                        	'tr', $h->tag('th', 'Length (ft)') .
                        	$h->tag('th', 'Width (ft)') .
                        	$h->tag('th', 'Depth (ft)') .
                        	$h->tag('th', 'Cu. Ft.')
                	) . implode(
                        	array_map(function($_) use ($h, $tmp_calc) {
                                    	return $h->tag('tr', $h->tag('td', $_['props']['length']) .
                                                    	$h->tag('td', $_['props']['width']) .
                                                    	$h->tag('td', $_['props']['depth']) .
                                                    	$h->tag('td', $tmp_calc->add_catch_basin_volume(
														$_['props']['length'],
														$_['props']['width'],
														$_['props']['depth']))
                                    	);
                                	}, $cb
                        	)
                	), array(
            	'class' => 'SPCC_Table', 'width' => '100%'
                	)
        	);
        }
    }
    private function get_object_area_table($objects, $areaId){
        $h = new HTMLHelper();
		$tmp_calc = new Calculation();
        $get_objects = function($_) use ($areaId) {
                    return ($_['parent'] == $areaId) ? True : False;
                };
		$objects = array_filter($objects, $get_objects);
		if(count($objects) == 0){
			return '';
		} else {
        	return $h->tag(
        	        'table', $h->tag(
                        	'tr', $h->tag('th', 'Total Volume of Object(s):',array('colspan' => '4'))).$h->tag(
                        	'tr', $h->tag('th', 'Length (ft)') .
                        	$h->tag('th', 'Width (ft)') .
                        	$h->tag('th', 'Depth (ft)') .
                        	$h->tag('th', 'Cu. Ft.')
                	) . implode(
                        	array_map(function($_) use ($h, $tmp_calc) {
                                    	return $h->tag('tr', 
                                    		$h->tag('td', $_['props']['length']) .
                                        	$h->tag('td', $_['props']['width']) .
                                        	$h->tag('td', $_['props']['desc']) .
                                        	$h->tag('td', $tmp_calc->add_object_volume(
												$_['props']['length'],
												$_['props']['width']
												)
											)
                                    	);
                                	}, $objects
                        	)
                	), array(
            	'class' => 'SPCC_Table', 'width' => '100%'
                	)
        	);
        }
    }
    /*
     *  BERM TABLE CALCULATIONS
     *  Parameters: Area/Vessel Information
     */

    public function chemical_table($chemical) {
        $h = new HTMLHelper();
        $gallons = function($radius, $height) {
                    return round(3.14159265 * $radius * $radius * $height * 7.48);
                };
        $cnt = 0;
        foreach ($chemical as $tank) {
            $cnt += 1;
            $prop = $tank['props'];
            $radius = (is_numeric($prop['diameter'])) ? $prop['diameter'] / 2 : 0;
            $height = (is_numeric($prop['height'])) ? $prop['height'] : 0;
            $rows[] = $h->tag('tr', $h->tag('td', $cnt) .
                    $h->tag('td', $prop['type']) .
                    $h->tag('td', $prop['construction']) .
                    $h->tag('td', $prop['content']) .
                    $h->tag('td', $gallons($radius, $height)) .
                    $h->tag('td', $gallons($radius, $height) * 32)
            );
        }

        return $this->css . $h->tag('table', $h->tag('tr', $h->tag('th', 'ID') .
                                $h->tag('th', 'Type') .
                                $h->tag('th', 'Contruction') .
                                $h->tag('th', 'Primary Content') .
                                $h->tag('th', 'Capacity Barrels') .
                                $h->tag('th', 'Capacity Barrels')
                        ) . implode($rows) .
                        $h->tag('tr', $h->tag('td', '', array('colspan' => '4')) .
                                $h->tag('td', 'Total') .
                                $h->tag('td', '89')
                        ), array(
                    'style' => 'width:80%;',
                    'class' => 'SPCC_Table'
                        )
        );
    }

    /*
     * VESSEL TABLES(S)
     * Parameters: Area/Vessel Information
     */

    public function vessel_table($data, $aData) {
        $h = new HTMLHelper();
        $html = '';
        foreach ($this->_vessel_table($data) as $area => $table) {
            $area = explode('-', $area);
            $aNum = 0;
            foreach ($aData as $a) {
                if ($a['id'] == $area[0]) {
                    $aNum = $a['props']['areaNum'];
                }
            }
            $txt = 'Table 3-1.' . ($area[1] - 1) . ': Potential discharge volume - Area ' . $aNum;
            $html .= $h->tag('b', $txt);
            $html .= $this->css;
            $html .= $h->tag('table', implode('', $table), array('class' => 'SPCC_Table'));
        }
        return $html;
    }

    private function _vessel_table($data) {
        $h = new HTMLHelper();
        $htmlRows = array();
        $cnt = 0;
        $x = 0;
        $th = array('style' => 'width:100px;');
        $td = array('style' => 'width:50px;');
        $rows = $this->sortVesselData($data);
        foreach ($rows as $head => $row) {
            foreach ($row as $areaNumber => $area) {
                $htmlRow = $h->tag('th', $head);
                $i = 0;
                foreach ($area as $vessel) {
                    $i++;
                    $htmlRow .= $h->tag((($i == 0) ? 'th' : 'td'), $vessel, (($i == 0) ? $th : $td));
                    if (($i % 5) == 0 && count($area) > $i) {
                        if (empty($htmlRows[$areaNumber . '-' . $cnt])) {
                            $htmlRows[$areaNumber . '-' . $cnt] = array($h->tag('tr', $htmlRow));
                        } else {
                            $htmlRows[$areaNumber . '-' . $cnt][] = $h->tag('tr', $htmlRow);
                        }
                        $cnt++;
                        $htmlRow = $h->tag('th', $head);
                    }
                }
                if (empty($htmlRows[$areaNumber . '-' . $cnt])) {
                    $htmlRows[$areaNumber . '-' . $cnt] = array($h->tag('tr', $htmlRow));
                } else {
                    $htmlRows[$areaNumber . '-' . $cnt][] = $h->tag('tr', $htmlRow);
                }
                $cnt++;
                $x = 1;
            }
            $cnt = 0;
        }
        return $htmlRows;
    }

    private function sortVesselData($data) {
        $row = array();

        foreach ($this->hdrs as $p => $h) {
            $row[$h] = array();
            foreach ($data as $vessel) {
                $prop = (isset($vessel['props'][$p])) ? $vessel['props'][$p] : '';
                if (array_key_exists($vessel['parent'], $row[$h])) {
                    $row[$h][$vessel['parent']][] = $prop;
                } else {
                    $row[$h][$vessel['parent']] = array($prop);
                }
            }
        }
        return $row;
    }

	
	public function vessel_inspection_table($areas, $vessels){
		$h = new HTMLHelper();
		
		return $this->css.implode(
			array_map(
				function($area) use ($h, $vessels){
					$pId = $area['id'];
					$cb_filter = function($vessel) use ($pId){
						return ($vessel['parent'] == $pId)? True : False;
					};
					return $h->tag(
						'table',
						$h->tag('tr', 
							$h->tag('th', 'Area '.$area['props']['areaNum'].' Tank', 
								array('width'=>'10%')
							) .
							$h->tag('th', 'Year Built') .
							$h->tag('th', 'Last Inspection Date') .
							$h->tag('th', 'Condition') .
							$h->tag('th', 'Next Inspection By')
						) . implode(
							array_map(
								function($vessel) use ($h){
									return $h->tag('tr', 
										$h->tag('td', $vessel['props']['tankNum']) . 
										$h->tag('td', $vessel['props']['yr_manufactured']) . 
										$h->tag('td', '') . 
										$h->tag('td', '') . 
										$h->tag('td', '')
									);
									
								}, array_filter($vessels, $cb_filter)
							)
						),
						array(
            				'style' => 'width:80%;',
                			'class' => 'SPCC_Table'
            			)
					);
				},$areas
			)
		);
	}
}

?>
