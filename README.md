Zovercy
=======

a very lightweight php framework

Example:

    <?php
    
    class post extends Controller {
        public function show() {
            $pid =Get::number(0);
            $result = Z::$db->table('post')->where('pid=' . $pid)->findOne();
            Check::isEmpty($result);
            
            $this->setData(array('result' => $result));        
            $this->loadView('postshow');      
        }
    }
