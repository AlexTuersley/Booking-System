<?php
Class Forms{
    static public function generateform($FormName, $Action, $OnSubmit, $Fields, $Button){
        print("<form class='form-horizontal form-group' role='form' name='" . $FormName . "' id='" . $FormName . "' method='post' action='" . $Action . "'" . $OnSubmit . ">");
        foreach($Fields as $Field)
        {
            if($Field == null){
                continue;
            }
            if($Field[1] != "Hidden"){
                print("<div class='form-group'>");
                $Field[2] = $Field[2] == '' ? $Field[0] : $Field[2];
                if ($Field[0] != '') {
                    print("<label for='" . $Field[2] . "' class='control-label'>" . $Field[0] .  "</label>");
                } else {
                    print("<span for='" . $Field[2] . "' class='control-label'>" . $Field[0] .  "</span>");
                }
            }
            forms::generatefield($Field);

            if($Field[1] != "Hidden"){
                print("</div>");
            }
        }
        if($Button){
            echo($ButtonPage);
            print("<div class='form-group '>");

                        $Buttons = explode( ',', $Button );
                        $i = 0;
                        foreach ($Buttons as $key => $btn) {
                            $SubmitType = $i == 0 ? "submit" : "save";
                            $ButtonColour = $i == 0 ? "primary" : "warning";
                            print("<button type='submit' class='btn btn-outline-".$ButtonColour."' id='".$SubmitType."' name='".$SubmitType."' value='" . $btn . "' title=' Click this button to " . $btn ."'>". $btn ."</button> ");
                            $i++;
                        }
                    print("</div>");
                }
            print("</form>");
          
    }
    static public function generatefield($Field){

    }
}

?>