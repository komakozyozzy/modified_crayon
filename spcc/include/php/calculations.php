<?php
/*
 * Apologies for the lack of documentation. When time allows, I will go back through
 * and properly document the functions.
 * 
 * Calculations class provided courtesy of Nik Smith.
 * 
 */
class Calculation {

    public $oil_value = 0;
    public $salt_water_value = 0;
    public $rain_fall;
    public $largest_vessel_area;
    public $largest_vessel_capacity;
    public $largest_vessel_hieght;
    public $contianment_area_volume;
    public $vessel_area_volume;
    public $catch_basin_area_volume;
    public $object_area_volume;
    public $berm_calculation;
    public $production_value;
    const PI = 3.14159265;


    public function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function berm_calc($default=FALSE) {
    
     if(!$default){
        $this->berm_calculation = round(((((( $this->largest_vessel_area * $this->largest_vessel_hieght)+
               ($this->production_value * 5.615))-($this->catch_basin_area_volume))/($this->contianment_area_volume - 
                $this->vessel_area_volume_without_largest_vessel - $this->object_area_volume))*12)+($this->rain_fall+3));
     }
     else {
         $this->berm_calculation = $default;
     }
     //comment this out for testing puposes..
     if($this->berm_calculation < 10)$this->berm_calculation = 10;
    }
    
    public function set_production_value($type, $oil=0, $sw=0){
        
        $type = strtolower($type);
      
        if($type == "oil"){
            $this->oil_value = $oil;
        }
        if($type == "sw"){
        $this->salt_water_value = $sw;
        }
         
        $both_array = array("oil/sw", "sep", "ht", "ih", "fwko", "stkpk", "gb", "scrubber", "dehd", "lh", "con");
        
        foreach($both_array as $value){
            if($type == $value){
                $this->oil_value = $oil; 
                $this->salt_water_value = $sw;
            }
        } 
        $this->production_value = $this->oil_value + $this->salt_water_value;
    
    }
		
    public function nominal_capacity($dia, $hieght, $width = null, $shape = null){
	    if ($shape == "Rectangle" || $width > 0 || $width != null ){
                $vlu = $dia * $hieght * $width * 0.17810760;
            }else{
		$vlu = (3.1416 * $dia / 2 * $dia / 2 * $hieght) * 0.17810760;
		}
        return number_format($vlu, 2, '.', '');
    }
	
    public function calculate_vessel_area($dia, $hieght, $width = null, $shape = null){
	
        $v = $this->nominal_capasity($dia, $hieght, $width);
	       	
        if ($shape == "Rectangle" || $width > 0 ){
            $k = round($dia * $width);
        }else{
        $k = round(($dia/2*$dia/2*3.1416));
        }
		
        if($v > $this->largest_vessel_capasity){
            $this->largest_vessel_hieght = $hieght;
            $this->largest_vessel_area = $k;
            $this->largest_vessel_capasity = $v;
        }
		
        $this->vessel_area_volume += $k;
	$this->vessel_area_volume_without_largest_vessel = $this->vessel_area_volume - $this->largest_vessel_area;
        return $k;
        
    }
	
	
    public function add_area_volume($type, $length, $width){
            switch ($type){
            case "Triangle":
                $vlu = ($length * $width)/2;
                break;
            case "Circle":
                $crcR = $width/2;
                $crcRSquared = $crcR * $crcR;
                $vlu = $crcRSquared * pi();
                break;
            default :
                $vlu = $length * $width;
            }
        $this->contianment_area_volume += $vlu;
        
        return $vlu;
    }
    
    public function add_catch_basin_volume($length, $width, $depth){
        $this->catch_basin_area_volume += $width * $length * $depth;
         return ($width * $length * $depth);
    }
   
    public function add_object_volume($length, $width){
        $this->object_basin_area_volume += $width * $length;
         return ($width * $length);
    }

    public function gallons($diameter, $height) {
		$radius = $diameter / 2;
		return round(self::PI * $radius * $radius * $height * 7.48);
	}

}
