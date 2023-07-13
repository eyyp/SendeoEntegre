<?php
namespace Boovi\Boovicargo;
    class BooviHooks {
        function __construct(){
            
        }

        public function useCheck($param,$default){
            if(isset($param)){
                return $param;
            }
            else{
                return $default;
            }
        }
    
        public function useSettingsControl($call) {
            return isset($this->settings[$call]) && $this->settings[$call];
        }
    
        public function useGetControl($param,$default){
            if ( $param) {
                $data = $param;
            } else {
                $data = $this->useGetCheck($param,$default);
            }
            return $data;
        }
    
        public function useGetCheck($param,$default){
            $data = isset( $this->request->get[ $param ] ) ? $this->request->get[ $param ] : $default;
            return $data;
        }
    
        public function useParamControl($param)
        {
            //isset() null değilse ve oluşturulduysa true döner. oluşturulmamış ve ya null ise false döner.
            //empty() değer atanmamışsa veya 0 ve null ise true atama var ise false döner.
            $data = $this->useGetControl($param);
            
            if(empty($data) && isset($_POST[$param])){
                $data = $_POST[$param];
            }
    
            if(empty($data)){
                return false;
            }
            else{
                return  $data;
            }
            
        }
    
        public function useDoubleCheck($control) {
            return isset($control) && $control;
        }
    
    } 
?>