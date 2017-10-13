<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!function_exists('barchart_colors')){
    function barchart_colors(){
        return $barChartColumnColurArray=array("FF0F00","FF6600","FF9E01","FCD202","F8FF01","B0DE09","04D215","0D8ECF","0D52D1","2A0CD0","8A0CCF","CD0D74");
    }
}

if(!function_exists("get_data_provider_for_bar_chart")){
    function get_data_provider_for_bar_chart($data,$categoryLable,$dataLabel){
        $dataProviderRawString="";
        $barChartColumnColurArray=barchart_colors();
        $colorKey=0;
        foreach($data AS $k=>$v){
            if(!array_key_exists($colorKey, $barChartColumnColurArray)){
                $colorKey=0;
            }
            if($dataProviderRawString==""){
                $dataProviderRawString='{';
                $dataProviderRawString.='"'.$categoryLable.'": "'.$v[0].'",
                        "'.$dataLabel.'": '.$v[1].',
                        "color": "#'.$barChartColumnColurArray[$colorKey].'"}';
            }else{
                $dataProviderRawString.=',{';
                $dataProviderRawString.='"'.$categoryLable.'": "'.$v[0].'",
                        "'.$dataLabel.'": '.$v[1].',
                        "color": "#'.$barChartColumnColurArray[$colorKey].'"}';
            }
            $colorKey++;
        }
        return $dataProviderRawString;
    }
}

if(!function_exists("generate_bar_chart")){
    function generate_bar_chart($data){
        if(empty($data)){
            //return "";
        }
        $divIndex=rand(10, 99);
        $dataProviderString="[".$data['data_provider']."]";
        //die($dataProviderString);
        ob_start();
        ?>
        <!-- Styles -->
        <style>
        #chartdiv<?php echo $divIndex;?> {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
        </style>

        <!-- Resources -->
        <script src="<?php echo base_url();?>assets/amcharts/amcharts.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/serial.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/light.js"></script>

        <!-- Chart code -->
        <script>
        var chart = AmCharts.makeChart("chartdiv<?php echo $divIndex;?>", {
          "type": "serial",
          "theme": "light",
          "marginRight": 70,
          "dataProvider": <?php echo $dataProviderString;?>,
          "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": ""
          }],
          "startDuration": 1,
          "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "<?php echo $data['data'];?>"
          }],
          "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
          },
          "categoryField": "<?php echo $data['category'];?>",
          "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
          },
          "export": {
            "enabled": true
          }

        });
        chart.addTitle("Current Session Master Data Overview");
        </script>

        <!-- HTML -->
        <div id="chartdiv<?php echo $divIndex;?>"></div>
        <?php
        $content=ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

if(!function_exists('generate_pai_chart')){
    function generate_pai_chart($data){
        $divIndex=rand(10, 99);
        $dataProviderString="[".$data['data_provider']."]";
        ob_start();
        ?>
        <!-- Styles -->
        <style>
        #chartdiv<?php echo $divIndex;?> {
          width: 100%;
          height: 500px;
        }
        </style>
        <script src="<?php echo base_url();?>assets/amcharts/amcharts.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/pie.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/light.js"></script>

        <!-- Chart code -->
        <script>
        var chart = AmCharts.makeChart( "chartdiv<?php echo $divIndex;?>", {
          "type": "pie",
          "theme": "light",
          "dataProvider": <?php echo $dataProviderString;?>,
          "valueField": "<?php echo $data['data'];?>",
          "titleField": "<?php echo $data['category'];?>",
           "balloon":{
           "fixedPosition":true
          },
          "export": {
            "enabled": true
          }
        } );
        chart.addTitle("<?php echo $data['paiChartTitle'];?>");
        </script>

        <!-- HTML -->
        <div id="chartdiv<?php echo $divIndex;?>"></div>
        <?php
        $content=ob_get_contents();
        ob_end_clean();
        return $content;
        
    }
}

