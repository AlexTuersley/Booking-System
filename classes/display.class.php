<?php
Class Display{

    static public function generatedropdowndisplay($ID,$Rows,$Cols){
        print("div class='dropdowntable'>");


        print("</div>");
    }
    static public function generatedynamiclistdisplay($ID,$Cols,$Rows,$Name = "",$SearchColumn = 0){
        print("<input id='dynamictable' class='form-control' onkeyup='searchFunction()' placeholder='Type Here to Filter ".$Name."' type='text' style='margin-top:10px;'/>");
        print("<table class=\"table table-hover sorted_table\" id=\"" . $ID . "\">\n");
        print("<thead>");
            print("<tr style='background-color:#ddd;'>\n");

            foreach($Cols as $Col)
            {
                $SortBy = $Col[0] == "" ? "" : "<i class=\"fa fa-sort\" aria-hidden=\"true\" title='Sort by " . $Col[0] . "' style='float:right;'></i>";

                print("<th id='sortable-".str_replace(' ','_',$Col[0])."' class=\"sortable_col " . $Col[1] . "\" colspan=\"" . $Col[2] . "\">" . $Col[0] . $SortBy . "</th>\n");

            }
            print("</tr>\n");
        print("</thead>");
        print("<tbody>");
            foreach($Rows as $Row)
            {
                if($Row == null){ continue; }
                print("<tr " . $Row[0][2] . " >\n");
                foreach($Row as $Item)
                {
                    if($Item[1])
                    {
                        $Class = " class = \"" . $Item[1] . "\" ";
                    }

                    if($Item[1] == "button" || $Row[1][1] == ''){
                        $TDClick = "";
                    }else{

                        $TDClick = "onclick=\"window.location.href = '". $Row[1][1] ."'\" style='cursor:pointer;'";
                    }                      


                    print("<td" .  $Class . " " . $TDClick . ">" . $Item[0] . " </td>\n");
                }
                print("</tr>\n");
            }
        print("</tbody>\n");
        print("</table>\n");

        print("<script>
                function searchFunction() {
                if($('#dynamictable').val() != ''){
                        $('#clearSearch').show();
                }else{
                        $('#clearSearch').hide();
                }
                    var input, filter, table, tr, td, i;
                    input = document.getElementById('dynamictable');
                    filter = input.value.toUpperCase();
                    table = document.getElementById('".$ID."');
                    tr = table.getElementsByTagName('tr');

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName('td')[".$SearchColumn."];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                        } else {
                        tr[i].style.display = 'none';
                        }
                    }
                    }
                }
                </script>
                <script src='../js/jquery.tablesorter.min.js'></script>
                <script>
                    $(document).ready(function()
                        {
                            $(\"#".$ID."\").tablesorter({dateFormat: 'uk'});
                        }
                    );
                    $('.sortable_col').click(function(){
                        var colid = $(this).attr('id');
                        $('.sortable_col').css('background-color','#ddd');
                        $('#'+colid).css('background-color','#aaa');
                    });
                </script>");
    }
    static public function generatetabledisplay($ID,$Cols,$Rows)
    {
        print("<table class='table table-hover sorted_table' id='" . $ID . "'>\n");
        print("<tbody>");
            print("<tr>\n");
            foreach($Cols as $Col)
            {
                print("<th class='" . $Col[1] . "' colspan='" . $Col[2] . "'>" . $Col[0] . "</th>\n");
            }
            print("</tr>\n");
            if(!empty($Rows)){
                foreach($Rows as $Row)
                {
                    if($Row == null){ continue; }
                    print("<tr " . $Row[0][2] . " onclick=" . $Row[5] . ">\n");
                    foreach($Row as $Item)
                    {
                        if($Item[1])
                        {
                            $Class = " class = '" . $Item[1] . "' ";
                        }

                        print("<td" .  $Class . ">" . $Item[0] . "</td>\n");
                    }
                    print("</tr>\n");
                }
            }
        print("</tbody>\n");
        print("</table>\n");
    }

}

?>