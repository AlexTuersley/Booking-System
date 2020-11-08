<?php
Class Forms{
    static public function generateform($FormName, $JavaScriptAction, $OnSubmit, $Fields, $Button){
        print("<form class='form-horizontal form-group' role='form' name='" . $FormName . "' id='" . $FormName . "' method='post' action='" . $JavaScriptAction . "'" . $OnSubmit . ">");
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
            print("<div class='form-group'>");

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
        $Description = $Field[0];
        $Type = $Field[1];
        $Name = $Field[2];
        $FieldSize = $Field[3];
        $Value = $Field[4];
        $Placeholder = $Field[5];
        $Array = $Field[6];
        $JavaScriptAction = $Field[7];
        $ReadOnly = $Field[8];
        $Class= $Field[9];
        $ToolTip = $Field[10];

        if($Type == "Text"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='text' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value=\"" . $Value . "\"" . $ReadOnly . "title = '" . $ToolTip . "' />");
        }
        elseif($Type == "TextDynamic"){
            print("input class='form-control' placeholder = '" . $Placeholder ."' type='text' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value=\"" . $Value . "\" onchange='" . $JavaScriptAction . "' title = '" . $ToolTip . "'/><span id='" . $Name . "Image'></span>");
        }
        elseif($Type == "Password"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='password' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value='" . $Value . "' title = '" . $ToolTip . "'/>");
        }
        elseif($Type == "FileUpload"){
            print("<input type='file' class='form-control' placeholder = '" . $Placeholder ."' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "'/>");
        }
        elseif($Type == "Select"){
            print("<select class='form-control' name='" . $Name . "' id='" . $Name . "' title = '" . $ToolTip ."'>");

                  foreach($Array as $Item)
                  {
                      if($Item[0] == $Value){
                          print("<option value='" . $Item[0] . "' selected=selected>" . $Item[1] . "</option>");
                      } else {
                          print("<option value='" . $Item[0] . "'>" . $Item[1] . "</option>");
                      }
                  }
              print("</select>");
        }
        //elseif($Type == "MultiSelect"){

        //}
        elseif($Type == "Checkbox"){
            print("<div class='checkboxblock'><input placeholder = '" . $Placeholder ."' class='checkbox' type='checkbox' name='" . $Name . "' value='" . $Array . "' checked='checked " . $OnChange . "' style='display: inline; ".$RowHeaders."' title = '" . $ToolTip ."' id='" . $Name . "'> ".$Placeholder.$Class."</div>");
        }
        elseif($Type == "DateTime") {
            print('<div class="input-group date" id="dtp-'. $Name .'" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input ' . $Class . '" data-target="#dtp-'. $Name .'" name="'. $Name .'"/>
                      <div class="input-group-append" data-target="#dtp-'. $Name .'" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                      </div>
                  </div>

                  <script type="text/javascript">
                    $(function () {
                        $("#dtp-' . $Name . '").datetimepicker({format:"DD/MM/YYYY HH:mm"});
                    });
                  </script>');

        } elseif($Type == "DateTimeNoTime") {
            print('<div class="input-group date" id="dtp-'. $Name .'" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input ' . $Class . '" data-target="#dtp-'. $Name .'" value="'. $Value .'" name="'. $Name .'" id="' . $Name . '"/>
                      <div class="input-group-append" data-target="#dtp-'. $Name .'" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                      </div>
                  </div>

                  <script type="text/javascript">
                    $(function () {
                        $("#dtp-' . $Name . '").datetimepicker({format:"DD/MM/YYYY"});
                    });
                  </script>');
    
        } elseif($Type == "DateRange") {
            print('<div class="container" id="DateRange">
                   <div class="row">
                   <div class="col-6">
                   <div class="input-group date" id="dtp-'. $Name .'start" data-target-input="nearest" style="float:right;"> 
                      <label for="'.$Name.'start" style="margin-right: 10px; margin-top: 5px;">Start: </label>
                      <input type="text" class="form-control datetimepicker-input ' . $Class . '" data-target="#dtp-'. $Name .'start" value="'. $Value[0] .'" name="'. $Name .'start" />
                      <div class="input-group-append" data-target="#dtp-'. $Name .'start" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                      </div>
                   </div>
                   </div>
                   <div class="col-6">
                     <div class="input-group date" id="dtp-'. $Name .'end" data-target-input="nearest" style="float:right;"> 
                        <label for="'.$Name.'end" style="margin-right: 10px; margin-top: 5px;">End: </label>
                        <input type="text" class="form-control datetimepicker-input ' . $Class . '" data-target="#dtp-'. $Name .'end" value="'. $Value[1] .'" name="'. $Name .'end"/>
                        <div class="input-group-append" data-target="#dtp-'. $Name .'end" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                     </div>
                   </div>
                   </div>
                   </div>
                   <script type="text/javascript">
                    $(function () {
                        $("#dtp-' . $Name . 'start").datetimepicker({format:"DD/MM/YYYY"});
                        $("#dtp-' . $Name . 'end").datetimepicker({format:"DD/MM/YYYY"});
                       
                    });
                   </script>');
        }
    }
}

?>