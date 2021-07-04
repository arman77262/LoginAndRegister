<?php 

    class Fromat{

        public function formatedate($data)
        {
            return date("F j, Y, g:i a", strtotime($data));
        }

        public function textSorten($text, $limit=400){
            $text = $text.' ';
            $text =substr($text,0, $limit);
            $text = $text . '........';
            return $text;
        }

        public function validation($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            return $data;
        }

        public function title()
        {
            $path = $_SERVER['SCRIPT_FILENAME'];
            $title = basename($path, '.php');
            $title = str_replace('_', ' ', $title);
            if ($title == 'index') {
                $title = ucfirst('home');
            } elseif ($title == 'contact') {
                $title = ucfirst('contact');
            }
            return $title;
        }

    }

?>