if(!function_exists("get_data_provider_for_pai_chart")){
    function get_data_provider_for_pai_chart($data,$categoryLabel,$dataLabel){
        $dataProviderRawString="";
        foreach($data AS $k=>$v){
            if($dataProviderRawString==""){
                $dataProviderRawString='{';
                $dataProviderRawString.='"'.$categoryLabel.'": "'.$v[0].'",
                        "'.$dataLabel.'": '.$v[1].'}';
            }else{
                $dataProviderRawString.=',{';
                $dataProviderRawString.='"'.$categoryLabel.'": "'.$v[0].'",
                        "'.$dataLabel.'": '.$v[1].'}';
            }
        } //pre($dataProviderRawString);die;
        return $dataProviderRawString;
    }
}

if(!function_exists("get_column_line_mix_linner_chart_report")){
    function get_column_line_mix_linner_chart_report($data){
        $divIndex=rand(10, 99);
        $baseData=$data['baseData'];
        $baseRelatedData1=$data['baseRelatedData1'];
        $baseRelatedData2=$data['baseRelatedData2'];
            $dataProvider='['.$data['dataProvider'].']';
        //pre($data);die;
        ob_start();
        ?>
        <!-- Styles -->
        <style>
        #chartdiv1234 {
          width: 100%;
          height: 500px;
        }	
        </style>

        <!-- Resources -->
        <script src="<?php echo base_url();?>assets/amcharts/amcharts.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/serial.js"></script>
        <script src="<?php echo base_url();?>assets/amcharts/light.js"></script>

        <!-- Chart code -->
        <script>
        var chart = AmCharts.makeChart( "chartdiv1234", {
          "type": "serial",
          "addClassNames": true,
          "theme": "light",
          "autoMargins": false,
          "marginLeft": 30,
          "marginRight": 8,
          "marginTop": 10,
          "marginBottom": 26,
          "balloon": {
            "adjustBorderColor": false,
            "horizontalPadding": 10,
            "verticalPadding": 8,
            "color": "#ffffff"
          },

          "dataProvider": <?php echo $dataProvider;?>,
          "valueAxes": [ {
            "axisAlpha": 0,
            "position": "left"
          } ],
          "startDuration": 1,
          "graphs": [ {
            "alphaField": "alpha",
            "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
            "fillAlphas": 1,
            "title": "<?php echo $baseRelatedData1;?>",
            "type": "column",
            "valueField": "<?php echo strtolower($baseRelatedData1);?>",
            //"dashLengthField": "dashLengthColumn"
          }, {
            "id": "graph2",
            "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
            "bullet": "round",
            "lineThickness": 3,
            "bulletSize": 7,
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "useLineColorForBulletBorder": true,
            "bulletBorderThickness": 3,
            "fillAlphas": 0,
            "lineAlpha": 1,
            "title": "<?php echo $baseRelatedData2;?>",
            "valueField": "<?php echo strtolower($baseRelatedData2);?>",
            //"dashLengthField": "dashLengthLine"
          } ],
          "categoryField": "<?php echo strtolower($baseData);?>",
          "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
          },
          "export": {
            "enabled": true
          }
        } );
        chart.addTitle("<?php echo $data['chartTitle']; ?>");
        </script>

        <!-- HTML -->
        <div id="chartdiv1234"></div>																								
        <?php
        $content=ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

if(!function_exists("get_data_provider_for_column_line_mix_linner_chart")){
    function get_data_provider_for_column_line_mix_linner_chart($data,$baseData,$baseRelatedData1,$baseRelatedData2){
        $dataProviderStr="";
        foreach ($data AS $k => $v){
            if($dataProviderStr==""){
                $dataProviderStr='{
                    "'.$baseData.'": "'.$v['baseDataValue'].'",
                    "'.$baseRelatedData1.'": '.$v['baseRelatedData1Value'].',
                    "'.$baseRelatedData2.'": '.$v['baseRelatedData2Value'].'
                  }';
            }else{
                $dataProviderStr.=',{
                    "'.$baseData.'": "'.$v['baseDataValue'].'",
                    "'.$baseRelatedData1.'": '.$v['baseRelatedData1Value'].',
                    "'.$baseRelatedData2.'": '.$v['baseRelatedData2Value'].'
                  }';
            }
        }
        return $dataProviderStr;
    }
}