<?php
Class Forms{
    static public function generateform($FormName, $Action, $OnSubmit, $Fields, $Button){
        if($OnSubmit){$OnSubmit = " onsubmit='" . $OnSubmit . "'";}
        print("<div class='container' style='padding-top:2em;'>");
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
            print("<div class='form-group'>");
                        $Buttons = explode( ',', $Button );
                        $i = 0;
                        foreach ($Buttons as $key => $btn) {
                            $SubmitType = $i == 0 ? "submit" : "save";
                            $ButtonColour = $i == 0 ? "dark" : "warning";
                            print("<button type='submit' class='btn btn-outline-".$ButtonColour."' id='".$SubmitType."' name='".$SubmitType."' value='" . $btn . "' title=' Click this button to " . $btn ."'>". $btn ."</button> ");
                            $i++;
                        }
                        print("<a style='color:black' href='" . htmlspecialchars(filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING , 'UTF-8'), ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-secondary' id='cancel' title='Click this button to cancel this form and return to the previous page'>Cancel</a>");
                    print("</div>");
                }
            print("</form>");
            print("</div>");
          
    }
    static public function generatefield($Field){
        $Description = $Field[0];
        $Type = $Field[1];
        $Name = $Field[2];
        $FieldSize = $Field[3];
        $Value = $Field[4];
        $Placeholder = $Field[5];
        $Array = $Field[6];
        $Action = $Field[7];
        $ReadOnly = $Field[8];
        $Class= $Field[9];
        $ToolTip = $Field[10];

        if($Type == "Text"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='text' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value='" . $Value . "' " . $ReadOnly . " title = '" . $ToolTip . "' />");
        }
        if($Type == "NumberText"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='number' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value='" . $Value . "' " . $ReadOnly . " title = '" . $ToolTip . "' />");
        }
        elseif($Type == "TextArea"){
            print("<div class='form-group purple-border'>
                <textarea class='form-control' id='".$Name."' name='".$Name."' placeholder = '" . $Placeholder ."' rows='" . $FieldSize . "' value='" . $Value . "' " . $ReadOnly . " title = '" . $ToolTip . "'>".$Value."</textarea>
            </div>");
        }
        elseif($Type == "TextDynamic"){
            print("input class='form-control' placeholder = '" . $Placeholder ."' type='text' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value=\"" . $Value . "\" onchange='" . $Action . "' title = '" . $ToolTip . "'/><span id='" . $Name . "Image'></span>");
        }
        elseif($Type == "Email"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='email' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value=\"" . $Value . "\"" . $ReadOnly . "title = '" . $ToolTip . "' />");
        }
        elseif($Type == "Password"){
            print("<input class='form-control' placeholder = '" . $Placeholder ."' type='password' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "' value='" . $Value . "' title = '" . $ToolTip . "'/>");
        }
        elseif($Type == "FileUpload"){
            print("<input type='file' class='form-control' placeholder = '" . $Placeholder ."' name='" . $Name . "' id='" . $Name . "' size='" . $FieldSize . "'/>");
        }
        elseif($Type == "Select"){
            print("<select class='form-control' name='" . $Name . "' id='" . $Name . "' ". $ReadOnly ." title = '" . $ToolTip ."'>");
                if($ReadOnly){
                    foreach($Array as $Item)
                    {
                        if($Item[0] == $Value){
                            print("<option value='" . $Item[0] . "' selected=selected>" . $Item[1] . "</option>");
                        }
                    }
                }
                else{
                    foreach($Array as $Item)
                    {
                        if($Item[0] == $Value){
                            print("<option value='" . $Item[0] . "' selected=selected>" . $Item[1] . "</option>");
                        } else {
                            print("<option value='" . $Item[0] . "'>" . $Item[1] . "</option>");
                        }
                    }
                }
               
              print("</select>");
        }
        elseif($Type == "Checkbox"){
            print("<div class='checkboxblock'><input placeholder = '" .$Placeholder."' class='checkbox' type='checkbox' name='" . $Name . "' value='" . $Value . "' " . $OnChange . "' style='display: inline; ".$RowHeaders."' title = '" . $ToolTip ."' id='" . $Name . "'> ".$Placeholder.$Class."</div>");
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
    static public function generateerrors($ErrorTitle,$Errors,$ShowDefault)
        {
            if($ShowDefault)
            {
                print("<div id='errorsshow' class='alert alert-danger'>");
            } else {
                print("<div id='errors' class='alert alert-danger'>");
            }

                print("<p class='title'>$ErrorTitle</p>");
                print("<ul>");
                foreach($Errors as $Error)
                {
                    print("<li id='" . $Error[0] . "'>" . $Error[1] . "</li>");
                }
                print("</ul>");
            print("</div>");
        }
}

?>